<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ls_players".
 *
 * @property int $id
 * @property string|null $unique_user_id
 * @property string|null $last_name
 * @property string|null $ip_address
 * @property string|null $password
 * @property int|null $hashing_algorithm
 * @property int|null $location_id
 * @property int|null $inventory_id
 * @property string|null $last_login
 * @property string|null $registration_date
 * @property int $optlock
 * @property string|null $uuid_mode
 *
 * @property LsInventories $inventory
 * @property LsLocations $location
 */
class LoginSecurity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ls_players';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('LoginSecurity');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hashing_algorithm', 'location_id', 'inventory_id', 'optlock'], 'integer'],
            [['last_login', 'registration_date'], 'safe'],
            [['optlock'], 'required'],
            [['unique_user_id'], 'string', 'max' => 128],
            [['last_name'], 'string', 'max' => 16],
            [['ip_address'], 'string', 'max' => 64],
            [['password'], 'string', 'max' => 512],
            [['uuid_mode'], 'string', 'max' => 1],
            [['unique_user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unique_user_id' => 'Unique User ID',
            'last_name' => 'Last Name',
            'ip_address' => 'Ip Address',
            'password' => 'Password',
            'hashing_algorithm' => 'Hashing Algorithm',
            'last_login' => 'Last Login',
            'registration_date' => 'Registration Date',
            'optlock' => 'Optlock',
            'uuid_mode' => 'Uuid Mode',
        ];
    }

    /**
     * Gets query for [[Inventory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInventory()
    {
        return $this->hasOne(LsInventories::className(), ['id' => 'inventory_id']);
    }


}
