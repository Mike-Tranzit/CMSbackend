<?php namespace admin\tests\v1\models\autos;

use admin\modules\v1\models\Autos;
use common\models\cms\base\AutosArchive;

class CustomsMethodsTest extends \Codeception\Test\Unit
{
    /**
     * @var \admin\tests\v1\UnitTester
     */
    protected $tester;
    protected $mock;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    protected function _inject(\admin\tests\v1\Helper\Mock $mock)
    {
        $this->mock = $mock;
    }

    /**
     * testSomeFeature
     *
     * @dataProvider archiveParamsProvider
     * @return void
     */
    public function testAllowTransfer($window_to, $arrived, $expect)
    {
        $doubleAR = $this->tester->mockOne(['window_to' => $window_to, 'arrived' => $arrived], new AutosArchive());

        $model = new Autos($this->mock::PLATE);
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


    /**
     * testSearchEmpty
     *
     * @return void
     */
    public function testSearchEmpty()
    {
        $doubleAR = $this->tester->mockActiveRecord(['one' => null]);
        $this->assertCount(0, (new Autos($this->mock::PLATE))->searchExist());
    }


    /**
     * testSearchNotEmpty
     *
     * @return void
     */
    public function testSearchNotEmpty()
    {
        $doubleAR = $this->tester->mockOne(['id' => $this->mock::ID], new AutosArchive());
        $this->assertArrayHasKey('id', (new Autos($this->mock::PLATE))->searchExist());
        $doubleAR->verifyInvoked('one');
    }

    /**
     * testFormationPhoneDeleted
     *
     * @return void
     */
    public function testFormationPhoneDeleted()
    {
        $doubleAR = $this->tester->mockOne(['delete_who' => $this->mock::PHONE_WHO_DELETED], new AutosArchive());

        $model = new Autos($this->mock::PLATE);
        expect('Check +7 in phone number', $model->formationPhoneDeleted())->equals(substr($this->mock::PHONE_WHO_DELETED, 6));
        $doubleAR->verifyInvoked('one');
    }

    /**
     * testListTimeslotsEmpty
     *
     * @return void
     */
    public function testListTimeslotsEmpty()
    {
        $doubleAR = $this->tester->mockActiveRecord(['all' => null]);
        $this->assertCount(0, Autos::listTimeslots());
    }

    /**
     * testListTimeslots
     *
     * @group transfer
     * @return void
     */
    public function testListTimeslots()
    {
        $doubleAR = $this->tester->mockActiveRecord(['all' => [
            $this->tester->createCustomClass([
                'num_auto' => $this->mock::PLATE, 
                'window_from' => $this->mock::DATE_TIME, 
                'window_to' => $this->mock::DATE_TIME
            ])
        ]
        ]);
        $this->assertCount(1, Autos::listTimeslots());
    }
}
