<?php

namespace common\components;

use common\base\components\BaseComponent;
use common\base\modules\BaseModule;
use yii\base\BootstrapInterface;

/**
 * Class ModulesBootstrapComponent
 */
final class ModulesBootstrapComponent extends BaseComponent implements BootstrapInterface
{
    /**
     * @inheritDoc
     */
    public function bootstrap($app) : void
    {
        foreach (array_keys($app->modules) as $id)
        {
            $module = $app->getModule($id);

            if ($module instanceof BaseModule)
            {
                $module->bootstrap($app);
            }
        }
    }
}
