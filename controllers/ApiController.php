<?php


namespace frontend\controllers;


use yii\rest\ActiveController;

use yii\filters\auth\HttpBasicAuth;

use common\models\Api;

class ApiController extends ActiveController

{
    public $modelClass = 'frontend\models\UserRestApi'; // Example Model Table user_rest_api or define yourself

    public function behaviors()

    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [

            'class' => HttpBasicAuth::className(),

            'auth' => function ($username, $password) {

                $user = Api::findByUsername($username);

                if ($user && $user->validatePassword($username, $password)) {

                    return $user;

                }
            }
        ];

        return $behaviors;

    }
}