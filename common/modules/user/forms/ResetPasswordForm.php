<?php

namespace common\modules\user\forms;

use common\base\forms\BaseForm;
use common\modules\user\models\User;

final class ResetPasswordForm extends BaseForm
{
    /**
     * @var string
     */
    public $passwordResetToken;

    /**
     * @var string
     */
    public $password;

    public function rules(): array
    {
        return [
            [
                [
                    'passwordResetToken',
                    'password',
                ],
                'required',
            ],
            [
                [
                    'passwordResetToken',
                    'password',
                ],
                'string',
                'max' => 255,
            ],
            [
                'passwordResetToken',
                'exist',
                'targetClass' => User::class,
                'targetAttribute' => 'password_reset_token',
            ],
        ];
    }
}
