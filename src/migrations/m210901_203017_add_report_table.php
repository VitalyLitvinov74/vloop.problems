<?php
use yii\db\Migration;

/**
 * Class m210901_203017_add_report_table
 */
class m210901_203017_add_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vloop_reports', [
            'id'=>$this->primaryKey(),
            'user_id'=>$this->integer(),
            'problem_id'=>$this->integer(),
            'description'=>$this->string(),
        ]);
        $this->addForeignKey(
            'vloop_reports-problems',
            'vloop_reports',
            'problem_id',
            'vloop_problems',
            'id',
            'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('vloop_reports-problems', 'vloop_reports');
        $this->dropTable('vloop_reports');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210901_203017_add_report_table cannot be reverted.\n";

        return false;
    }
    */
}
