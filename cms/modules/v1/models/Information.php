<?php

namespace cms\modules\v1\models;

use Yii\helpers\ArrayHelper;
use cms\modules\v1\models\base\Invoices;
use cms\modules\v1\models\base\MobileRegistration;
use cms\modules\v1\models\base\SubscriptionsActive;
use cms\modules\v1\helpers\String;
use Yii;
use yii\web\HttpException;

interface ITInformation
{
    function getUserInformation();

    function getInvoices();

    function concatDataAndReturn();

    function getActiveRequest();
}

class Information implements ITInformation
{
    public $login;
    public $statusExpiry = [1 => 'базовый', 2 => 'перевозчик', 3 => 'заказчик'];
    private $information = [];
    private $confirm = ['не подтвержден','подтвержден'];

    public function __construct($login)
    {
        $this->login = "+" . String::clearPhoneNumber($login);
    }

    public function concatDataAndReturn()
    {
        return $this->information;
    }

    function getActiveRequest()
    {
        $active = SubscriptionsActive::find()->where(['user_id' => $this->information['user']['id']])->one();
        if(!$active){
            $new_subscription_active = new SubscriptionsActive(['user_id'=>$this->information['user']['id'], 'requests_left'=>0]);
            if($new_subscription_active->save()) $active = $new_subscription_active;
        }
        if($active){
            $active = ArrayHelper::toArray($active);
            $this->information['user']['subscriptions_active'] = ['requests_left' => $active['requests_left'], 'id' => $active['id']];
        }
    }

    public function getUserInformation()
    {
        $userRecord = \cms\modules\v1\models\base\Users::find()->where(['login'=> trim($this->login)])->one();
        if (!$userRecord) throw new HttpException(404, 'Ошибка. Пользовать не найден');
        $userRecord = ArrayHelper::toArray($userRecord);
        $this->information['user'] = ['id' => $userRecord['id'], 'company'=>$userRecord['company'], 'password'=>'', 'name' => $userRecord['name'], 'status_id' => $this->statusExpiry[(int)$userRecord['status_id']], 'status_expiry' => $userRecord['status_expiry'], 'confirm' => $this->confirm[$userRecord['confirm']]];
    }

    public function mobileRegistration(){
        $mobileRegistration = MobileRegistration::find()->where(['user_id' => $this->information['user']['id']])->andWhere(['<', 'last_sms_date', 'now() - interval 1 day'])->orderBy(['id' => SORT_DESC])->one();
        if($mobileRegistration){
            $this->information['user']['activation_code'] = $mobileRegistration->activation_code;
            $this->information['user']['last_sms_date'] = $mobileRegistration->last_sms_date;
        }
    }

    public function getInvoices()
    {
        $invoices = Invoices::find()->where(['userIdCreate' => $this->information['user']['id']])->andWhere(['<', 'datecreate', 'now() - interval 10 day'])->orderBy(['id' => SORT_DESC])->limit(10)->all();
        if ($invoices) {
            $this->information['invoices'] = ArrayHelper::toArray($invoices);
        }else $this->information['invoices'] = [];
    }
}