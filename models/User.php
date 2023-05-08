<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public static function tableName(): string
    {
        return 'users';
    }

    public function rules(): array
    {
        return [
            [['username',  'email'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['username', 'email'], 'string', 'max' => 255],
            /*[['email'], 'unique'],
            [['username'], 'unique'],*/
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password Hash',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username): ?User
    {
        return static::findOne(['username' => $username]);
    }

    public static function findByPasswordResetToken($token): ?User
    {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            return null;
        }
        return static::findOne(['password_reset_token' => $token]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            $this->updated_at = date('Y-m-d H:i:s');
            return true;
        }
        return false;
    }

}