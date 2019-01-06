<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 08.04.2018
 * Time: 18:10
 */

namespace admin\modules\v1\models;

require_once \Go\Instrument\Transformer\FilterInjectorTransformer::rewrite('C:\Program Files (x86)\Apache24\htdocs\TerminalInformationSystemBackend\admin\modules\v1\models' . '/../../../../common/models/cms/base/AutosArchive.php', __DIR__);
require_once \Go\Instrument\Transformer\FilterInjectorTransformer::rewrite('C:\Program Files (x86)\Apache24\htdocs\TerminalInformationSystemBackend\admin\modules\v1\models' . '/../../../../common/models/cms/base/Autos.php', __DIR__);
require_once \Go\Instrument\Transformer\FilterInjectorTransformer::rewrite('C:\Program Files (x86)\Apache24\htdocs\TerminalInformationSystemBackend\admin\modules\v1\models' . '/../../../../common/helpers/Plates.php', __DIR__);

class Autos
{
    private $plate;
    private $model = NULL;

    public function __construct($plate)
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($plate), false)) !== __AM_CONTINUE__) return $__am_res; 
        $this->plate = \common\helpers\Plates::toBase($plate);
        $this->model = \common\models\cms\base\AutosArchive::find()->where('`num_auto`=:num_auto', [":num_auto" => $this->plate])->orderBy('id DESC')->one();
    }

    public static function listTimeslots()
    { if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array(), true)) !== __AM_CONTINUE__) return $__am_res; 
        $result = [];
        $model = \common\models\cms\base\Autos::find()->where('window_to > now()-interval 100 hour and window_to < now() + interval 2 day and confirm = 1')->orderBy('windows')->all();
        if(!$model) return $result;
        foreach ($model as $item)
        {
            array_push($result,['plate'=>\common\helpers\Plates::fromBase($item->num_auto),'from'=>$item->window_from,'to'=>$item->window_to]);
        }
        return $result;
    }

    public function formationPhoneDeleted()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        $find_phone = strpos($this->model->delete_who, '+7');
        if ($find_phone > 0) return substr($this->model->delete_who, $find_phone);
        return '';
    }

    public function formationDeleteText()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        switch ($this->model->deleted) {
            case 0:
                return 'Таймслот не удален';
                break;
            case 1:
                return 'Удален';
                break;
            case 2:
                return 'Таймслот переносился';
                break;
        }
    }

    public function allowTransfer()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        return ( (strtotime($this->model->window_to)) >  time() - 8*60*60 && $this->model->arrived == 0 )? 1: 0;
    }

    public function searchExist()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        return !$this->model ? [] : ['id' => $this->model->id,'windows' => $this->model->windows, 'window_from' => $this->model->window_from, 'window_to' => $this->model->window_to, 'date_cre' => $this->model->date_cre, 'phone' => $this->model->phone, 'arrived'=> (int)$this->model->arrived, 'deleted' => $this->formationDeleteText(), 'delete_who' => $this->formationPhoneDeleted(), 'delete_date' => $this->model->delete_date? $this->model->delete_date: '', 'allow_transfer' => $this->allowTransfer()];
    }
}