<?php

use yii\db\Migration;

/**
 * Class m190123_183909_ingredients_dish
 */
class m190123_183909_ingredients_dish extends Migration
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

        $this->createTable('{{%dish_to_ingredients}}', [
            'id'          => $this->primaryKey()->unsigned()->notNull(),
            'id_dish'     => $this->integer()->unsigned()->comment('ID блюда'),
            'id_ing'      => $this->integer()->unsigned()->comment('ID ингредиента'),
        ], $tableOptions);

        $this->addForeignKey(
          'fk_dishes_key_1',
          '{{%dish_to_ingredients}}',
          'id_dish',
          '{{%dishes}}',
          'id'
        );
        $this->addForeignKey(
            'fk_ingredients_key_1',
            '{{%dish_to_ingredients}}',
            'id_ing',
            '{{%ingredients}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dish_to_ingredients}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190123_183909_ingredients_dish cannot be reverted.\n";

        return false;
    }
    */
}
