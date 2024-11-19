<?php

namespace common\base\repositories\interfaces;

use yii\db\ActiveRecordInterface;

interface BaseRepositoryInterface
{
    public function create(array $attributes) : ActiveRecordInterface;

    public function update(ActiveRecordInterface $model, array $attributes) : ActiveRecordInterface;

    public function delete(ActiveRecordInterface $model) : bool;

    public function restore(ActiveRecordInterface $model) : bool;
}
