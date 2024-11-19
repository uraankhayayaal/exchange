<?php

namespace common\modules\user\repositories;

use common\base\repositories\BaseRepository;
use common\modules\user\models\User;
use common\modules\user\models\UserRefreshToken;
use common\modules\user\repositories\interfaces\UserRefreshTokenRepositoryInterface;

final class UserRefreshTokenRepository extends BaseRepository implements UserRefreshTokenRepositoryInterface
{
    public function getModelClass() : string
    {
        return UserRefreshToken::class;
    }

    public function getActiveUserRefreshTokenByRefreshToken(string $refreshToken) : ?UserRefreshToken
    {
        return UserRefreshToken::find()->joinWith('user')->where([
            'refresh_token' => $refreshToken,
            'status' => User::STATUS_ACTIVE,
        ])->one();
    }
}
