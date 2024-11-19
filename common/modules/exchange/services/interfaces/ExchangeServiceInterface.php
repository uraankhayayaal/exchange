<?php

namespace common\modules\exchange\services\interfaces;

use common\modules\exchange\forms\ConvertForm;

interface ExchangeServiceInterface
{
    public function getRates() : array;

    public function convert(ConvertForm $convertForm) : array;
}