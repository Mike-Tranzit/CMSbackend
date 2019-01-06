<?php namespace admin\tests\models\autos;

use admin\modules\v1\models\Autos;
use common\models\cms\base\AutosArchive;
use Yii;
use yii\web\HttpException;
class FormationTest extends \Codeception\Test\Unit
{
    /**
     * @var \admin\tests\UnitTester
     */
    protected $tester;
    
    const PLATE = "A000AA00";

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * @dataProvider deletedParamsProvider
     * 
     * @return void
     */
    public function testTextForDelete($deleted, $expect)
    {
        $doubleAR = $this->tester->mockActiveRecord(
            ['one' => $this->tester->createCustomClass(['deleted' => $deleted], new AutosArchive())]
        );
        $model = new Autos(self::PLATE);
        expect('Check deleted params as string message for user', $model->formationDeleteText())->equals($expect);
        $doubleAR->verifyInvoked('one');
    }

    /**
     * @return array
     */
    public function deletedParamsProvider()
    {
        return [
            ["deleted" => 0, "expect" => "Таймслот не удален"],
            ["deleted" => 1, "expect" => "Удален"],
            ["deleted" => 2, "expect" => "Таймслот переносился"]
        ];
    }
}