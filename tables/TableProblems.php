<?php


namespace vloop\problems\tables;


use vloop\problems\tables\query\BaseQuery;
use yii\db\ActiveRecord;

/**
 * Class TableProblems
 * @package vloop\problems\tables
 * @property int id
 * @property int $author_id [int(11)]
 * @property string $status [varchar(20)]
 * @property string $description [varchar(255)]
 * @property int $period_of_execution [int(11)]
 * @property int $time_of_creation [int(11)]
 * @property TableProblemsUsers[] $foremans
 * @property TableProblemsUsers[] $workmans
 */
class TableProblems extends ActiveRecord
{
    public static function tableName()
    {
        return 'vloop_problems'; // TODO: Change the autogenerated stub
    }

    public function rules()
    {
        return [
            [['author_id', 'description'], 'required'],
            [['description', ], 'unique', 'targetAttribute' => ['author_id', 'description']]
        ]; // TODO: Change the autogenerated stub
    }

    public static function find(){
        return new BaseQuery(get_called_class());
    }

    public function getWorkmans()
    {
        return $this
            ->hasMany(TableProblemsUsers::class, ['problem_id' => 'id'])
            ->where(['vloop_problems_users.role' => 'workman']);
    }

    public function getForemans()
    {
        return $this
            ->hasMany(TableProblemsUsers::class, ['problem_id' => 'id'])
            ->where(['vloop_problems_users.role' => 'foreman']);
    }
}