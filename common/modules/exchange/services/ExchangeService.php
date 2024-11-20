<?php

namespace common\modules\exchange\services;

use common\base\services\BaseService;
use common\modules\exchange\clients\CoincapClient;
use common\modules\exchange\clients\dto\RateDTO;
use common\modules\exchange\enums\CurrencyEnum;
use common\modules\exchange\enums\СonvertDirectionEnum;
use common\modules\exchange\factories\RateFactory;
use common\modules\exchange\filters\RateFilter;
use common\modules\exchange\services\interfaces\ExchangeServiceInterface;
use common\modules\exchange\forms\ConvertForm;
use common\modules\exchange\models\Rate;
use common\modules\exchange\responses\ConvertDataResponse;
use yii\data\DataProviderInterface;

class ExchangeService extends BaseService implements ExchangeServiceInterface
{
    public function getAll(?string $filter = null): DataProviderInterface
    {
        $data = $this->getRates();

        return (new RateFilter())->getDataProvider($data, $filter);
    }

    public function convert(ConvertForm $convertForm): ConvertDataResponse
    {
        $data = $this->getRates();

        $convertDirection = $this->getConvertDirectionFromForm($convertForm);
        $currentRate = $this->getCurrentRateFromForm($data, $convertForm);

        $converted_value = number_format(
            $convertDirection == СonvertDirectionEnum::DIRECT
                ? $convertForm->value * $currentRate->rateUsd
                : $convertForm->value / $currentRate->rateUsd,
            CurrencyEnum::tryFrom($convertForm->currency_to) === CurrencyEnum::BTC
                ? 10
                : 2,
            '.',
            '',
        );

        return new ConvertDataResponse(
            currency_from: $convertForm->currency_from,
            currency_to: $convertForm->currency_to,
            value: $convertForm->value,
            rate: number_format(
                $currentRate->rateUsd,
                CurrencyEnum::tryFrom($convertForm->currency_to) === CurrencyEnum::BTC
                    ? 10
                    : 2,
                '.',
                '',
            ),
            converted_value: $converted_value,
        );
    }

    /**
     * @return array<array-key,Rate>
     */
    private function getRates(): array
    {
        $data = (new CoincapClient())->getRates();

        $data = array_map(function (RateDTO $rate) {
            return RateFactory::createRateFromRateDTO($rate);
        }, $data);

        return $data;
    }

    /**
     * @param array<array-key,Rate> $data
     */
    private function getCurrentRateFromForm(array $data, ConvertForm $convertForm): Rate
    {
        $currentRate = current(array_filter($data, function (Rate $rate) use ($convertForm, &$convertDirection) {
            if (CurrencyEnum::tryFrom($convertForm->currency_from) === CurrencyEnum::USD) {
                $convertDirection = СonvertDirectionEnum::REVERSE;
                return $rate->symbol === $convertForm->currency_to;
            } else {
                $convertDirection = СonvertDirectionEnum::DIRECT;
                return $rate->symbol === $convertForm->currency_from;
            }
        }));

        return $currentRate;
    }

    private function getConvertDirectionFromForm(ConvertForm $convertForm): СonvertDirectionEnum
    {
        return CurrencyEnum::tryFrom($convertForm->currency_from) === CurrencyEnum::USD
            ? СonvertDirectionEnum::REVERSE
            : СonvertDirectionEnum::DIRECT;
    }
}
