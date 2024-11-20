<?php

namespace common\base\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * Class BaseFrontController
 */
abstract class BaseFrontController extends Controller
{
    // public $layout = '@frontend/themes/bootstrap5/views/layouts/main';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        if (!(
            ($action->id == 'change' && $action->controller->id == 'front' && $action->controller->module->id == 'location') ||
            ($action->id == 'auth' && $action->controller->id == 'site') ||
            ($action->id == 'login' && $action->controller->id == 'site') ||
            ($action->id == 'logout' && $action->controller->id == 'site') ||
            ($action->id == 'signup' && $action->controller->id == 'site') ||
            ($action->id == 'captcha' && $action->controller->id == 'site') ||
            ($action->id == 'like') ||
            ($action->id == 'like-comment') ||
            str_starts_with(Yii::$app->request->url, '/assets/')
        )) {
            Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        }
        return $result;
    }
}
