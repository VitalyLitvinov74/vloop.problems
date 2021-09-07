<?php


namespace vloop\problems\tables\query;


use yii\db\ActiveQuery;

class BaseQuery extends ActiveQuery
{
    /**
     * Аналог all() только без маппинга в ActiveRecord
    */
    public function readAll(){
        return $this->createCommand()->query()->readAll();
    }

    /**
     * Аналог one() только без маппинга в ActiveRecord
    */
    public function readOne(){
        return $this->createCommand()->query()->read();
    }
}