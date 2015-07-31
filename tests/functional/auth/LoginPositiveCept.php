<?php 
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Login to HRis App. [Positive Test]');

# Authorize User
$I->amOnPage('/auth/login');
$I->fillField('email', 'bertrand@verticalops.com');
$I->fillField('password', 'retardko');
$I->click('Login');

# Dashboard
$I->seeCurrentUrlEquals('/dashboard');
$I->see('Welcome to Green Wire HRis.');
