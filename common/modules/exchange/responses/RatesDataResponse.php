<?php

namespace common\modules\exchange\responses;

use common\base\responses\BaseResponseData;

final class RatesDataResponse extends BaseResponseData
{
    public static function render(mixed $data): mixed
    {
        if (empty($data)) {
            return $data;
        }

        return $data;
    }
}
