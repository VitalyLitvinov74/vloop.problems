<?php


namespace vloop\problems\entities\forms;


use vloop\problems\entities\interfaces\Form;
use Yii;
use yii\base\Model;

abstract class AbstractForm extends Model implements Form
{
    protected $method = 'post'; //задается в конструкторе

    public function errors(): array
    {
        $new = [];
        foreach ($this->errors as $attribute => $attributeErrors) {
            foreach ($attributeErrors as $concreteError) {
                $new[$attribute] = $concreteError;
            }
        }
        return $new;
    }

    public function validatedFields(): array
    {
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();
        if($this->method = 'post'){
            if($this->load($post, '') and $this->validate()){
                return $this->getAttributes();
            }
        }elseif($this->method = 'get'){
            if($this->load($get, '') and $this->validate()){
                return $this->getAttributes();
            }
        }
        return [];
    }
}