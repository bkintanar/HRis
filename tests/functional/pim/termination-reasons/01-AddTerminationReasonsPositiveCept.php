<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Add Termination Reason. [Positive Test]');

# Authorize User
$I->amOnPage('/auth/login');
$I->fillField('email', 'bertrand@verticalops.com');
$I->fillField('password', 'retardko');
$I->click('Login');

# Dashboard
$I->seeCurrentUrlEquals('/dashboard');

# Termination Reasons
$I->click('Termination Reasons');
$I->seeCurrentUrlEquals('/pim/configuration/termination-reasons');

# Add new record
$I->see('Add a new row');
$I->fillField('name', 'Test');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/pim/configuration/termination-reasons');
$I->see('Record successfully added.');
$I->see('Test');

