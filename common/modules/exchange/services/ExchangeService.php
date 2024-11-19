<?php

namespace common\modules\exchange\services;

use common\base\services\BaseService;
use common\modules\exchange\services\interfaces\ExchangeServiceInterface;
use common\modules\exchange\forms\ConvertForm;

class ExchangeService extends BaseService implements ExchangeServiceInterface
{
    public function getRates(): array
    {
        return [];
    }

    public function convert(ConvertForm $convertForm): array
    {
        return [];
    }
}