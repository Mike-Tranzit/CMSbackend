<?php
namespace cms\tests\models;

use Yii;
use cms\modules\v1\models\base\Invoices;
use cms\modules\v1\models\base\MobileRegistration;
use cms\modules\v1\models\base\SubscriptionsActive;
use cms\modules\v1\models\Information;

use yii\web\HttpException;


use common\fixtures\UsersFixture;
use Codeception\Stub;
use Codeception\Specify;
use Codeception\Exception\Fail;
use Codeception\Util\HttpCode;

class InformationTest extends \Codeception\Test\Unit
{
    /**
     * @var \cms\tests\UnitTester
     */

    /**
     * TODO Вынести в отдельный метод запрос приватных свойств
     */
    
    use Specify;
    protected $tester;
    protected $model;
    private $_fixture;
    const FAKE_ID = 0;
    const COUNT_USER_INFORMATION_ARRAY = 7;

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
        $confirm = $this->tester->getPrivateProperty(Information::class, 'confirm');
        expect($this->model->concatDataAndReturn())->isEmpty();
        expect($confirm->getValue($this->model))->count(2);
    }

    /**
     * @group active
     */
    public function testGetActiveRequestExist()
    {
        $this->specify('Check that record exist', function () {
            $information = $this->loadInformationPropertyUserId(10129);

            expect('Information array has key: subscriptions_active', $information['user'])->hasKey('subscriptions_active');
        });
    }

    /**
     * @group active
     */
    public function testGetActiveRequestNotExist()
    {
        $this->specify('Check that record will be a new', function () {
            $information = $this->loadInformationPropertyUserId(self::FAKE_ID);

            $this->tester->seeRecord(SubscriptionsActive::class, [
                'user_id' => 0
            ]);

            expect('Information array has key: subscriptions_active', $information['user'])->hasKey('subscriptions_active');

            expect('Default left request is 0', $information['user']['subscriptions_active']['requests_left'])->equals(0);

            SubscriptionsActive::deleteAll(['user_id' => self::FAKE_ID]);
        });
    }


    public function testLoginFilter()
    {
        expect($this->model->login)->equals('+79184868904');
    }

    /**
     * Тест на отсутствие пользователя в базе
     *
     * @group user
     * @return void
     */
    public function testUserNotFound()
    {
        $this->specify('User Not found', function () {
            $this->model->login = "70000000000";

            try {
                $this->model->getUserInformation();
                $this->fail('Exception is not call');
            } catch (HttpException $e) {
                expect('Check Exception code', $e->statusCode)->equals(HttpCode::NOT_FOUND);
                expect("Check Exception message", $e->getMessage())->equals('Ошибка. Пользовать не найден');
            }
        });
    }

    /**
     * Тест на существование пользователя
     *
     * @group user
     * @return void
     */
    public function testUserExist()
    {
        $this->specify('User if found', function () {
            $this->model->login = '+79184868905';

            $this->model->getUserInformation();

            $property = $this->tester->getPrivateProperty(
                Information::class,
                'information'
            );

            $information = $property->getValue($this->model);

            expect("User information is array", is_array($information['user']))->true();

            expect("Check count user array", count($information['user']) == self::COUNT_USER_INFORMATION_ARRAY)->true();
        });
    }


    /**
     * Тестирование отсутствия платежей пользователя
     *
     * @return void
     */
    public function testInvoicesIsEmpty()
    {
        $property = $this->getInformation(self::FAKE_ID);
        
        $information = $this->getValuePrivateProperty($property);

        $this->model->getInvoices();

        expect('Invoices array is empty', $information['invoices'])->isEmpty();
    }


    
    //
    // ────────────────────────────────────────────────────────────────────── I ──────────
    //   :::::: A D V A N C E   M E T H O D S : :  :   :    :     :        :          :
    // ────────────────────────────────────────────────────────────────────────────────
    //

    /**
     * Заполнение приватного свойства Information -> user -> id
     *
     * @param  integer $id
     *
     * @return array
     */
    public function loadInformationPropertyUserId(int $id)
    {
        $property = $this->getInformation($id);

        $this->model->getActiveRequest();

        $information = $this->getValuePrivateProperty($property);

        return $information;
    }

    /**
     * getInformation
     *
     * @param  integer $id
     *
     * @return void
     */
    public function getInformation(int $id)
    {
        $property = $this->tester->getPrivateProperty(
            Information::class,
            'information'
        );

        $property->setValue($this->model, [
            'user' => [
                'id' => $id
            ],
            'invoices' => []
        ]);

        return $property;
    }

    /**
     * getValuePrivateProperty
     *
     * @param  object $property
     *
     * @return object
     */
    public function getValuePrivateProperty($property)
    {
        return $property->getValue($this->model);
    }
}
