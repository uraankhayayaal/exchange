<?php

namespace common\modules\user\services\interfaces;

use common\modules\user\forms\ForgotPasswordForm;
use common\modules\user\forms\LoginForm;
use common\modules\user\forms\RefreshTokenForm;
use common\modules\user\forms\RegisterForm;
use common\modules\user\forms\ResetPasswordForm;
use common\modules\user\models\User;

interface AuthServiceInterface
{
    public function login(LoginForm $loginForm) : array;

    public function generateAccessToken(User $user) : string;

    public function generateRefreshToken(User $user) : string;

    public function register(RegisterForm $registerForm) : User;

    public function sendUrlForConfirmByMail(User $user) : bool;

    public function getUrlForConfirm(string $emailConfirmToken) : string;

    public function confirm(string $emailConfirmToken) : User;

    public function forgotPassword(ForgotPasswordForm $forgotPasswordForm) : User;

    public function sendUrlForResetPasswordByMail(User $user) : bool;

    public function getUrlForResetPassword(string $passwordResetToken) : string;

    public function resetPassword(ResetPasswordForm $resetPasswordForm) : User;

    public function findIdentityByAccessToken(string $token, string $type = null) : ?User;

    public function refreshToken(RefreshTokenForm $refreshTokenForm) : array;
}
