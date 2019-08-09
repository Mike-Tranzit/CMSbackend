<?php

namespace cms\modules\v1\models;

use cms\modules\v1\models\base\InvoicesDetail;
use cms\modules\v1\models\base\YearSubscription;
use cms\modules\v1\models\base\SubscriptionsActive;
use cms\modules\v1\models\base\Orders;
use Yii;
use yii\web\HttpException;


class InvoicePay extends \cms\modules\v1\models\base\Invoices
{


    private function errorInvoice($message = 'Ошибка зачисления заявки')
    {
        throw new HttpException(500, $message);
    }

    public $statusExpiry = [1 => 'базовый', 2 => 'перевозчик', 3 => 'заказчик'];
    private $invoice = null;
    private $order = null;
    private $user = null;
    private $isLastStatusExpiry = false;
    private $isDriverTarif = false;
    private $subscriptionsActive = null;
    private $dateExpire;

    /**
     * __construct
     *
     * @param int $id
     * @return void
     */
    public function __construct($id)
    {
        $this->invoice = \cms\modules\v1\models\base\Invoices::find()->where(['id' => $id])->andWhere(['status' => 0])->one();
        if (!$this->invoice) $this->errorInvoice('Заявка уже оплачена');
        $this->order = $this->invoice->orders;
        $this->user = $this->invoice->users;
        $this->subscriptionsActive = $this->invoice->subscriptionsActive;
        $this->dateExpire = date('Y-m-d H:i:s');
        if (!$this->order) $this->errorInvoice('Не верные данные');
        parent::__construct();
    }

    public function Enlistment()
    {
        $this->invoice->status = 1;
        $this->invoice->dateresult = new \yii\db\Expression('NOW()');
        $this->invoice->amountIncome = $this->invoice->amount;
        if (!$this->invoice->methodPay || $this->invoice->methodPay == 0) $this->invoice->methodPay = $this->order->tarif_id;
        if (!$this->invoice->save()) $this->errorInvoice('Ошибка сохранения в Invoices');
    }

    public function EnlistmentOfTime()
    {
        if ($this->order->tarif_id == 1) $this->addSubscriptionsActive();
        else $this->addPremiumActive();
    }

    public function addToInvoicesDetail($requests_left = false, $date_left = false)
    {
        $invoicesDetail = new InvoicesDetail(['date_create' => new \yii\db\Expression('NOW()'), 'user_id' => $this->invoice->userIdCreate, 'invId' => $this->invoice->id]);
        if (!$date_left) {
            $invoicesDetail->sub_active_old = $requests_left;
            $invoicesDetail->sub_active_new = $this->subscriptionsActive->requests_left;
        } else {
            $invoicesDetail->date_old = $date_left;
            $invoicesDetail->date_new = $this->user->status_expiry;
        }
        $invoicesDetail->save();
    }

    public function refreshUserStatus()
    {
        $this->user->status_id = 1;
        $this->user->save(false);
    }

    public function addSubscriptionsActive()
    {
        if (!$this->subscriptionsActive) $this->errorInvoice('Ошибка поиска SubscriptionsActive');

        $requests_left = $this->subscriptionsActive->requests_left;
        $this->subscriptionsActive->requests_left = ($this->order->count_request + $this->subscriptionsActive->requests_left);
        if (!$this->subscriptionsActive->save()) $this->errorInvoice('Ошибка сохранения в SubscriptionsActive');

        $this->addToInvoicesDetail($requests_left);
        if ($this->user->status_id == 2 && strtotime($this->user->status_expiry) < time()) $this->refreshUserStatus();
    }

    /**
     * isLastStatusExpiry
     *
     * @return void
     */
    private function isLastStatusExpiry()
    {
        $this->isLastStatusExpiry = (strtotime($this->user->status_expiry) < time() OR !$this->user->status_expiry OR substr($this->user->status_expiry, 4) == '1970')
            ? true : false;
    }

    private function isDriverTarif()
    {
        $this->isDriverTarif = in_array($this->order->tarif_id, array(8, 9, 10, 100, 11)) ? true : false;
    }

    /**
     * addPeriodToStatusExpire
     *
     * @param  mixed $value
     * @param  mixed $period
     *
     * @return void
     */
    public function addPeriodToStatusExpire($value, $period)
    {
        $this->user->status_expiry = date('Y-m-d H:i:s', strtotime("{$this->dateExpire} +" . $value . " " . $period) + (60 * 60 * 3));
    }

    public function addPremiumActive()
    {
        $date_expire_history = $this->user->status_expiry;

        $this->isLastStatusExpiry();
        $this->isDriverTarif();

        if (!$this->isLastStatusExpiry) {
            $this->dateExpire = $this->user->status_expiry;
        }
        if ($this->order->count_weeks > 0) {
            $value = $this->order->count_weeks * 7;
            $this->addPeriodToStatusExpire($value, " days");
        } else {
            $this->addPeriodToStatusExpire($this->order->count_month, " months");
        }
        $this->user->status_id = $this->isDriverTarif ? 2 : 3;
        if ($this->user->save()) {

            if ($this->order->tarif_id == 4) {
                $this->addSubscribeToYear();
            }
            $this->addToInvoicesDetail(false, $date_expire_history);
        }
    }

    private function addSubscribeToYear()
    {
        $model = new YearSubscription(['count_request' => 1, 'date_to' => $this->user->status_expiry, 'user_id' => $this->user->id, 'date_create' => new \yii\db\Expression('NOW()')]);
        $model->save();
    }

    public function successPay()
    {
        return ['id' => $this->invoice->id, 'dateresult' => date('Y-m-d H:i:s', time() + (60 * 60 * 3)), 'status_id' => $this->statusExpiry[$this->user->status_id], 'status_expiry' => $this->user->status_expiry, 'requests_left' => $this->subscriptionsActive->requests_left];
    }

    public function groupByDateProblem()
    {
        
    }
}
