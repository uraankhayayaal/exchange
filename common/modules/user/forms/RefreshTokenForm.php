<?php

namespace common\modules\user\forms;

use common\base\forms\BaseForm;

final class RefreshTokenForm extends BaseForm
{
    /**
     * @var string
     */
    public $refreshToken;

    public function rules() : array
    {
        return [
            [
                'refreshToken',
                'required',
            ],
            [
                'refreshToken',
                'string',
                'max' => 255,
            ],
        ];
    }
}
