<?php

namespace common\modules\exchange\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "exchange".
 *
 * @property int $id
 * @property int $title
 * @property int $created_at
 * @property int $updated_at
 */
class Exchange extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function tableName()
    {
        return 'exchange';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }
}
