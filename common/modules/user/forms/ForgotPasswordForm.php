<?php

namespace common\modules\user\forms;

use common\base\forms\BaseForm;
use common\modules\user\models\User;

final class ForgotPasswordForm extends BaseForm
{
    /**
     * @var string
     */
    public $email;

    public function rules(): array
    {
        return [
            [
                'email',
                'required',
            ],
            [
                'email',
                'string',
                'max' => 255,
            ],
            [
                'email',
                'email',
            ],
            [
                'email',
                'exist',
                'targetClass' => User::class,
            ],
        ];
    }
}
