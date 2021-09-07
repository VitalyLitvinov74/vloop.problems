<?php


namespace vloop\problems;


use Yii;
use yii\base\Module;

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
                        Yii::$app->response->setStatusCode(422);
                    }
                },
            ],
        ]);
    }
}