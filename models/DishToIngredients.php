<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dish_to_ingredients".
 *
 * @property int $id
 * @property int $id_dish ID блюда
 * @property int $id_ing ID ингредиента
 *
 * @property Dishes $dish
 * @property Ingredients $ing
 */
class DishToIngredients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dish_to_ingredients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_dish', 'id_ing'], 'integer'],
            [['id_dish'], 'exist', 'skipOnError' => true, 'targetClass' => Dishes::className(), 'targetAttribute' => ['id_dish' => 'id']],
            [['id_ing'], 'exist', 'skipOnError' => true, 'targetClass' => Ingredients::className(), 'targetAttribute' => ['id_ing' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_dish' => 'Id Блюда',
            'id_ing' => 'Id Ингредиента',
        ];
    }

    /**
     * Поиск совпадений по ингредиентам
     * @param $ids
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function dishToIngs($ids)
    {
        return DishToIngredients::find()
            ->select(['dishes.title', 'dish_to_ingredients.id_dish', 'count(ingredients.id) as ingCount'])
            ->leftJoin('ingredients', 'ingredients.id = dish_to_ingredients.id_ing')
            ->leftJoin('dishes', 'dishes.id = dish_to_ingredients.id_dish')
            ->where(['in', 'id_ing', $ids])
            ->andWhere(['dishes.active' => '1'])
            ->groupBy('dish_to_ingredients.id_dish')
            ->having('count(id_ing) >= 2')
            ->asArray()
            ->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDish()
    {
        return $this->hasOne(Dishes::className(), ['id' => 'id_dish']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIng()
    {
        return $this->hasOne(Ingredients::className(), ['id' => 'id_ing']);
    }
}
