<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ingredients".
 *
 * @property int $id
 * @property string $title Название
 * @property int $active Сушествует или нет
 *
 * @property DishToIngredients[] $dishToIngredients
 */
class Ingredients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingredients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['active'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'active' => 'Активность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishToIngredients()
    {
        return $this->hasMany(DishToIngredients::className(), ['id_ing' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishs()
    {
        return $this->hasMany(Dishes::className(), ['id' => 'id_dish'])
            ->viaTable('dish_to_ingredients', ['id_ing' => 'id']);
    }
}
