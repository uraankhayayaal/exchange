<?php

namespace common\modules\exchange\controllers\interfaces;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'exchange',
    description: 'Размен валют'
)]
interface ApiControllerInterface
{
    #[OA\Get(
        // path: '/api/v1?method=rates',
        path: '/exchange/api/rates',
        description: 'Получение всех курсов с учетом комиссии = 2%',
        tags: ['exchange'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'filter', in: 'query', schema: new OA\Schema(type: 'string'), description: 'Фильтрация', example: 'USD,RUB,EUR'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успешный ответ'),
        ]
    )]
    public function actionRates(): array;

    #[OA\Post(
        // path: '/api/v1?method=convert',
        path: '/exchange/api/convert',
        description: 'Запрос на обмен валюты c учетом комиссии = 2%',
        tags: ['exchange'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['currency_from', 'currency_to', 'value'],
            properties: [
                new OA\Property(property: 'currency_from', type: 'string', format: 'text', example: 'USD'),
                new OA\Property(property: 'currency_to', type: 'string', format: 'text', example: 'BTC'),
                new OA\Property(property: 'value', type: 'number', format: 'number', example: '0.01'),
            ]
        )),
        responses: [
            new OA\Response(response: 200, description: 'Успешный ответ'),
        ]
    )]
    public function actionConvert(): array;
}
