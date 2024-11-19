<?php

namespace frontend\controllers\interfaces;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Exchange API',
    version: '0.1'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    in: 'header',
    name: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
)]
#[OA\Server(
    url: 'http://localhost',
    description: 'Local API server'
)]
interface SwaggerControllerInterface
{
    /**
     * Swagger page rendering
     */
    public function actionIndex() : string;

    /**
     * Action to get swagger configuration
     */
    public function actionOpenapi() : string;
}