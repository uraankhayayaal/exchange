<?php

namespace common\modules\user\repositories;

use common\base\repositories\BaseRepository;
use common\modules\user\repositories\interfaces\UserRepositoryInterface;
use common\modules\user\models\User;

final class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModelClass() : string
    {
        return User::class;
    }

    public function findIdentityById(int $id) : ?User
    {
        return User::findOne([
            'id' => $id,
            'status' => User::STATUS_ACTIVE,
        ]);
    }

    public function getActiveUserByPasswordResetToken(string $passwordResetToken) : ?User
    {
        return User::findOne([
            'password_reset_token' => $passwordResetToken,
            'status' => User::STATUS_ACTIVE,
        ]);
    }

    public function getUnconfirmedUserByEmailConfirmToken(string $emailConfirmToken) : ?User
    {
        return User::findOne([
            'email_confirm_token' => $emailConfirmToken,
            'status' => User::STATUS_UNCONFIRMED,
        ]);
    }

    public function getActiveUserByEmail(string $email) : ?User
    {
        return User::findOne([
            'email' => $email,
            'status' => User::STATUS_ACTIVE,
        ]);
    }
}
