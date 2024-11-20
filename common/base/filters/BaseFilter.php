<?php

namespace common\base\filters;

use Yii;
use yii\data\ActiveDataFilter;
use yii\data\DataProviderInterface;
use yii\db\ActiveQueryInterface;
use yii\web\HttpException;

abstract class BaseFilter
{
    protected $activeDataFilter;

    public function __construct()
    {
        $this->activeDataFilter = new ActiveDataFilter([
            'searchModel' => $this->getSearchModel(),
            'attributeMap' => $this->getAttributeMap(),
        ]);
    }

    abstract public function getDataProvider(ActiveQueryInterface $query): DataProviderInterface;

    abstract protected function getSearchModel(): string;

    protected function getAttributeMap(): array
    {
        return [];
    }

    protected function getFilteredQuery(ActiveQueryInterface $query): ActiveQueryInterface
    {
        $filterCondition = $this->getFilterCondition();

        if ($filterCondition) {
            $query->andWhere($filterCondition);
        }

        return $query;
    }

    protected function getFilterCondition(): ?array
    {
        $filterCondition = null;

        $isLoad = $this->activeDataFilter->load(Yii::$app->request->queryParams);

        if ($isLoad) {
            $filterCondition = $this->activeDataFilter->build();

            if ($filterCondition === false) {
                Yii::error(serialize($this->activeDataFilter), 'BaseFilter');

                throw new HttpException(
                    422,
                    json_encode($this->activeDataFilter->errors, JSON_UNESCAPED_UNICODE)
                );
            }
        }

        return $filterCondition;
    }
}
