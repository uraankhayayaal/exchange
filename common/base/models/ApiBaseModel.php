<?php

namespace common\base\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

abstract class ApiBaseModel extends ActiveRecord
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $hasTimestampAttributes = $this->hasAttribute('created_at') && $this->hasAttribute('updated_at');

        if ($hasTimestampAttributes) {
            $behaviors[] = TimestampBehavior::class;
        }

        return $behaviors;
    }

    public function load($data, $formName = ''): bool
    {
        return parent::load($data, $formName);
    }
}
