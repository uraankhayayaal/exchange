<?php

namespace common\base\modules;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\di\Container;

/**
 * Class BaseModule
 */
abstract class BaseModule extends Module implements BootstrapInterface
{
    /**
     * @return Container
     */
    protected function getContainer() : Container
    {
        return Yii::$container;
    }

    /**
     * @param string $name
     * @param string $listenerClass
     * @param string $listenerMethod
     *
     * @return void
     */
    protected function bindEvent(string $name, string $listenerClass, string $listenerMethod) : void
    {
        $handler = [
            Yii::createObject($listenerClass),
            $listenerMethod,
        ];
        Yii::$app->on($name, $handler);
    }

    /**
     * @inheritDoc
     */
    public function bootstrap($app) : void
    {
        $this->bindEvents();
        $this->bindRepositories();
        $this->bindServices();
    }

    /**
     * @return void
     */
    protected function bindEvents() : void {}

    /**
     * @return void
     */
    protected function bindRepositories() : void {}

    /**
     * @return void
     */
    protected function bindServices() : void {}
}
