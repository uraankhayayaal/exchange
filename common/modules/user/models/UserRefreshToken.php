<?php

namespace common\modules\user\models;

use common\base\models\ApiBaseModel;
use DateTime;
use Yii;
use yii\db\ActiveQuery;

/**
 * Class UserRefreshToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $refresh_token
 * @property int $expired_at
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
final class UserRefreshToken extends ApiBaseModel
{
    public static function tableName(): string
    {
        return '{{%user_refresh_token}}';
    }

    public function rules(): array
    {
        return [
            [
                [
                    'user_id',
                    'refresh_token',
                    'expired_at',
                ],
                'required',
            ],
            [
                [
                    'user_id',
                    'expired_at',
                    'created_at',
                    'updated_at',
                ],
                'integer',
            ],
            [
                'refresh_token',
                'string',
                'max' => 255,
            ],
            [
                'refresh_token',
                'unique',
            ],
            [
                'user_id',
                'exist',
                'targetClass' => User::class,
                'targetAttribute' => 'id',
            ],
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, [
            'id' => 'user_id',
        ]);
    }

    public function setExpiredAt(): void
    {
        $this->expired_at = (new DateTime())->modify('+7 days')->getTimestamp();
    }

    public function generateRefreshToken(): void
    {
        $this->refresh_token = Yii::$app->security->generateRandomString(64);
    }

    public function isExpired(): bool
    {
        return time() >= $this->expired_at;
    }
}
