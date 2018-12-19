<?php

namespace cms\tests\models;

use Yii;
use cms\modules\v1\models\base\{Invoices, Orders, SubscriptionsActive, YearSubscription};
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
            'order' => new Orders(['tarif_id' => 1])
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
            'order' => new Orders(['tarif_id' => 0])
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

        $subscribe = $this->mockActiveRecord([
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
}
