<?php

namespace common\modules\user\factories;

use common\models\User;
use common\modules\user\forms\UserForm;
use Yii;

class UserFormFactory
{
    public static function getUserFormFromEmail(string $email)
    {
        $userForm = new UserForm();
        $userForm->username = $email;
        $userForm->email = $email;
        $userForm->password = Yii::$app->security->generateRandomString(8);
        $userForm->status = User::STATUS_ACTIVE;
        return $userForm;
    }
}
