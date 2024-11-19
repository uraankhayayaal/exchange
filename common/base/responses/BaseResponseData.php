<?php

namespace common\base\responses;

use Yii;
use yii\base\Model;
use yii\data\DataProviderInterface;

abstract class BaseResponseData
{
    public const STATUS_SUCCESS = 'success';
    public const STATUS_VALIDATION_ERROR = 'error';

    public static function success($data) : array
    {
        $result = [
            'status' => self::STATUS_SUCCESS,
        ];

        if ($data instanceof DataProviderInterface) {
            $result += [
                'data' => static::render($data->models),
                'meta' => [
                    'totalCount' => $data->getTotalCount(),
                    'pageCount' => $data->getPagination()->getPageCount(),
                    'page' => $data->getPagination()->getPage() + 1,
                    'pageSize' => $data->getPagination()->getPageSize(),
                ],
                'links' => $data->getPagination()->getLinks(),
            ];
        } else {
            $result['data'] = static::render($data);
        }

        return $result;
    }

    public static function error(Model $data) : array
    {
        Yii::$app->response->statusCode = 422;

        return [
            'status' => self::STATUS_VALIDATION_ERROR,
            'data' => $data->getFirstErrors(),
        ];
    }

    abstract public static function render(mixed $data) : mixed;

    protected static function getImageUrlWithDomain(?string $url): ?string
    {
        if ($url === null) {
            return null;
        }

        return strpos($url, "://")
            ? $url
            : (Yii::$app->params['domain'] . $url);
    }
}
