<?php

namespace cms\modules\v1\models;

use Yii\helpers\ArrayHelper;
use cms\modules\v1\models\base\Invoices;
use cms\modules\v1\models\base\MobileRegistration;
use cms\modules\v1\models\base\SubscriptionsActive;
use cms\modules\v1\models\base\Users;
use cms\modules\v1\helpers\StringHelp;
use Yii;
use yii\web\HttpException;


class Profile
{
    private $user = null;
    public $information = [];

    /**
     * __construct
     *
     * @param  mixed $id
     * @param  mixed $data
     * @codeCoverageIgnore
	 * @ignore Codeception specific
     */
    public function __construct($id, $data)
    {
        $this->user = Users::findOne($id);
        if(!$this->user) $this->errorSave();
        $this->information = $data;
    }

    /**
     * getCompareHash
     *
     * @param  mixed $v1
     * @param  mixed $v2
     *
     */
    public function getCompareHash($v1, $v2)
    {
        return md5($v1) === $v2;
    }
    
    public function save()
    {
        $this->user->name = $this->information['user']['name'];
        $this->user->company = $this->information['user']['company'];
        if(strlen($this->information['user']['password']) > 3 && !$this->getCompareHash($this->information['user']['password'], $this->user->password)){
            $this->user->password = md5($this->information['user']['password']);
        }
        if(!$this->user->save()) $this->errorSave();
    }

    public function errorSave()
    {
        throw new HttpException(500, 'Ошибка сохранения');
    }
}