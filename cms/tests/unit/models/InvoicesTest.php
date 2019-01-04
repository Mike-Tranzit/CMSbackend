<?php

namespace cms\tests\models;

use Yii;
use cms\modules\v1\models\base\Invoices;
use cms\modules\v1\models\base\Orders;
use cms\modules\v1\models\base\SubscriptionsActive;
use cms\modules\v1\models\base\YearSubscription;
use cms\modules\v1\models\base\Users;
use cms\modules\v1\models\InvoicePay;

use yii\web\HttpException;

use common\fixtures\InvoicesFixture;

use cms\tests\Traits\PrivateActions;
use cms\tests\Traits\AspectMockModels;

use Codeception\Stub;
use Codeception\Specify;
use Codeception\Stub\Expected;
use Codeception\Exception\Fail;
use Codeception\Util\HttpCode;
use AspectMock\Test as Test;

class InvoicesTest extends \Codeception\Test\Unit
{
    /**
     * @var \cms\tests\UnitTester
     */

    use Specify;
    use PrivateActions;
    use AspectMockModels;
    
    protected $tester;
    protected $model;
    private $_fixture;
    const FAKE_ID = 0;

    protected function _before()
    {
        $this->_fixture = new InvoicesFixture();
        $this->_fixture->load();
        $invoiceId = $this->_fixture->data[0]['id'];
        $this->model = new InvoicePay($invoiceId);
    }

    protected function _after()
    {
        $this->_fixture->unload();
        Test::clean();
    }

    
    public function testExceptionInvoke()
    {
        try {
            $result = $this->invokePrivateMethod(
                $this->model,
                'errorInvoice'
            );

            $this->fail('Исключение не вызвано');
        } catch (HttpException $e) {
            expect('Код статуса 500', $e->statusCode)->equals(HttpCode::INTERNAL_SERVER_ERROR);
            expect('Сообщение по умолчанию', $e->getMessage())->equals('Ошибка зачисления заявки');
        }
    }

    /**
     * __construct is success
     *
     * @return void
     */
    public function testInitModel()
    {
        $this->specify('Проверяем отработку констурктора при удаче', function () {
            $invoiceId = $this->_fixture->data[0]['id'];
            $model = new InvoicePay($invoiceId);

            $order = $this->getPrivatePropertyValue(
                $model,
                'order'
            );

            expect('order is not null', $order)->notNull();
        });
    }

    /**
     * __construct is fail
     *
     * @return void
     */
    public function testInitModelFail()
    {
        $this->specify('Проверяем отработку констуктора при ошибке', function () {
            try {
                $invoicesMock = $this->mockActiveRecord(
                    ['one' => null]
                );

                $model = new InvoicePay(self::FAKE_ID);

                $invoicesMock->verifyInvoked('one');

                $this->fail('Exception is not invoke');
            } catch (HttpException $e) {
                $this->tester->checkExceptionData($e, HttpCode::INTERNAL_SERVER_ERROR, 'Заявка уже оплачена');
            }
        });
    }

    /**
     * testEnlistment
     *
     * @return void
     */
    public function testEnlistment()
    {
        $this->specify('Присвоение оплатам значения', function () {
            $this->model->Enlistment();
            $invoice = $this->getPrivatePropertyValue(
                $this->model,
                'invoice'
            );
            expect("Check Invoice is not null", $invoice)->notNull();
        });
    }

    /**
     * Тестируем что тариф не premium
     *
     * @return void
     */
    public function testEnlistmentOfTimeSuccess()
    {
        $invoice = Stub::make(InvoicePay::className(), [
            'addSubscriptionsActive' => Expected::once(),
            'addPremiumActive' => Expected::never(),
            'order' => $this->tester->createCustomClass(['tarif_id' => 1])
        ], $this);

        $invoice->EnlistmentOfTime();
    }

    /**
     * Тестируем что тариф premium
     *
     * @return void
     */
    public function testEnlistmentOfTimeFail()
    {
        $invoice = Stub::make(InvoicePay::className(), [
            'addSubscriptionsActive' => Expected::never(),
            'addPremiumActive' => Expected::once(),
            'order' => $this->tester->createCustomClass(['tarif_id' => 0])
        ], $this);

        $invoice->EnlistmentOfTime();
    }

    /**
     * testSuccessPay
     *
     * @return void
     */
    public function testSuccessPay()
    {
        $model = Stub::make(InvoicePay::className(), [
            'invoice' => $this->tester->createCustomClass(['id' => 1]),
            'user' => $this->tester->createCustomClass(['status_id' => 3, 'status_expiry' => date('Y-m-d H:i:s')]),
            'subscriptionsActive' => $this->tester->createCustomClass(['requests_left' => 2])
        ]);
        $pay = $model->successPay();
        expect('Check count success pay', $pay)->count(5);
    }

    /**
     * Тестирование продливания годовой подписки
     * @group new
     * @return void
     */
    public function testAddSubscribeToYear()
    {

        // Устанавливаем ему User property какой нам требуется
        $user = $this->setPrivatePropertyValue(
            $this->model,
            'user',
            $this->tester->createCustomClass([
                'status_expiry' => '2018-12-12 00:00:00',
                'id' => 1
            ])
        );

        // Формируем список mock полей таблицы
        $columns = $this->tester->createColumnsListToMockModels(YearSubscription::className());

        $subscribe = $this->mockActiveRecord(
            [
            'getTableSchema' => $this->tester->createCustomClass(
                ['columns' => $columns]
            )],
            'yii\db\ActiveRecord'
        );

        // Создаем mock объект AR
        $subscribe = $this->mockActiveRecord(
            ['save' => true],
            'yii\db\BaseActiveRecord'
        );

        // Вызываем приватный метод класса
        $this->invokePrivateMethod(
            $this->model,
            'addSubscribeToYear'
        );

        $subscribe->verifyInvoked('save');
    }


    /**
     * Присвоение деталям платежа нужных значений
     * @return void
     */
    public function testAddToInvoicesDetail()
    {
        $subscribe = $this->mockDefaultSaveAction(true);

        $this->specify('Sub_active_old is defined', function () use ($subscribe) {
            $this->setPrivatePropertyValue(
                $this->model,
                'subscriptionsActive',
                $this->tester->createCustomClass(
                    ['requests_left' => 5]
                )
            );
            $this->model->addToInvoicesDetail();

            $subscribe->verifyInvoked('save');
        });
    }

    /**
     * Сброс статуса пользователя в базовый тариф
     *
     * @return void
     */
    public function testRefreshUserStatus()
    {
        $subscribe = $this->mockDefaultSaveAction(true);

        $this->model->refreshUserStatus();
        $user = $this->getPrivatePropertyValue($this->model, 'user');
        expect('Status id is not null', $user->status_id)->equals(1);

        $subscribe->verifyInvoked('save');
    }

    /**
     * Если не существует записи подписки, вызов исключения
     * @throw \yii\web\HttpException
     * @return void
     */
    public function testAddSubscriptionsActiveFail()
    {
        try {
            $this->setPrivatePropertyValue($this->model, 'subscriptionsActive', null);
            $this->model->addSubscriptionsActive();
            $this->fail('Не было выброшено исключение');
        } catch (HttpException $e) {
            $this->tester->checkExceptionData($e, HttpCode::INTERNAL_SERVER_ERROR, 'Ошибка поиска SubscriptionsActive');
        }
    }

    /**
     * Ошибка сохранения
     *
     * @throw \yii\web\HttpException
     * @return void
     */
    public function testAddSubscriptionsActivSaveFail()
    {
        $subscribe = $this->mockDefaultSaveAction(true);

        $this->specify('subscriptionsActive save fail', function () use ($subscribe) {
            try {
                $this->setOrderAndSubscribsionsActive(4, 5);

                $subscribe = $this->mockDefaultSaveAction(false);

                $this->model->addSubscriptionsActive();

                $subscriptions = $this->getPrivatePropertyValue($this->model, 'subscriptionsActive');

                expect('Status id is not null', $subscriptions->requests_left)->equals(9);

                $this->fail('Не было выброшено исключение');
            } catch (HttpException $e) {
                $this->tester->checkExceptionData($e, HttpCode::INTERNAL_SERVER_ERROR, 'Ошибка сохранения в SubscriptionsActive');
            }

            $subscribe->verifyInvoked('save');
        });
    }

    /**
     * testIsLastStatusExpiry
     *
     * @return void
     */
    public function testIsLastStatusExpiry()
    {
        $this->setPrivatePropertyValue(
            $this->model,
            'user',
            $this->tester->createCustomClass([
                'status_expiry' => false
            ])
        );

        $this->invokePrivateMethod($this->model, 'isLastStatusExpiry');
        $isLastStatusExpiry = $this->getPrivatePropertyValue($this->model, 'isLastStatusExpiry');
        $this->assertTrue($isLastStatusExpiry);
    }


    /**
     * testIsDriverTarif
     *
     * @return void
     */
    public function testIsDriverTarif()
    {
        $this->setPrivatePropertyValue(
            $this->model,
            'order',
            $this->tester->createCustomClass([
                'tarif_id' => 100
            ])
        );

        $this->invokePrivateMethod($this->model, 'isDriverTarif');
        $isDriverTarif = $this->getPrivatePropertyValue($this->model, 'isDriverTarif');
        $this->assertTrue($isDriverTarif);
    }


    /**
     * Сохранение подписки, если оплата год то доступ к поднятым заявкам
     * @group test
     * @return void
     */
    public function testAddPremiumActive()
    {
        $subscribe = $this->mockDefaultSaveAction(true);

        $model = Stub::make(InvoicePay::className(), [
            
            'user' => $this->tester->createCustomClass([
                'status_expiry' => date('Y-m-d H:i:s')
            ], new Users()),

            'invoice' => $this->tester->createCustomClass([
                'userIdCreate' => 1,
                'id' => 1
            ]),

            'order' => $this->tester->createCustomClass([
                'count_weeks' => 1,
                'tarif_id' => 4,
                'count_month' => 1
            ])
        ]);

        $model->addPremiumActive();
    }

    //
    // ────────────────────────────────────────────────────────────────────── I ──────────
    //   :::::: A D V A N C E   M E T H O D S : :  :   :    :     :        :          :
    // ────────────────────────────────────────────────────────────────────────────────
    //

    /**
     * Выставления значения заказа и активной заявки при оплате
     *
     * @param  int $requests_left
     * @param  int $count_request
     *
     * @return void
     */
    public function setOrderAndSubscribsionsActive($requests_left, $count_request)
    {
        $this->setPrivatePropertyValue(
            $this->model,
            'subscriptionsActive',
            $this->tester->createCustomClass(
                ['requests_left' => $requests_left],
                new SubscriptionsActive()
            )
        );

        $this->setPrivatePropertyValue(
            $this->model,
            'order',
            $this->tester->createCustomClass(
                ['count_request' => $count_request]
            )
        );
    }
}
