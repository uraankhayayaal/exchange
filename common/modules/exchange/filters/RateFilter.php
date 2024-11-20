<?php

namespace common\modules\exchange\filters;

use common\modules\exchange\models\Rate;
use yii\data\ArrayDataProvider;
use yii\data\DataProviderInterface;

class RateFilter
{
    public function getDataProvider(array $data, ?string $filter = null): DataProviderInterface
    {
        return new ArrayDataProvider([
            'allModels' => $this->getFilteredQuery($data, $filter),
            'sort' => [
                'attributes' => [
                    'rateUsd' => [
                        'default' => SORT_DESC,
                    ],
                ],
                'defaultOrder' => [
                    'rateUsd' => SORT_DESC,
                ],
            ],
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
    }

    public function getFilteredQuery(array $data, ?string $filter = null): array
    {
        if ($filter !== null) {
            $filters = explode(',', $filter); // TODO: Нужна валидация или просто проверка
            $data = array_filter($data, static function (Rate $rate) use ($filters) {
                return in_array($rate->symbol, $filters, true);
            });
        }

        return $data;
    }
}
