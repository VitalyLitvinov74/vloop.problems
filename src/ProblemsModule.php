<?php


namespace vloop\problems;


use vloop\problems\entities\exceptions\NotValidatedFields;
use Yii;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class ProblemsModule extends Module
{
    public function init()
    {
        parent::init();
        $this->controllerNamespace = 'vloop\problems\controllers';
    }

}