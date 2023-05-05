<?php

namespace app\models;

/*
 */
class Favorite extends \yii\db\ActiveRecord
{
    /*
         @property int $id
        @property int $user_id
        @property int $fruit_id
     */


    public static function tableName(): string
    {
        return 'favorites';
    }

    public function rules(): array
    {
        return [
            [
                [
                    'user_id',
                    'fruit_id'
                ],
                'integer'
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'user_id' => 'User ID',
            'fruit_id' => 'Fruit ID'
        ];
    }
}
