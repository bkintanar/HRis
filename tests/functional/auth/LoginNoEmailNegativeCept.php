<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Login to HRis App. [Negative Test]');

$I->amOnPage('/auth/login');

$I->fillField('email', '');
$I->fillField('password', 'retardko');

$I->click('Login');

$I->seeCurrentUrlEquals('/auth/login');
$I->see('The email field is required.');