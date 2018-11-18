<?php
namespace cms\tests\Helper;
use Codeception\Util\HttpCode;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Api extends \Codeception\Module
{
    /**
     * loginAttempt
     *
     * @param  mixed $params
     * @param  mixed $result
     *
     * @return void
     */
    public function loginAttempt(array $params)
    {
        $I = $this->getModule('REST');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('login/auth', $params);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseJsonMatchesJsonPath("$.Status");
        $res = $I->grabDataFromResponseByJsonPath('$..'); // берем 1 элемент массива т.е весь массив
        return $res[0];
    }
}