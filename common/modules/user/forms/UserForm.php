<?php

namespace common\modules\user\forms;

use yii\base\Model;
use common\models\User;

class UserForm extends Model
{
    /**
     * @property int
     */
    public $id;

    /**
     * @property string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var int
     */
    public $status;

    public function rules(): array
    {
        return [
            [['username', 'email', 'password', 'status'], 'required'],

            [['id', 'status'], 'integer'],

            [['username'], 'string', 'max' => 255],
            ['username', 'unique', 'targetAttribute' => 'username', 'targetClass' => User::class],

            [['email'], 'email'],
            ['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => User::class],

            [['password'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'status' => 'Статус',
        ];
    }
}
