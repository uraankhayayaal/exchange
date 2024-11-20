<?php

namespace common\modules\exchange\clients\dto;

class RateDTO
{
    public function __construct(
        public string $id,
        public string $symbol,
        public null|string $currencySymbol,
        public string $type,
        public float $rateUsd,
    ) {}
}