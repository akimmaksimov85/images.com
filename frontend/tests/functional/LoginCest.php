<?php
namespace frontend\tests;
use frontend\tests\FunctionalTester;
use frontend\tests\fixtures\UserFixture;

class LoginCest
{
    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
           'user' => [
               'class' => UserFixture::className(),
           ] ,
        ]);
    }


    // tests
    public function checkLoginWorking(FunctionalTester $I)
    {
        $I->amOnRoute('user/default/login');
        
        $formParams = [
          'LoginForm[email]' => '1test@q.q',
          'LoginForm[password]' => '111111',
        ];
        
        $I->submitForm('#login-form', $formParams);
        $I->see('test1', 'form button[type=submit]');
    }
    
    public function checkLoginWrongPassword(FunctionalTester $I)
    {
        $I->amOnRoute('user/default/login');
        
        $formParams = [
          'LoginForm[email]' => '1test@q.q',
          'LoginForm[password]' => '11111',
        ];
        
        $I->submitForm('#login-form', $formParams);
        $I->seeValidationError('Incorrect email or password');
    }
}
