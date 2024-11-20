<?php

namespace common\base\controllers;

use bizley\jwt\JwtHttpBearerAuth;
use common\base\responses\BaseResponseData;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use Yii;
use yii\web\ForbiddenHttpException;

abstract class BaseApiController extends Controller
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => [
                        Yii::$app->params['allowed_host'],
                        'http://localhost',
                    ],
                    'Access-Control-Allow-Origin' => [
                        Yii::$app->params['allowed_host'],
                        'http://localhost',
                    ],
                    'Access-Control-Request-Headers' => [
                        '*',
                    ],
                    'Access-Control-Request-Methods' => [
                        '*',
                    ],
                    'Access-Control-Allow-Headers' => [
                        '*',
                    ],
                    'Access-Control-Max-Age' => 3600,
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => [
                        'GET',
                    ],
                    'view' => [
                        'GET',
                    ],
                    'create' => [
                        'POST',
                    ],
                    'update' => [
                        'PUT',
                    ],
                    'delete' => [
                        'DELETE',
                    ],
                    'restore' => [
                        'POST',
                    ],
                    'options' => [
                        'OPTIONS',
                    ],
                ],
            ],
            'authenticator' => [
                'class' => JwtHttpBearerAuth::class,
                'except' => [
                    'options',
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'options',
                        ],
                        'verbs' => [
                            'OPTIONS',
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function actionOptions(): void
    {
        $options = [
            'GET',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
            'HEAD',
            'OPTIONS',
        ];

        $options = implode(', ', $options);

        $headers = Yii::$app->getResponse()->getHeaders();

        $headers->set('Allow', $options);
        $headers->set('Access-Control-Allow-Methods', $options);
        $headers->set('Access-Control-Allow-Origin', '*');
    }

    public function beforeAction($action)
    {
        try {
            return parent::beforeAction($action);
        } catch (InvalidTokenStructure $e) {
            $this->asJson(BaseResponseData::forbidden('Invalid token'));
            return false;
        }
    }
}
