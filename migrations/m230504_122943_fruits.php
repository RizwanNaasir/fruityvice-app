<?php

use yii\db\Migration;
class m230504_122943_fruits extends Migration
{

    public function safeUp()
    {
        $this->createTable('fruits', [
            'id' => $this->primaryKey(),
            'nutrition_id'=>$this->bigInteger()->notNull(),
            'name' => $this->string()->notNull(),
            'family' => $this->string()->notNull(),
            'order' => $this->string()->notNull(),
            'genus' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }
    public function safeDown()
    {
        $this->dropTable('persimmons');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230504_122943_fruits cannot be reverted.\n";

        return false;
    }
    */
}
