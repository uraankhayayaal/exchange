<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        'common\components\ModulesBootstrapComponent',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'authManager' => [
          'class' => 'yii\rbac\DbManager',
        ],
    ],
	'modules' => [
        'user' => 'common\modules\user\Module',
        'exchange' => 'common\modules\exchange\Module',
    ],
];
