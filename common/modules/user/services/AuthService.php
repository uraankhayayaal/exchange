<?php

namespace common\modules\user\services;

use common\modules\user\forms\ForgotPasswordForm;
use common\modules\user\forms\LoginForm;
use common\modules\user\forms\RefreshTokenForm;
use common\modules\user\forms\RegisterForm;
use common\modules\user\forms\ResetPasswordForm;
use common\modules\user\models\User;
use common\modules\user\models\UserRefreshToken;
use common\modules\user\repositories\interfaces\UserRefreshTokenRepositoryInterface;
use common\modules\user\repositories\interfaces\UserRepositoryInterface;
use common\modules\user\services\interfaces\AuthServiceInterface;
use DateTimeImmutable;
use yii\web\HttpException;
use Yii;

final class AuthService implements AuthServiceInterface
{
    private $sourceName = 'erp';

    private UserRefreshTokenRepositoryInterface $userRefreshTokenRepository;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRefreshTokenRepositoryInterface $userRefreshTokenRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->userRefreshTokenRepository = $userRefreshTokenRepository;
        $this->userRepository = $userRepository;
    }

    public function login(LoginForm $loginForm): array
    {
        $user = $this->userRepository->getActiveUserByEmail($loginForm->email);

        if ($user === null) {
            throw new HttpException(404, 'User not found.');
        }

        $accessToken = $this->generateAccessToken($user);

        $refreshToken = $this->generateRefreshToken($user);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ];
    }

    public function generateAccessToken(User $user): string
    {
        $expiresAt = (new DateTimeImmutable())->modify('+12 hours');

        $builder = Yii::$app->jwt->getBuilder()->withClaim('uid', $user->id);

        $builder->issuedBy($this->sourceName)->relatedTo($user->id)->expiresAt($expiresAt);

        $token = $builder->getToken(
            Yii::$app->jwt->getConfiguration()->signer(),
            Yii::$app->jwt->getConfiguration()->signingKey()
        );

        return $token->toString();
    }

    public function generateRefreshToken(User $user): string
    {
        $userRefreshToken = new UserRefreshToken();

        $userRefreshToken->user_id = $user->id;

        $userRefreshToken->setExpiredAt();
        $userRefreshToken->generateRefreshToken();

        $this->userRefreshTokenRepository->create($userRefreshToken->attributes);

        return $userRefreshToken->refresh_token;
    }

    public function register(RegisterForm $registerForm): User
    {
        $user = Yii::$app->db->transaction(function () use ($registerForm) {
            $user = new User();

            $user->load($registerForm->attributes, '');

            $user->setPasswordHash($registerForm->password);
            $user->generateAuthKey();
            $user->generateEmailConfirmToken();

            return $this->userRepository->create($user->attributes);
        });

        if ($user) {
            $this->sendUrlForConfirmByMail($user);
        }

        return $user;
    }

    public function sendUrlForConfirmByMail(User $user): bool
    {
        $message = Yii::$app->getMailer()->compose();

        $message->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name . ' robot']);
        $message->setTo($user->email);
        $message->setSubject('Registration: Mail confirmation');

        $urlForConfirm = $this->getUrlForConfirm($user->email_confirm_token);

        $message->setTextBody('Follow the link to confirm: ' . $urlForConfirm);

        return $message->send();
    }

    public function getUrlForConfirm(string $emailConfirmToken): string
    {
        $params = [
            'activate-account',
            'hash' => $emailConfirmToken,
        ];

        return Yii::$app->urlManager->createAbsoluteUrl($params);
    }

    public function confirm(string $emailConfirmToken): User
    {
        $user = $this->userRepository->getUnconfirmedUserByEmailConfirmToken($emailConfirmToken);

        if ($user === null) {
            throw new HttpException(404, 'The user with this email confirm token was not found.');
        }

        $attributes = [
            'status' => User::STATUS_ACTIVE,
            'email_confirm_token' => null,
        ];

        return $this->userRepository->update($user, $attributes);
    }

    public function forgotPassword(ForgotPasswordForm $forgotPasswordForm): User
    {
        $user = $this->userRepository->getActiveUserByEmail($forgotPasswordForm->email);

        if ($user === null) {
            throw new HttpException(404, 'The user with this email was not found.');
        }

        $user->generatePasswordResetToken();

        return Yii::$app->db->transaction(function () use ($user) {
            $this->sendUrlForResetPasswordByMail($user);

            return $this->userRepository->update($user, $user->attributes); // TODO: Return in not to be User
        });
    }

    public function sendUrlForResetPasswordByMail(User $user): bool
    {
        $message = Yii::$app->getMailer()->compose();

        $message->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name . ' robot']);
        $message->setTo($user->email);
        $message->setSubject('Reset password');

        $urlForResetPassword = $this->getUrlForResetPassword($user->password_reset_token);

        $message->setTextBody('Follow the link to reset password: ' . $urlForResetPassword);

        return $message->send();
    }

    public function getUrlForResetPassword(string $passwordResetToken): string
    {
        $params = [
            'new-password',
            'hash' => $passwordResetToken,
        ];

        return Yii::$app->urlManager->createAbsoluteUrl($params);
    }

    public function resetPassword(ResetPasswordForm $resetPasswordForm): User
    {
        $user = $this->userRepository->getActiveUserByPasswordResetToken($resetPasswordForm->passwordResetToken);

        if ($user === null) {
            throw new HttpException(404, 'The user with this password reset token was not found.');
        }

        $user->setPasswordHash($resetPasswordForm->password);

        $attributes = [
            'password_reset_token' => null,
        ];

        return Yii::$app->db->transaction(function () use ($user, $attributes) {
            return $this->userRepository->update($user, $attributes);
        });
    }

    public function findIdentityByAccessToken(string $token, string $type = null): ?User
    {
        $parsedToken = Yii::$app->jwt->parse($token);

        if (Yii::$app->jwt->validate($parsedToken) === false) {
            throw new HttpException(403, 'The token is not valid.');
        }

        $id = $parsedToken->claims()->get('uid');

        return $this->userRepository->findIdentityById($id);
    }

    public function refreshToken(RefreshTokenForm $refreshTokenForm): array
    {
        $userRefreshToken = $this->userRefreshTokenRepository->getActiveUserRefreshTokenByRefreshToken($refreshTokenForm->refreshToken);

        if ($userRefreshToken === null) {
            throw new HttpException(404, 'The user with this refresh token was not found.');
        }

        $isExpired = $userRefreshToken->isExpired();

        if ($isExpired) {
            throw new HttpException(498, 'Refresh token invalid.');
        }

        $accessToken = $this->generateAccessToken($userRefreshToken->user);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $userRefreshToken->refresh_token,
        ];
    }
}
