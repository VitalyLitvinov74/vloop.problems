<?php


namespace vloop\problems;


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
        Yii::$app->setComponents([
            'response' => [
                'class' => 'yii\web\Response',
                'on beforeSend' => function ($event) {
                    $response = $event->sender;
                    if ($response->data !== null and isset($response->data['errors'])) {
                       $this->pastErrorStatusCode($response->data['errors']);
                    }
                },
            ],
        ]);
    }

    private function pastErrorStatusCode(array $errors){
        $titles = array_flip(ArrayHelper::getColumn($errors,'title'));
        if(isset($titles['Not Found'])){
            Yii::$app->response->setStatusCode(404);
        }else{
            Yii::$app->response->setStatusCode(422);
        }

    }
}