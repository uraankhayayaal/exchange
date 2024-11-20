<?php

namespace common\base\repositories;

use common\base\repositories\interfaces\BaseRepositoryInterface;
use yii\db\ActiveRecordInterface;
use yii\web\HttpException;

abstract class BaseRepository implements BaseRepositoryInterface
{
    abstract public function getModelClass(): string;

    public function create(array $attributes): ActiveRecordInterface
    {
        $modelClass = $this->getModelClass();

        $model = new ($modelClass);

        $model->setAttributes($attributes);

        $this->validateModel($model);

        $isSave = $model->save(false);

        if ($isSave) {
            return $model;
        } else {
            throw new HttpException(500, 'An error occurred while creating the model.');
        }
    }

    private function validateModel(ActiveRecordInterface $model): void
    {
        $isValid = $model->validate();

        if ($isValid === false) {
            $message = json_encode($model->getErrors(), JSON_UNESCAPED_UNICODE);

            throw new HttpException(422, $message);
        }
    }

    public function update(ActiveRecordInterface $model, array $attributes): ActiveRecordInterface
    {
        $model->setAttributes($attributes);

        $this->validateModel($model);

        $isSave = $model->save(false);

        if ($isSave) {
            return $model;
        } else {
            throw new HttpException(500, 'An error occurred while updating the model.');
        }
    }

    public function delete(ActiveRecordInterface $model): bool
    {
        $hasSoftDeleteAttribute = $model->hasAttribute('deleted_at');

        if ($hasSoftDeleteAttribute) {
            $model->deleted_at = time();

            $this->validateModel($model);

            return $model->save(false);
        } else {
            return $model->delete();
        }
    }

    public function restore(ActiveRecordInterface $model): bool
    {
        $canBeRestore = $model->hasAttribute('deleted_at') && $model->deleted_at;

        if ($canBeRestore) {
            $model->deleted_at = null;

            $this->validateModel($model);

            return $model->save(false);
        }

        throw new HttpException(500, 'The model does not support restore.');
    }
}
