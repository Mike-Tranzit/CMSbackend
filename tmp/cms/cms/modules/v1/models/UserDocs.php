<?php

namespace cms\modules\v1\models;

use Yii;
use yii\helpers\ArrayHelper;

class UserDocs extends \cms\modules\v1\models\base\UserDocs
{
    private $list = [];

    public function loadList()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        $list = UserDocs::find()->select(['company_name', 'user_id', 'us.login'])->joinWith(['users as us'])->where('LENGTH(`company_name`) > 5 and (SUBSTR(`company_name`, 1, 2) = "ИП" OR SUBSTR(`company_name`, 1, 3) = "ООО") and us.name is not NULL and us.last_in > (now() - interval 60 day)')->all();
        $this->list = ArrayHelper::getColumn($list, function ($element) {
            return ['user_id' => $element->user_id, 'company_name' => $element->company_name, 'login' => $this->pipePhone($element->users->login)];
        });
    }

    public function pipePhone($value)
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($value), false)) !== __AM_CONTINUE__) return $__am_res; 
        return substr($value, 0, 2) . " (" . substr($value, 2, 3) . ") " . substr($value, 5, 2) . "-" . substr($value, 7, 2) . "-" . substr($value, 9, 3);
    }

    public function getList()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        return $this->list;
    }

    public function getUsers()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        return $this->hasOne(\cms\modules\v1\models\base\Users::className(), ['id' => 'user_id']);
    }
}
