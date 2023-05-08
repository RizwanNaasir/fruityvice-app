<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\RegistrationForm;

class RegistrationController extends Controller
{
    public function actionIndex()
    {
        $model = new RegistrationForm();
        $model->load(Yii::$app->request->post(), '');

        if ($user = $model->register()) {
            Yii::$app->response->statusCode = 201;
            return ['message' => 'User registration successful'];
        } else {
            Yii::$app->response->setStatusCode(422);
            return $model->getErrors();
        }
    }
}