<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Login to HRis App. [Negative Test]');

$I->amOnPage('/auth/login');

$I->fillField('email', 'bertrand@verticalops.com');
$I->fillField('password', 'wrong password');

$I->click('Login');

$I->seeCurrentUrlEquals('/auth/login');
$I->see('These credentials do not match our records.');
