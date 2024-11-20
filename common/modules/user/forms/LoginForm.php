<?php

namespace common\modules\user\forms;

use common\base\forms\BaseForm;
use common\modules\user\repositories\interfaces\UserRepositoryInterface;
use Yii;

final class LoginForm extends BaseForm
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    public function rules(): array
    {
        return [
            [
                [
                    'email',
                    'password',
                ],
                'required',
            ],
            [
                [
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
                'password',
                'validatePassword',
            ],
        ];
    }

    public function validatePassword(string $attribute): void
    {
        $hasErrors = $this->hasErrors();

        if ($hasErrors) {
            return;
        }

        $user = Yii::$container->get(UserRepositoryInterface::class)->getActiveUserByEmail($this->email);

        if (is_null($user) || $user->validatePassword($this->password) === false) {
            $this->addError($attribute, 'Incorrect email or password.');
        }
    }
}
