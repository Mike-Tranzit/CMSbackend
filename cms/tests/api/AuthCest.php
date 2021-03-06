<?php 
namespace cms\tests;

use cms\tests\ApiTester;
use common\fixtures\UsersFixture;

use PHPUnit\Framework\Constraint\IsType;
use Codeception\Util\HttpCode;

class AuthCest
{
    const TABLE_TOKEN = 'K7sQjA8PE';
    const PASSWORD = 1111;
    const AUTH_URL = 'login/auth';
    const GET_AFTER_AUTH_URL = 'zernovozam/userdocslist';
    private $_token = 'false';
    private $fixture;


    public function _before(ApiTester $I)
    {
        $this->fixture = new UsersFixture();
        $this->fixture->load();
    }

    public function _after(ApiTester $I)
    {
        $this->fixture->unload();
    }

    /**
     * @group testOption
     */
    public function badMethod(ApiTester $I)
    {
        $I->sendGET(self::AUTH_URL);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
    }

    /**
     * @group testOption
     */
    public function optionRouteExist(ApiTester $I)
    {
        $I->wantTo('OPTIONS method is exist');
        $I->sendOPTIONS(self::AUTH_URL);
        $I->seeResponseCodeIsSuccessful();
    }

    public function wrongCredentials(ApiTester $I)
    {
        $status = $I->loginAttempt([
            "username" => '+79181111111',
            "password" => self::PASSWORD,
            "m_n" => self::TABLE_TOKEN
        ]);

        expect("request return Error status", $status['Status'])->equals("error");
    }

    public function success(ApiTester $I)
    {
        $I->wantTo('want to success autorizate');

        $status = $I->loginAttempt([
            "username" => '+79184868905',
            "password" => self::PASSWORD,
            "m_n" => self::TABLE_TOKEN
        ]);;

        expect("request return Success status", $status['Status'])->equals("success");

        $I->seeResponseCodeIsSuccessful();

        expect("result has Token key", $status)->hasKey('token');
        expect("result it is a string", $status['token'])->internalType(IsType::TYPE_STRING);

        $this->_token = $status['token'];
    }

    /**
     * @param ApiTester $I
     */
    public function trySeePageAfterSuccessLogin(ApiTester $I)
    {
        expect("Token is not empty", $this->_token)->notContains('false');
        $I->amBearerAuthenticated($this->_token);
        $I->sendGET(self::GET_AFTER_AUTH_URL);
        $I->seeResponseCodeIsSuccessful();
    }

    public function failAccess(ApiTester $I)
    {
        $status = $I->loginAttempt([
            "username" => '+79184868906',
            "password" => self::PASSWORD,
            "m_n" => self::TABLE_TOKEN

        ]);

        expect("request fail Success status", $status['Status'])->equals("error");
        $I->seeResponseContainsJson([
            'Status' => 'error',
            'message' => 'В доступе отказано',
            'username' => false,
            'password' => true
        ]);
    }
}
