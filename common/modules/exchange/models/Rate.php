<?php

namespace common\modules\exchange\models;

class Rate extends \yii\base\Model
{
    /**
     * @var string
     */
    public $symbol;

    /**
     * @var float
     */
    public $rateUsd;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'symbol',
                    'rateUsd',
                ],
                'required',
            ],
            [
                'symbol',
                'string',
            ],
            [
                'rateUsd',
                'decimal',
            ],
        ];
    }
}
