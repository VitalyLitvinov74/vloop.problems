<?php


namespace vloop\problems\entities\abstractions;


use vloop\entities\contracts\Form;
use vloop\problems\entities\exceptions\NotValidatedFields;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

abstract class AbstractForm extends Model implements Form
{

    protected $method;

    public function __construct($method = 'post', $config = [])
    {
        $this->method = $method;
        parent::__construct($config);
    }

    /**
     * @return array
     * @throws NotValidatedFields
     */
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
        throw new NotValidatedFields($this->getErrors(), 400);
    }
}