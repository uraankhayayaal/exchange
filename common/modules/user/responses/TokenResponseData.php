<?php

namespace common\modules\user\responses;

use common\base\responses\BaseResponseData;

final class TokenResponseData extends BaseResponseData
{
    public static function render(mixed $data) : mixed
    {
        return [
            'accessToken' => $data['access_token'],
            'refreshToken' => $data['refresh_token'],
        ];
    }
}
