<?php
namespace cms\tests\models;

use Yii;
use cms\modules\v1\models\base\{Invoices, MobileRegistration, SubscriptionsActive};
use cms\modules\v1\models\Information;

use yii\web\HttpException;

use common\fixtures\UsersFixture;
use Codeception\Stub;
use Codeception\Specify;
class InformationTest extends \Codeception\Test\Unit
{
    /**
     * @var \cms\tests\UnitTester
     */

    use Specify;
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
        $this->specify('Check that record exist', function() {

            $property = $this->tester->getPrivateProperty( 
                Information::class, 
                'information' 
            );

            $property->setValue($this->model, [
                'user' => [
                    'id' => 10129
                ]
            ]);

            $this->model->getActiveRequest();

            $information = $property->getValue( $this->model );

            expect('Information array has key: subscriptions_active', $information['user'])->hasKey('subscriptions_active');
        });
    }


    public function testLoginFilter()
    {
        expect($this->model->login)->equals('+79184868904');

    }
}