<?php
use yii\db\Migration;

/**
 * Class m210901_134530_create_problem_tables
 */
class m210901_134530_create_problem_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vloop_problems', [
            'id'=>$this->primaryKey(),
            'author_id'=>$this->integer(),
            'status'=>$this->string(20)->notNull(),
            'description'=>$this->string(),
            'period_of_execution'=>$this->integer(),
            'time_of_creation'=>$this->integer(),

        ]);
        $this->createTable('vloop_problems_users', [
            'problem_id'=>$this->integer(),
            'user_id'=>$this->integer(),
            'role'=>$this->string()->defaultValue('workman')->notNull()
        ]);
        $this->addForeignKey(
            'problems-relation_users',
            "vloop_problems_users",
            "problem_id",
            'vloop_problems',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('problems-relation_users','vloop_problems_users');
        $this->dropTable('vloop_problems');
        $this->dropTable('vloop_problems_users');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210901_134530_create_problem_tables cannot be reverted.\n";

        return false;
    }
    */
}
