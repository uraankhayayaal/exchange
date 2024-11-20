<?php

namespace common\modules\exchange\services\interfaces;

use common\modules\exchange\forms\ConvertForm;
use common\modules\exchange\responses\ConvertDataResponse;
use yii\data\DataProviderInterface;

interface ExchangeServiceInterface
{
    public function getAll(string $filter): DataProviderInterface;

    public function convert(ConvertForm $convertForm): ConvertDataResponse;
}
