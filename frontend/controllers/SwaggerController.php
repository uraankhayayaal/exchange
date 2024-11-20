<?php

namespace frontend\controllers;

use common\base\controllers\BaseFrontController;
use frontend\controllers\interfaces\SwaggerControllerInterface;
use OpenApi\Annotations\OpenApi;
use OpenApi\Generator;
use yii\web\Response;
use Yii;

final class SwaggerController extends BaseFrontController implements SwaggerControllerInterface
{
    public function actionIndex(): string
    {
        $this->layout = false;

        Yii::$app->response->format = Response::FORMAT_HTML;

        return $this->render('index');
    }

    public function actionOpenapi(): string
    {
        header('Content-Type: application/x-yaml');

        return $this->getOpenApi()->toYaml();
    }

    private function getOpenApi(): OpenApi
    {
        $sources = [
            Yii::getAlias('@frontend/controllers/interfaces'),
        ];

        foreach (array_keys(Yii::$app->modules) as $id) {
            $source = Yii::getAlias('@common/modules/' . $id . '/controllers/interfaces');

            $isFileExists = file_exists($source);

            if ($isFileExists) {
                $sources[] = $source;
            }
        }

        return Generator::scan($sources);
    }
}
