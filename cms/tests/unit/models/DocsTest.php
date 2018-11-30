<?php 
namespace cms\models\tests;

use \cms\modules\v1\models\UserDocs;
use \common\fixtures\UserDocsFixture;
class DocsTest extends \Codeception\Test\Unit
{
    use \Codeception\Specify;
    /**
     * @var \cms\tests\UnitTester
     */
    protected $tester;
    protected $model;
    private $fixture;

    public function _before()
    {
        $this->model = new UserDocs();
        $this->fixture = new UserDocsFixture();
        $this->fixture->load();
    }

    public function _after()
    {
        $this->fixture->unload();
    }

    /**
     * @test
     */
    public function checkModelInstanceOf()
    {
        expect('check Instance', $this->model)->isInstanceOf(UserDocs::class);
    }

    /**
     * @test
     */
    public function hasAttributeAndEmptyInitListModel()
    {
        expect('have attribute list', $this->model)->hasAttribute('list');
        expect('want see list is empty', $this->model->getList())->isEmpty();
    }

    /**
     * @test
     */
    public function loadListWillReturnArray()
    {
        $this->model->loadList();
        expect('check count after add temp record', $this->model->getList())->notEmpty();
    }

    public function testPipePhone()
    {
        $phone = $this->model->pipePhone('+79184868904');
        expect($phone)->equals('+7 (918) 48-68-904');
    }
}