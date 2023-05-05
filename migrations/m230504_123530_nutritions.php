<?php

use yii\db\Migration;


class m230504_123530_nutritions extends Migration
{

    public function safeUp()
    {
        $this->createTable('nutritions', [
            'id' => $this->primaryKey(),
            'calories' => $this->integer()->notNull(),
            'fat' => $this->decimal(5,2)->notNull(),
            'sugar' => $this->decimal(5,2)->notNull(),
            'carbohydrates' => $this->decimal(5,2)->notNull(),
            'protein' => $this->decimal(5,2)->notNull(),
        ]);
    }
    public function safeDown()
    {
        $this->dropTable('nutritions');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230504_123530_nutritions cannot be reverted.\n";

        return false;
    }
    */
}
