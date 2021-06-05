<?php
namespace frontend\models;

use common\models\Payment;
use Yii;
use common\models\User;
use yii\base\Model;

class DonateConfirmForm extends Model
{
    public $type;
    public $account;
    public $banid;
    public $currency;
    public $desc;
    public $sum;
    public $created_at;


    public function rules()
    {
        return [
            ['created_at', 'safe'],
            ['type', 'trim'],
            ['type', 'required'],
            ['type','in','range' => ['gems1000', 'gems5000', 'gems10000','vip_m','vip_y','support','unban','unwarn']],
            ['account', 'trim'],
            ['account', 'required'],
            ['sum', 'integer', 'min' => 10],
            ['account', 'string', 'min' => 3, 'max' => 16],
            ['banid', 'integer'],
            [['banid'], 'exist', 'targetClass' => PunishmentHistory::className(), 'targetAttribute' => ['banid' => 'id']],
            [['account'], 'exist', 'targetClass' => LoginSecurity::className(), 'targetAttribute' => ['account' => 'last_name']]
        ];
    }

    public function generate()
    {

        $this->currency = Payment::CURRENCY_RUB;
        $this->desc = 'Описание платежа';

        switch ($this->type) {
            case 'gems1000':
                $this->sum = priceFormatRub(Payment::DONATION_GEMS_1);
                $this->desc = 'Покупка 1000 GEMS';
                break;
            case 'gems5000':
                $this->sum = priceFormatRub(Payment::DONATION_GEMS_5);
                $this->desc = 'Покупка 5000 GEMS';
                break;
            case 'gems10000':
                $this->desc = 'Покупка 10 000 GEMS';
                $this->sum = priceFormatRub(Payment::DONATION_GEMS_10);
                break;
            case 'vip_m':
                $this->desc = 'Покупка VIP статуса на месяц';
                $this->sum = priceFormatRub(Payment::DONATION_PERMISSIONS_MONTH);
                break;
            case 'vip_y':
                $this->desc = 'Покупка VIP статуса на год';
                $this->sum = priceFormatRub(Payment::DONATION_PERMISSIONS_YEAR);
                break;
            case 'unban':
                $this->desc = 'Покупка разбана аккаунта';
                $this->sum = priceFormatRub(Payment::DONATION_UNBAN);
                break;
            case 'unwarn':
                $this->desc = 'Покупка снятия варнов аккаунта';
                $this->sum = priceFormatRub(Payment::DONATION_UNWARN);
                break;
            case 'support':
                $this->desc = 'Поддержка сервера';
                break;

        }

        if($this->desc)
            $this->desc .= (' на проэкте '.Yii::$app->params['name']);


    }

}
