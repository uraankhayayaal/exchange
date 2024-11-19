<?php

namespace common\modules\user\repositories\interfaces;

use common\base\repositories\interfaces\BaseRepositoryInterface;
use common\modules\user\models\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findIdentityById(int $id) : ?User;

    public function getActiveUserByPasswordResetToken(string $passwordResetToken) : ?User;

    public function getUnconfirmedUserByEmailConfirmToken(string $emailConfirmToken) : ?User;

    public function getActiveUserByEmail(string $email) : ?User;
}