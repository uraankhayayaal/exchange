<?php

namespace common\base\services;

use Yii;
use yii\web\HttpException;

/**
 * Class BaseService
 */
abstract class BaseService
{
    /**
     * @param array $messages
     * @param string $category
     *
     * @return void
     */
    protected function errorValidate(array $messages, string $category) : void
    {
        Yii::error($messages, $category);

        throw new HttpException(
            422, json_encode($messages, JSON_UNESCAPED_UNICODE)
        );
    }
}