<?php

namespace common\modules\exchange\responses;

use common\base\responses\BaseResponseData;

final class ConvertDataResponse
{
    public function __construct(
        private string $currency_from,
        private string $currency_to,
        private float $value,
        private string $rate,
        private string $converted_value,
    ) {}

    public function format(): array
    {
        return [
            'currency_from' => $this->currency_from,
            'currency_to' => $this->currency_to,
            'value' => $this->value,
            'rate' => $this->rate,
            'converted_value' => $this->converted_value,
        ];
    }
}
