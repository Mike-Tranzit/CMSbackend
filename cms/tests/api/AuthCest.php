<?php 
namespace cms\tests;
use cms\tests\ApiTester;
use common\fixtures\UsersFixture;
use Codeception\Util\HttpCode;
class AuthCest
{
    const TABLE_TOKEN = 'K7sQjA8PE';
    const PASSWORD = 1111;

    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'users' => [
                'class' => UsersFixture::className(),
                'dataFile' => codecept_data_dir() . 'users_login_data.php'
            ]
        ]);
    }

    public function badMethod(ApiTester $I)
    {
        $I->sendGET('/login/auth');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
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
        $status = $I->loginAttempt([
                "username" => '+79184868905',
                "password" => self::PASSWORD,
                "m_n" => self::TABLE_TOKEN
        ]);;

        expect("request return Success status", $status['Status'])->equals("success");
    }

    public function failAccess(ApiTester $I)
    {
        $status = $I->loginAttempt([
                "username" => '+79184868906',
                "password" => self::PASSWORD,
                "m_n" => self::TABLE_TOKEN
            
        ]);

        expect("request return Success status", $status['Status'])->equals("error");
        $I->seeResponseContainsJson([
            'Status' => 'error', 
            'message' => 'В доступе отказано',
            'username' => false,
            'password' => true
        ]);
    }
}
