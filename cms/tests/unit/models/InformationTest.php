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
use yii\helpers\ArrayHelper;
use AspectMock\Test as Test;

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
    const FAKE_ID                      = 0;
    const USER_ID_FROM_FIXTURE         = 10129;
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
        Test::clean();
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
            $information = $this->loadInformationPropertyUserId(self::USER_ID_FROM_FIXTURE);

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
        $property = $this->getInformation();
        
        $property = $this->setInformationValue(self::FAKE_ID, $property);

        $information = $this->getValuePrivateProperty($property);

        $this->model->getInvoices();

        expect('Invoices array is empty', $information['invoices'])->isEmpty();
    }

    /**
     * Тестирование присутствия платежей пользователя
     *
     * @return void
     */
    public function testInvoicesIsNotEmpty()
    {
        $property = $this->getInformation();
        $property = $this->setInformationValue(self::USER_ID_FROM_FIXTURE, $property);

        $invoicesMock = Test::double('yii\db\ActiveQuery', [
            'all' => ['id' => 2]
        ]);

        $this->model->getInvoices();

        $information = $this->model->concatDataAndReturn();
        expect('Invoices array is not empty', $information['invoices'])->notEmpty();
        $invoicesMock->verifyInvoked('all');
    }
    

    /**
     * Проверка работоспособности отсылки кода авторизации
     * 
     * @return void
     */
    public function testMobileRegistration()
    {
        $property = $this->getInformation();
        $property = $this->setInformationValue(self::USER_ID_FROM_FIXTURE, $property);

        $invoicesMock = Test::double('yii\db\ActiveQuery', [
            'one' => new MobileRegistration(['activation_code' => 1111, 'last_sms_date' => '2018-12-11 00:00:00'])
        ]);

        $this->model->mobileRegistration();
        
        $information = $this->model->concatDataAndReturn();
        expect('Activation code = 1111', $information['user']['activation_code'])->equals(1111);
        expect('Last sms date = 2018-12-11 00:00:00', $information['user']['last_sms_date'])->equals('2018-12-11 00:00:00');
        $invoicesMock->verifyInvoked('one');

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
        $property = $this->getInformation();

        $property = $this->setInformationValue($id, $property);

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
    public function getInformation()
    {
        $property = $this->tester->getPrivateProperty(
            Information::class,
            'information'
        );

        return $property;
    }

    
    /**
     * setInformationValue
     *
     * @param  mixed $id
     * @param  mixed $property
     *
     * @return void
     */
    public function setInformationValue(int $id, $property, $invoices = [])
    {
        $property->setValue($this->model, [
            'user' => [
                'id' => $id
            ],
            'invoices' => $invoices
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

