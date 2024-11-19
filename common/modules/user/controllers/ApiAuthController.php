<?php

namespace common\modules\user\controllers;

use common\modules\user\controllers\interfaces\ApiAuthControllerInterface;
use common\modules\user\services\interfaces\AuthServiceInterface;
use common\modules\user\responses\TokenResponseData;
use common\modules\user\responses\UserResponseData;
use common\base\controllers\BaseApiController;
use common\base\responses\BaseResponseData;
use common\modules\user\forms\LoginForm;
use common\modules\user\forms\RegisterForm;
use common\modules\user\forms\ForgotPasswordForm;
use common\modules\user\forms\ResetPasswordForm;
use common\modules\user\forms\RefreshTokenForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

final class ApiAuthController extends BaseApiController implements ApiAuthControllerInterface
{

    public function behaviors() : array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'login',
                            'register',
                            'confirm',
                            'forgot-password',
                            'reset-password',
                            'refresh-token',
                        ],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'validate-token',
                        ],
                        'roles' => [
                            '@',
                        ],
                    ],
                ],
            ],
            'authenticator' => [
                'optional' => [
                    'login',
                    'register',
                    'confirm',
                    'forgot-password',
                    'reset-password',
                    'refresh-token',
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'login' => [
                        'POST',
                    ],
                    'register' => [
                        'POST',
                    ],
                    'confirm' => [
                        'GET',
                    ],
                    'forgot-password' => [
                        'POST',
                    ],
                    'reset-password' => [
                        'POST',
                    ],
                    'validate-token' => [
                        'POST',
                    ],
                    'refresh-token' => [
                        'POST',
                    ],
                ],
            ],
        ]);
    }

    public function actionLogin() : array
    {
        $loginForm = new LoginForm();

        $loginForm->attributes = Yii::$app->request->post();

        $isValid = $loginForm->validate();

        if ($isValid) {
            $data = Yii::$container->get(AuthServiceInterface::class)->login($loginForm);
        } else {
            return BaseResponseData::error($loginForm);
        }

        return TokenResponseData::success($data);
    }

    public function actionRegister() : array
    {
        $registerForm = new RegisterForm();

        $registerForm->attributes = Yii::$app->request->post();

        $isValid = $registerForm->validate();

        if ($isValid) {
            $data = Yii::$container->get(AuthServiceInterface::class)->register($registerForm);
        } else {
            return BaseResponseData::error($registerForm);
        }

        return UserResponseData::success($data);
    }

    public function actionConfirm() : array
    {
        $hash = Yii::$app->getRequest()->getQueryParam('hash');

        $data = Yii::$container->get(AuthServiceInterface::class)->confirm($hash);

        return UserResponseData::success($data);
    }

    public function actionForgotPassword() : array
    {
        $forgotPasswordForm = new ForgotPasswordForm();

        $forgotPasswordForm->attributes = Yii::$app->request->post();

        $isValid = $forgotPasswordForm->validate();

        if ($isValid) {
            $data = Yii::$container->get(AuthServiceInterface::class)->forgotPassword($forgotPasswordForm);
        } else {
            return BaseResponseData::error($forgotPasswordForm);
        }

        return UserResponseData::success($data);
    }

    public function actionResetPassword() : array
    {
        $resetPasswordForm = new ResetPasswordForm();

        $resetPasswordForm->attributes = Yii::$app->request->post();

        $isValid = $resetPasswordForm->validate();

        if ($isValid) {
            $data = Yii::$container->get(AuthServiceInterface::class)->resetPassword($resetPasswordForm);
        } else {
            return BaseResponseData::error($resetPasswordForm);
        }

        return UserResponseData::success($data);
    }

    public function actionValidateToken() : array
    {
        return UserResponseData::success(Yii::$app->user->identity);
    }

    public function actionRefreshToken() : array
    {
        $refreshTokenForm = new RefreshTokenForm();

        $refreshTokenForm->attributes = Yii::$app->request->post();

        $isValid = $refreshTokenForm->validate();

        if ($isValid) {
            $data = Yii::$container->get(AuthServiceInterface::class)->refreshToken($refreshTokenForm);
        } else {
            return BaseResponseData::error($refreshTokenForm);
        }

        return TokenResponseData::success($data);
    }
}