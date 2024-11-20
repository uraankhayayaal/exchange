<?php

namespace common\modules\user\responses;

use common\base\responses\BaseResponseData;
use common\modules\user\models\User;
use common\modules\user\services\interfaces\UserServiceInterface;
use Yii;
use yii\helpers\ArrayHelper;

final class UserResponseData extends BaseResponseData
{
    public static function render(mixed $data): mixed
    {
        $isEmpty = empty($data);

        if ($isEmpty) {
            return $data;
        }

        $properties = [
            User::class => [
                'id',
                'status',
                'createdAt' => 'created_at',
                'updatedAt' => 'updated_at',
                'email',
                'roles' => function (User $user) {
                    return ArrayHelper::getColumn(
                        Yii::$container->get(UserServiceInterface::class)->getRolesById($user->id),
                        'item_name',
                    ) ?: ['user'];
                },
            ],
        ];

        return ArrayHelper::toArray($data, $properties);
    }
}
