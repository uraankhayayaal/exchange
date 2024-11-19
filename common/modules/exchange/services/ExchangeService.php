<?php

namespace common\modules\exchange\services;

use common\base\services\BaseService;
use common\modules\exchange\clients\CoincapClient;
use common\modules\exchange\clients\dto\Rate;
use common\modules\exchange\services\interfaces\ExchangeServiceInterface;
use common\modules\exchange\forms\ConvertForm;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

class ExchangeService extends BaseService implements ExchangeServiceInterface
{
    const COMMISSION_PERCENT = 2;
    /**
     * @param string $filter
     */
    public function getRates(?string $filter = null): array
    {
        $data = (new CoincapClient())->getRates();

        if ($filter !== null) {
            $filters = explode(',', $filter); // TODO: Нужна валидация или просто проверка
            $data = array_filter($data, static function (Rate $rate) use ($filters) {
                return in_array($rate->symbol, $filters);
            });
        }

        $data = array_map(function (Rate $rate) {
            $rate->rateUsd = $this->getRateAfterCommission($rate->rateUsd);
            return $rate;
        }, $data);

        usort($data, static function (Rate $a, Rate $b) {
            return ($a->rateUsd <=> $b->rateUsd);
        });

        $allRates = ArrayHelper::map($data, 'symbol', 'rateUsd');

        return $allRates;
    }

    public function convert(ConvertForm $convertForm): array
    {
        return [];
    }

    private function getRateAfterCommission(float $value): float
    {
        return $value - ($value * self::COMMISSION_PERCENT / 100);
    }
}