<?php

namespace common\modules\user\services;

use common\base\services\BaseService;
use common\modules\user\services\interfaces\UserServiceInterface;
use common\modules\user\forms\UserForm;
use common\models\User;
use LogicException;
use Yii;

/**
 * Class UserService
 */
class UserService extends BaseService implements UserServiceInterface
{
    /**
     * @inheritDoc
     */
    public function getOneByEmail(string $email): ?User
    {
        return User::find()->where(['email' => $email])->one();
    }

    /**
     * @inheritDoc
     */
    public function create(UserForm $userForm): User
    {
        $user = new User();
        $user->username = $userForm->username;
        $user->email = $userForm->email;
        $user->status = $userForm->status;
        $user->setPassword($userForm->password);
        $user->generateAuthKey();
        if (!$user->save()) {
            throw new LogicException("Error to create User: " . json_encode($user->errors));
        };

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function sendEmail(User $user, string $password): void
    {
        Yii::$app->mailer
            ->compose(
                ['html' => 'user-create-html', 'text' => 'user-create-text'],
                ['model' => $user, 'password' => $password]
            )
            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name . ' robot'])
            ->setTo([$user->email])
            ->setSubject('Ваш личный кабинет на сайте ' . Yii::$app->name)
            ->send();
    }
}
