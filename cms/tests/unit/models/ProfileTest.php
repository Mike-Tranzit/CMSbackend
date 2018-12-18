<?php 
namespace cms\tests\models;
use cms\modules\v1\models\Profile;
use Codeception\Stub;
use common\fixtures\UsersFixture;
use Yii;
use yii\web\HttpException;
class ProfileTest extends \Codeception\Test\Unit
{
    /**
     * @var \cms\tests\UnitTester
     */
    protected $tester;
    protected $model;
    private $_fixture;

    protected function _before()
    {
        $this->model = Stub::make(Profile::class, [
            'user' => null,
            'information' => require Yii::getAlias('@cms/tests/_data/information_profile_data.php')
        ]);
    }

    protected function _after()
    {
        
    }

    public function testErrorAction()
    {
        try {
            $this->model->errorSave();
            $this->expectException(\HttpException::class);
            $this->fail("Exception is not call.");
        } catch (HttpException $ex) {
            $this->assertEquals($ex->getMessage(), "Ошибка сохранения");
        }
    }
    
    public function testSave()
    {
        $property = $this->tester->getPrivateProperty( Profile::class, 'user' );

        $property->setValue($this->model, 
            Stub::make(\cms\modules\v1\models\base\Users::class, [
                'save' => function() { return true; },
                'password' => 1111,
                'name' => '',
                'company' => ''
            ])
        );

        try {
            $this->model->save();
        } catch (HttpException $ex) {
            $this->fail("Exception is call.");
        }
    }

    public function testCompareHash()
    {
        $mostSuccess = $this->model->getCompareHash(1111, md5(1111));
        expect($mostSuccess)->true();

        $mostFail = $this->model->getCompareHash(1111, 1111);
        expect($mostFail)->false();
    }
}