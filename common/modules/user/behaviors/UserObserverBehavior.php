<?php

namespace common\modules\user\behaviors;

use common\base\behaviors\BaseBehavior;
use common\modules\user\models\User;
use common\modules\user\services\interfaces\AuthServiceInterface;
use Yii;
use yii\base\Event;
use yii\db\BaseActiveRecord;

/**
 * Class UserObserverBehavior
 */
final class UserObserverBehavior extends BaseBehavior
{
    /**
     * @inheritDoc
     */
    public function events() : array
    {
        return [
            BaseActiveRecord::EVENT_AFTER_INSERT => [
                $this,
                'afterInsert',
            ],
        ];
    }

    /**
     * @param Event $event
     *
     * @return void
     */
    public function afterInsert(Event $event) : void
    {
        if ($event->sender->status === User::STATUS_UNCONFIRMED)
        {
            Yii::$container->get(AuthServiceInterface::class)->sendUrlForConfirmByMail($event->sender);
        }
    }
}
