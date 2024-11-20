<?php

namespace common\modules\user\services\interfaces;

use common\modules\user\forms\UserForm;
use common\models\User;

interface UserServiceInterface
{
    public function create(UserForm $userForm): User;

    public function getOneByEmail(string $email): ?User;

    public function sendEmail(User $user, string $password): void;
}
