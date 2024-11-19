<?php

namespace common\modules\user;

use common\base\modules\BaseModule;
use common\modules\user\repositories\interfaces\UserRefreshTokenRepositoryInterface;
use common\modules\user\repositories\interfaces\UserRepositoryInterface;
use common\modules\user\repositories\UserRefreshTokenRepository;
use common\modules\user\repositories\UserRepository;
use common\modules\user\services\AuthService;
use common\modules\user\services\UserService;
use common\modules\user\services\interfaces\AuthServiceInterface;
use common\modules\user\services\interfaces\UserServiceInterface;

class Module extends BaseModule
{
    /**
     * @inheritDoc
     */
    protected function bindRepositories() : void
    {
        $this->getContainer()->set(UserRefreshTokenRepositoryInterface::class, UserRefreshTokenRepository::class);
        $this->getContainer()->set(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * @inheritDoc
     */
    protected function bindServices() : void
    {
        $this->getContainer()->set(AuthServiceInterface::class, AuthService::class);
        $this->getContainer()->set(UserServiceInterface::class, UserService::class);
    }
}