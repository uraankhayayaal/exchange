<?php

namespace common\modules\exchange\forms;

use common\modules\exchange\enums\CurrencyEnum;
use yii\base\Model;

class ConvertForm extends Model
{
    /**
     * @var string
     */
    public $currency_from;

    /**
     * @var string
     */
    public $currency_to;
    
    /**
     * @var float
     */
    public $value;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            [
                [
                    'currency_from',
                    'currency_to',
                    'value',
                ],
                'required',
            ],
            [
                [
                    'currency_from',
                    'currency_to',
                ],
                'string',
                'max' => 30,
            ],
            [
                [
                    'value',
                ],
                'number',
            ],
            [
                'value',
                'match',
                'pattern' => '/^[0-9]{1,12}(\.[0-9]{0,2})?$/',
                'when' => function($model) {
                    return $model->currency_from !== CurrencyEnum::BTC->value;
                },
            ],
            [
                'value',
                'match',
                'pattern' => '/^[0-9]{1,12}(\.[0-9]{0,10})?$/',
                'when' => function($model) {
                    return $model->currency_from === CurrencyEnum::BTC->value;
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Организация',
            'title' => 'Название',
            'photo' => 'Фото',
            'thumbnail' => 'Миниатюра фото',
            'description' => 'Описание',
            'content' => 'Содержание',
            'is_publish' => 'Опубликован',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
            'deleted_at' => 'Удален',
            'price' => 'Цена, руб.',
            'address' => 'Адрес',
            'lat' => 'Lat',
            'lon' => 'Lon',
            'feature_id' => 'Тариф',
            'duration' => 'Продолжительность, мин',
            'for_year_start' => 'Для детей от, лет',
            'for_year_end' => 'Для детей до, лет',
            'city_id' => 'Город',
            'start_at' => 'Дата начала',
            'end_at' => 'Дата окончания',
            'tags' => 'Тэги',
            'sale_end_at' => 'Скидка действует до',
            'sale_percent' => 'Размер скидки в %',
            'price_max' => 'Максимальная цена',
            'type' => 'Тип секции',
            'count_of_group' => 'Количество в группе',
            'extra_member_for_group_price' => 'Стоимость за дополнительного ребенка в группе',
            'morning_price' => 'Цена в утренне время',
            'noon_price' => 'Цена в дневное время',
            'evening_price' => 'Цена в вечернее время',
            'student_sale_percent' => 'Скидка студентам %',
            'birthday_sale_percent' => 'Скидка в день рождение %',
            'open_at' => 'Открывается в',
            'close_at' => 'Закрывается в',
            'is_super_section' => 'Суперсекция',
            'is_free_cancel_in_24_h' => 'Бесплатная отмена занятий за 24 часа',
        ];
    }
}