<?php 
namespace cms\models\tests;
use \cms\modules\v1\models\UserDocs;

class DocsTest extends \Codeception\Test\Unit
{
    use \Codeception\Specify;
    /**
     * @var \cms\tests\UnitTester
     */
    protected $tester;
    protected $model;

    protected function _before()
    {
        $this->model = new UserDocs();
    }

    protected function _after()
    {
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

        // $this->specify('add ti List', function() {
        //     $this->model->list[] = ['test'];
        //     expect('want see list is empty', $this->model->getList())->notEmpty();
        // });
    }
}