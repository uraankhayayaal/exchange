<?php

namespace common\modules\exchange\forms;

use common\modules\exchange\enums\CurrencyEnum;
use yii\base\Model;

class ConvertForm extends Model
{
    /**
     * @var string
     */
    public $currency_from;

    /**
     * @var string
     */
    public $currency_to;
    
    /**
     * @var float
     */
    public $value;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            [
                [
                    'currency_from',
                    'currency_to',
                    'value',
                ],
                'required',
            ],
            [
                [
                    'currency_from',
                    'currency_to',
                ],
                'string',
                'max' => 30,
            ],
            [
                [
                    'value',
                ],
                'number',
                'min' => 0.01,
            ],
            [
                'value',
                'match',
                'pattern' => '/^[0-9]{1,12}(\.[0-9]{0,2})?$/',
                'when' => function($model) {
                    return CurrencyEnum::tryFrom($model->currency_from) !== CurrencyEnum::BTC;
                },
                'message' => 'Для конвертации нужно указать точность до 2 знаков(в формате 0.01)',
            ],
            [
                'value',
                'match',
                'pattern' => '/^[0-9]{1,12}(\.[0-9]{10})?$/',
                'when' => function($model) {
                    return CurrencyEnum::tryFrom($model->currency_from) === CurrencyEnum::BTC;
                },
                'message' => 'Для конвертации из BTC нужно указать точность до 10 знаков(в формате 0.0000000001)',
            ],
            [
                [
                    'currency_from',
                    'currency_to',
                ],
                'isOneOfCurrencyIsUSD',
            ],
        ];
    }

    public function isOneOfCurrencyIsUSD($attribute, $params, $validator)
    {
        if ($this->currency_from === $this->currency_to) {
            $this->addError($attribute, 'Для конвертации валюты должны быть разные');
        }

        $isFromIsUSD = CurrencyEnum::tryFrom($this->currency_from) === CurrencyEnum::USD;
        $isToIsUSD = CurrencyEnum::tryFrom($this->currency_to) === CurrencyEnum::USD;

        if (!$isFromIsUSD && !$isToIsUSD) {
            $this->addError($attribute, 'Для конвертации одни валют должны быть USD');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'currency_from' => 'Currency from',
            'currency_to' => 'Currency to',
            'value' => 'Value',
        ];
    }
}