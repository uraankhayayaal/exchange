<?php

namespace common\base\responses;

use Yii;
use yii\base\Model;
use yii\data\DataProviderInterface;

abstract class BaseResponseData
{
    public const CODE_SUCCESS = 200;
    public const CODE_ERROR = 422;
    public const CODE_FORBIDDEN = 403;
    public const STATUS_SUCCESS = 'success';
    public const STATUS_ERROR = 'error';

    public static function success($data) : array
    {
        $result = [
            'status' => self::STATUS_SUCCESS,
            'code' => self::CODE_SUCCESS,
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
            'status' => self::STATUS_ERROR,
            'code' => self::CODE_ERROR,
            'data' => $data->getFirstErrors(),
        ];
    }

    public static function errorMessage(string $message) : array
    {
        Yii::$app->response->statusCode = 500;

        return [
            'status' => self::STATUS_ERROR,
            'code' => self::CODE_ERROR,
            'data' => $message,
        ];
    }

    public static function forbidden(string $message) : array
    {
        Yii::$app->response->statusCode = self::CODE_FORBIDDEN;

        return [
            'status' => self::STATUS_ERROR,
            'code' => self::CODE_FORBIDDEN,
            'data' => $message,
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
