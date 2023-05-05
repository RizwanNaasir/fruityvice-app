<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Fruits;
use app\models\Nutrition;
use GuzzleHttp\Exception\GuzzleException;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use GuzzleHttp\Client;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FruitsController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     * @throws GuzzleException
     * @throws \Exception
     */
    public function actionFetch(): int
    {
        $client = new Client([
            'base_uri' => 'https://fruityvice.com/api/',
            'timeout'  => 2.0,
        ]);

        $response = $client->request('GET', 'fruit/all');

        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody(), true);
            try {
                foreach ($data as $item) {
                    $model = new Fruits();
                    $nutritionFromReq = $item['nutritions'];
                    $model->name = $item['name'];
                    $model->family = $item['family'];
                    $model->order = $item['order'];
                    $model->genus = $item['genus'];
                    $nutrition = new Nutrition();
                    $nutrition->calories = $nutritionFromReq['calories'];
                    $nutrition->fat = $nutritionFromReq['fat'];
                    $nutrition->sugar = $nutritionFromReq['sugar'];
                    $nutrition->carbohydrates = $nutritionFromReq['carbohydrates'];
                    $nutrition->protein = $nutritionFromReq['protein'];
                    if( $nutrition->save()){
                        $model->nutrition_id = $nutrition->id;
                        if (!$model->save()) {
                            Yii::error($model->getErrors());
                        }
                    }else{
                        Yii::error($nutrition->getErrors());
                    }
                }
            }catch (\Exception $e ){
                throw new $e;
            }
            exit();
            // Do something with the data
        } else {
            Yii::error('Failed to fetch data from API: ' . $response->getStatusCode());
        }

        // Send Mail to Admin
        Yii::$app->mailer->compose()
            ->setFrom('')
            ->setTo('')
            ->setHtmlBody('html')
            ->setSubject('subject')
            ->send();
        return ExitCode::OK;
    }
}
