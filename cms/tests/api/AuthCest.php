<?php 
namespace cms\tests;
use cms\tests\ApiTester;

use common\fixtures\UsersFixture;

class AuthCest
{
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
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
    }
}
