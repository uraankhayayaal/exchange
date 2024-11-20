<?php

namespace common\modules\exchange\factories;

use common\modules\exchange\clients\dto\RateDTO;
use common\modules\exchange\models\Rate;
use Yii;

class RateFactory
{
    const COMMISSION_PERCENT = 2;

    static public function createRateFromRateDTO(RateDTO $rateDTO): Rate
    {
        $rate = new Rate();
        $rate->symbol = $rateDTO->symbol;
        $rate->rateUsd = self::getRateAfterCommission($rateDTO->rateUsd);
        return $rate;
    }

    static private function getRateAfterCommission(float $value): float
    {
        return $value - ($value * self::COMMISSION_PERCENT / 100);
    }
}
