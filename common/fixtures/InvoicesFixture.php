<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class InvoicesFixture extends ActiveFixture
{
    use \common\fixtures\_actions\FixturesActions;

    public $modelClass = 'cms\modules\v1\models\base\Invoices';
    public $dataFile = '@cms/tests/_data/invoices_data.php';
}