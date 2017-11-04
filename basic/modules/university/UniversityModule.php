<?php

namespace app\modules\university;

/**
 * university module definition class
 */
class UniversityModule extends \yii\base\Module
{
    public $layout = 'main';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\university\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
