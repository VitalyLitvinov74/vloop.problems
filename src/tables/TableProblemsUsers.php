<?php


namespace vloop\problems\tables;


use yii\db\ActiveRecord;

/***
 * Class TableProblemsUsers
 * @package vloop\problems\tables
 * @property int $problem_id [int(11)]
 * @property int $user_id [int(11)]
 * @property string $role [varchar(255)]
 */
class TableProblemsUsers extends ActiveRecord
{
    public static function tableName()
    {
        return 'vloop_problems_users'; // TODO: Change the autogenerated stub
    }
}