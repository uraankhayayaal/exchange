<?php

namespace common\modules\user\controllers\interfaces;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'auth',
    description: 'Управление доступом'
)]
interface ApiAuthControllerInterface
{
    #[OA\Post(
        path: '/user/api-auth/login',
        description: 'Аутентификация',
        tags: ['auth'],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['email', 'password'],
            properties: [
                new OA\Property(property: 'email', type: 'string', format: 'text', example: 'demodemo@test.exmaple'),
                new OA\Property(property: 'password', type: 'string', format: 'text', example: '000000'),
            ]
        )),
        responses: [
            new OA\Response(response: 200, description: 'Успешный ответ'),
        ]
    )]
    public function actionLogin(): array;

    #[OA\Post(
        path: '/user/api-auth/register',
        description: 'Регистрация',
        tags: ['auth'],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['username', 'email', 'password'],
            properties: [
                new OA\Property(property: 'username', type: 'string', format: 'text', example: 'demodemo2'),
                new OA\Property(property: 'email', type: 'string', format: 'text', example: 'demodemo@test.local'),
                new OA\Property(property: 'password', type: 'string', format: 'text', example: '000000'),
            ]
        )),
        responses: [
            new OA\Response(response: 200, description: 'Успешный ответ'),
        ]
    )]
    public function actionRegister(): array;

    #[OA\Get(
        path: '/user/api-auth/confirm',
        description: 'Подтверждение по электронной почте',
        tags: ['auth'],
        parameters: [
            new OA\Parameter(name: 'hash', in: 'query', schema: new OA\Schema(type: 'string'), description: 'Токен подтверждения по электронной почте'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успешный ответ'),
        ]
    )]
    public function actionConfirm(): array;

    #[OA\Post(
        path: '/user/api-auth/forgot-password',
        description: 'Восстановление пароля',
        tags: ['auth'],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['email'],
            properties: [
                new OA\Property(property: 'email', type: 'string', format: 'text', example: 'demodemo@test.local'),
            ]
        )),
        responses: [
            new OA\Response(response: 200, description: 'Успешный ответ'),
        ]
    )]
    public function actionForgotPassword(): array;

    #[OA\Post(
        path: '/user/api-auth/reset-password',
        description: 'Сброс пароля',
        tags: ['auth'],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['passwordResetToken', 'password'],
            properties: [
                new OA\Property(property: 'password', type: 'string', format: 'text', example: '000000'),
                new OA\Property(property: 'passwordResetToken', type: 'string', format: 'text', example: 'qR1IpWCH5zB07_sgHi38i0upqCYfam_h'),
            ]
        )),
        responses: [
            new OA\Response(response: 200, description: 'Успешный ответ'),
        ]
    )]
    public function actionResetPassword(): array;

    #[OA\Post(
        path: '/user/api-auth/validate-token',
        description: 'Валидация JWT токена',
        tags: ['auth'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Успешный ответ'),
            new OA\Response(response: 401, description: 'Не разрешено'),
        ]
    )]
    public function actionValidateToken(): array;

    #[OA\Post(
        path: '/user/api-auth/refresh-token',
        description: 'Обновление JWT токена',
        tags: ['auth'],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['refreshToken'],
            properties: [
                new OA\Property(property: 'refreshToken', type: 'string', format: 'text', example: 'l6CMgPpmGPugodxk5rgc8GmtW24Bu8wiG5Q3uibavlrPeAr-sdf3iT2AstYldn3R'),
            ]
        )),
        responses: [
            new OA\Response(response: 200, description: 'Успешный ответ'),
        ]
    )]
    public function actionRefreshToken(): array;
}
