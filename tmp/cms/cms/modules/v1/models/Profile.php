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
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($id, $data), false)) !== __AM_CONTINUE__) return $__am_res; 
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
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($v1, $v2), false)) !== __AM_CONTINUE__) return $__am_res; 
        return md5($v1) === $v2;
    }
    
    public function save()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        $this->user->name = $this->information['user']['name'];
        $this->user->company = $this->information['user']['company'];
        if(strlen($this->information['user']['password']) > 3 && !$this->getCompareHash($this->information['user']['password'], $this->user->password)){
            $this->user->password = md5($this->information['user']['password']);
        }
        if(!$this->user->save()) $this->errorSave();
    }

    public function errorSave()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        throw new HttpException(500, 'Ошибка сохранения');
    }
}