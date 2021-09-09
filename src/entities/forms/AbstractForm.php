<?php


namespace vloop\problems\entities\forms;


use vloop\problems\entities\abstractions\Form;
use Yii;
use yii\base\Model;

abstract class AbstractForm extends Model implements Form
{

    protected $method;

    public function __construct($method = 'post', $config = [])
    {
        $this->method = $method;
        parent::__construct($config);
    }

    public function errors(): array
    {
        return $this->getErrors();
    }

    public function validatedFields(): array
    {
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();
        if ($this->method == 'post') {
            if ($this->load($post, '') and $this->validate()) {
                return $this->getAttributes();
            }
        } elseif ($this->method == 'get') {
            if ($this->load($get, '') and $this->validate()) {
                return $this->getAttributes();
            }
        }
        return [];
    }
}