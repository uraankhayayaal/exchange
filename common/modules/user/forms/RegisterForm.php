<?php

namespace common\modules\user\forms;

use common\base\forms\BaseForm;
use common\modules\user\models\User;

final class RegisterForm extends BaseForm
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    public function rules() : array
    {
        return [
            [
                [
                    'username',
                    'email',
                    'password',
                ],
                'required',
            ],
            [
                [
                    'username',
                    'email',
                    'password',
                ],
                'string',
                'max' => 255,
            ],
            [
                'email',
                'email',
            ],
            [
                'username',
                'unique',
                'targetClass' => User::class,
            ],
            [
                'email',
                'unique',
                'targetClass' => User::class,
            ],
        ];
    }
}
