<?php
namespace cms\tests\models;

use Yii;
use cms\modules\v1\models\base\{Invoices, MobileRegistration, SubscriptionsActive};
use cms\modules\v1\models\Information;

use yii\web\HttpException;

use common\fixtures\UsersFixture;
use Codeception\Stub;
class InformationTest extends \Codeception\Test\Unit
{
    /**
     * @var \cms\tests\UnitTester
     */
    protected $tester;
    protected $model;
    private $_fixture;

    protected function _before()
    {
        $this->_fixture = new UsersFixture();
        $this->_fixture->load();
        $this->model = new Information('+7 (918) 48-68-904');
    }

    protected function _after()
    {
        $this->_fixture->unload();
    }

    /**
     * @group propertys
     */
    public function testHasPublicDefaultPropertys()
    {
        expect($this->model)->hasAttribute('login');
        expect($this->model)->hasAttribute('statusExpiry');
    }

    /**
     * @group propertys
     */
    public function testCountDefaultStatuses()
    {
        expect($this->model->statusExpiry)->count(3);
    }

    /**
     * @group propertys
     */
    public function testHasPrivateDefaultPropertys()
    {
        $confirm = $this->tester->getPrivateProperty( Information::class, 'confirm' );
        expect($this->model->concatDataAndReturn())->isEmpty();
        expect($confirm->getValue($this->model))->count(2);
    }

    /**
     * @group active
     */
    public function testGetActiveRequestExist()
    {
        $informationStub = Stub::make(Information::class, [
            'information' => [],
            'getActiveRequest' => function() use (information) {
                $information['user']['subscriptions_active'] = ['requests_left' => 1, 'id' => 10290];
            }
        ]);

        expect('Information requests left is up', $informationStub->information['user']['subscriptions_active']['requests_left'])->equals(1);
        // $information = $this->tester->getPrivateProperty( Information::class, 'information' );
        // $property->setValue($this->model, [['user'=> ['id' => 10129]]]);
        // $this->model->getActiveRequest();

    }

    public function testLoginFilter()
    {
        expect($this->model->login)->equals('+79184868904');

    }
}