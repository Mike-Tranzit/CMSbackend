<?php namespace admin\tests\v1\models\autos;

use admin\modules\v1\models\Autos;
use common\models\cms\base\AutosArchive;

class CustomsMethodsTest extends \Codeception\Test\Unit
{
    /**
     * @var \admin\tests\v1\UnitTester
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
     * testSomeFeature
     *
     * @group transfer
     * @dataProvider archiveParamsProvider
     * @return void
     */
    public function testSomeFeature($window_to, $arrived, $expect)
    {
        $doubleAR = $this->tester->mockActiveRecord(
            ['one' => $this->tester->createCustomClass(['window_to' => $window_to, 'arrived' => $arrived], new AutosArchive())]
        );
        $model = new Autos(self::PLATE);
        expect('Check window && arrived params', $model->allowTransfer())->equals($expect);
        $doubleAR->verifyInvoked('one');
    }

    /**
     * @return array
     */
    public function archiveParamsProvider()
    {
        return [
            ["window_to" => '2019-01-21 00:00:00', "arrived" => 0, 'expect' => 1],
            ["window_to" => '2019-01-01 00:00:00', "arrived" => 1, 'expect' => 0],
        ];
    }
}