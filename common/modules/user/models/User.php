<?php

namespace common\modules\user\models;

use common\modules\user\behaviors\UserObserverBehavior;
use common\models\User as BaseUser;
use yii\helpers\ArrayHelper;
use Yii;

final class User extends BaseUser
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            UserObserverBehavior::class,
        ]);
    }

    public function rules()
    {
        return [
            [
                [
                    'username',
                    'email',
                    'auth_key',
                    'password_hash',
                ],
                'required',
            ],
            [
                [
                    'username',
                    'email',
                    'password_hash',
                    'password_reset_token',
                    'email_confirm_token',
                    'verification_token',
                ],
                'string',
                'max' => 255,
            ],
            [
                'auth_key',
                'string',
                'max' => 255,
            ],
            [
                'email',
                'email',
            ],
            [
                'status',
                'default',
                'value' => self::STATUS_UNCONFIRMED,
            ],
            [
                'status',
                'in',
                'range' => [
                    self::STATUS_ACTIVE,
                    self::STATUS_UNCONFIRMED,
                    self::STATUS_INACTIVE,
                    self::STATUS_DELETED,
                ],
            ],
            [
                'username',
                'unique',
            ],
            [
                'email',
                'unique',
            ],
            [
                'password_reset_token',
                'unique',
            ],
            [
                'email_confirm_token',
                'unique',
            ],
            [
                'verification_token',
                'unique',
            ],
        ];
    }

    public function setPasswordHash(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateEmailConfirmToken(): void
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString(64);
    }
}
