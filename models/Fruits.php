<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "fruits".
 *
 * @property int $id
 * @property int $nutrition_id
 * @property string $name
 * @property string $family
 * @property string $order
 * @property string $genus
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Fruits extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'fruits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['nutrition_id', 'name', 'family', 'order', 'genus'], 'required'],
            [['nutrition_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'family', 'order', 'genus'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'nutrition_id' => 'Nutrition ID',
            'name' => 'Name',
            'family' => 'Family',
            'order' => 'Order',
            'genus' => 'Genus',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getNutrition(): ActiveQuery
    {
        return $this->hasOne(Nutrition::class, ['id' => 'nutrition_id']);
    }
}
