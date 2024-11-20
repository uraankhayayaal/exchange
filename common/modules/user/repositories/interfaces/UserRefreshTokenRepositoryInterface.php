<?php

namespace common\modules\user\repositories\interfaces;

use common\base\repositories\interfaces\BaseRepositoryInterface;
use common\modules\user\models\UserRefreshToken;

interface UserRefreshTokenRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveUserRefreshTokenByRefreshToken(string $refreshToken): ?UserRefreshToken;
}
