<?php

namespace common\modules\exchange;

use common\base\modules\BaseModule;
use common\modules\exchange\services\ExchangeService;
use common\modules\exchange\services\interfaces\ExchangeServiceInterface;

class Module extends BaseModule
{
    protected function bindServices(): void
    {
        $this->getContainer()->set(ExchangeServiceInterface::class, ExchangeService::class);
    }
}
