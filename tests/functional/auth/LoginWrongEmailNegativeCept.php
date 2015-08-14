<?php

$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Login to HRis App. [Negative Test]');

$I->amOnPage('/auth/login');

$I->fillField('email', 'test@test.com');
$I->fillField('password', 'retardko');

$I->click('Login');

$I->seeCurrentUrlEquals('/auth/login');
$I->see('These credentials do not match our records.');
