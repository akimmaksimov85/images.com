<?php
namespace frontend\tests;
use frontend\tests\FunctionalTester;

class AboutCest
{
    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->amOnRoute('site/about');
        $I->see('About Images project', 'h1');
    }
}
