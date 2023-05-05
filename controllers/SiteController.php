<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\LoginForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $request = Yii::$app->getRequest();
        if ($model->load($request->post(), '') && $model->login()) {
            $user = User::findOne(['username' => $model->username]);
            /*$access_token = Yii::$app->security->generateRandomString();*/
            /*$user->access_token = $access_token;*/
            if ($user->save()) {
                /*return ['access_token' => $access_token];*/
                return $user;
            }
        }
        Yii::$app->response->statusCode = 401;
        return ['error' => 'Invalid login credentials'];
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}