<?php

namespace app\models;

/**
 * This is the model class for table "fruits".
 *
 * @property int $id
 * @property int $fruit_id
 * @property float $calories
 * @property float $fat
 * @property float $sugar
 * @property float $carbohydrates
 * @property float $protein
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Nutrition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nutritions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['calories', 'fat', 'sugar', 'carbohydrates', 'protein'], 'required'],
            [['calories', 'fat', 'sugar', 'carbohydrates', 'protein'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',
            'fruit_id' => 'Fruit ID',
            'calories' => 'Calories',
            'fat' => 'Fat',
            'sugar' => 'Sugar',
            'carbohydrates' => 'Carbohydrates',
            'protein' => 'Protein',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
