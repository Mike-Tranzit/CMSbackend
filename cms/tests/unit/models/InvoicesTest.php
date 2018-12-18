<?php 

namespace cms\tests\models;

use Yii;
use cms\modules\v1\models\base\Invoices;
use cms\modules\v1\models\InvoicePay;

use yii\web\HttpException;

use common\fixtures\InvoicesFixture;

use Codeception\Stub;
use Codeception\Specify;
use Codeception\Exception\Fail;
use Codeception\Util\HttpCode;
use AspectMock\Test as Test;
class InvoicesTest extends \Codeception\Test\Unit
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
            
            $result = $this->tester->getPrivateMethod($this->model, 'errorInvoice');

            $this->fail('Исключение не вызвано');
        } catch (HttpException $e) {
            expect('Код статуса 500', $e->statusCode)->equals(HttpCode::INTERNAL_SERVER_ERROR);
            expect('Сообщение по умолчанию', $e->getMessage())->equals('Ошибка зачисления заявки');
        }
    }
}