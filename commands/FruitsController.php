<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Fruits;
use app\models\Nutrition;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPMailer\PHPMailer\PHPMailer;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

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
     * @throws Exception
     */
    public function actionFetch()
    {

        $client = new Client([
            'base_uri' => 'https://fruityvice.com/api/',
        ]);

        $response = $client->request('GET', 'fruit/all');

        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody(), true);
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
            $this->sendMail();
            exit();
        } else {
            Yii::error('Failed to fetch data from API: ' . $response->getStatusCode());
        }

        echo "Fruits fetched successfully.\n";
        return ExitCode::OK;
    }

    public function welcomeTemplate(): string
    {
        return "
         <h1>Welcome to our site</h1>
            <h2>Fruits Added Successfully</h2>
                <p>Thank you for joining our community. We are excited to have you as a member.</p>
                <p>Here are a few things you can do to get started:</p>
                    <ul>
                      <li>Explore our site and discover new features</li>
                      <li>Connect with other members and start engaging</li>
                    </ul>
                        <p>If you have any questions or feedback, please do not hesitate to reach out to us.</p>
                        <p>Best regards,</p>
    ";
    }

    /**
     * @return void
     */
    public function sendMail(): string
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Port = 587;
            $mail->Username = 'mc190402609@vu.edu.pk';
            $mail->Password = 'agtdztvvuupswxrz';
            $mail->SMTPSecure = 'tls';
            $mail->setFrom('mc190402609@vu.edu.pk', 'Fruityice');
            $mail->addAddress('mc190402609@vu.edu.pk', 'Anonymous');
            $mail->isHTML(true);
            $mail->Subject = 'Welcome';
            $mail->Body = $this->welcomeTemplate();
            $mail->send();
            return 'message sent';
        } catch (Exception $e) {
            dd($e->getMessage());
            Yii::error($e->getMessage());
        }
    }
}
