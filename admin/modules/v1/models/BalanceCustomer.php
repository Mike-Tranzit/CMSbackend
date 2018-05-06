<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 08.04.2018
 * Time: 18:10
 */

namespace admin\modules\v1\models;

require_once __DIR__ . '/../../../../common/models/nztmodule3/base/BalanceCustomerServices.php';
require_once __DIR__ . '/../../../../common/models/nztmodule3/base/BalanceBlockLib.php';
require_once __DIR__ . '/../../../../common/helpers/Plates.php';

class BalanceCustomer
{
    private $model = NULL;
    public $block_info = [
        'is_block' => 0,
        'customer_id'=> 0,
        'date_block' => '',
        'reason' => ''
    ];

    public function __construct($id)
    {
        $this->model = \common\models\nztmodule3\base\BalanceCustomerServices::find()->where('customer_id=:id and blocking_id > 0', [':id' => $id])->one();
        if ($this->model) {
            $block = new \admin\modules\v1\models\BalanceBlock($this->model->blocking_id);
            if ($block->model) $this->block_info = [
                'block_id' => (int)$block->model->id,
                'customer_id' => (int)$this->model->id,
                'date_block' => $block->model->date_block,
                'reason' => $block->model->balanceBlockLib->name
            ];
        }
    }
}