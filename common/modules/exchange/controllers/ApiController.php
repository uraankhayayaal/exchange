<?php

namespace common\modules\exchange\controllers;

use common\modules\exchange\controllers\interfaces\ApiControllerInterface;
use common\modules\exchange\services\interfaces\ExchangeServiceInterface;
use common\base\controllers\BaseApiController;
use common\modules\exchange\forms\ConvertForm;
use common\modules\exchange\responses\ConvertDataResponse;
use common\modules\exchange\responses\ExchangeResponseData;
use common\modules\exchange\responses\RatesDataResponse;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

final class ApiController extends BaseApiController implements ApiControllerInterface
{
    public function behaviors() : array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'rates',
                            'convert',
                        ],
                        'roles' => [
                            '@',
                        ],
                    ],
                ],
            ],
            'authenticator' => [
                'optional' => [
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'rates' => [
                        'GET',
                    ],
                    'convert' => [
                        'POST',
                    ],
                ],
            ],
        ]);
    }

    public function actionRates() : array
    {
        $data = Yii::$container->get(ExchangeServiceInterface::class)->getRates();

        return RatesDataResponse::success($data);
    }

    public function actionConvert() : array
    {
        $model = new ConvertForm();

        if ($model->load($this->request->post()) && $model->validate())
        {
            $data = Yii::$container->get(ExchangeServiceInterface::class)->convert();

            return ConvertDataResponse::success($data);
        }

        return ConvertDataResponse::error($model);
    }
}