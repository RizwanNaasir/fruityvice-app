<?php
namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules(): array
    {
        return [
            [['username', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['username', 'string', 'max' => 255],
//            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
//            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
        ];
    }

    /**
     * @throws Exception
     */
    public function register(): ?User
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->password = Yii::$app->security->generatePasswordHash($this->password);
            if ($user->save()) {
                return $user;
            }
            else{
                return null;
            }
        }

        return null;
    }
}