<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 08.04.2018
 * Time: 18:10
 */

namespace admin\modules\v1\models;

require_once __DIR__ . '/../../../../common/models/nztmodule3/base/BalanceBlockings.php';
require_once __DIR__ . '/../../../../common/models/nztmodule3/base/BalanceBlockLib.php';
require_once __DIR__ . '/../../../../common/helpers/Plates.php';

class BalanceBlock
{
    private $customerId;
    public $model = NULL;

    public function __construct($id)
    {
        $this->customerId = (int)$id;
        $this->model = \common\models\nztmodule3\base\BalanceBlockings::findOne($id);
    }
}