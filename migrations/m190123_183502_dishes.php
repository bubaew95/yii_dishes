<?php

use yii\db\Migration;

/**
 * Class m190123_183502_dishes
 */
class m190123_183502_dishes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%dishes}}', [
            'id'          => $this->primaryKey()->unsigned()->notNull(),
            'title'       => $this->string()->notNull()->comment('Название'),
            'active'      => $this->integer()->defaultValue('1')->comment('Сушествует или нет'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dishes}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190123_183502_dishes cannot be reverted.\n";

        return false;
    }
    */
}
