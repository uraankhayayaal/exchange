<?php

namespace common\tests\fixtures;

use yii\test\ActiveFixture;

/**
 * Class UserFixture
 */
class UserFixture extends ActiveFixture
{
    /**
     * @inheritDoc
     */
    public $modelClass = 'common\models\User';

    /**
     * @inheritDoc
     */
    public $dataFile = '@common/tests/_data/user.php';
}
