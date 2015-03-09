<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Delete Dependent. [Positive Test]');

# Authorize User
$I->amOnPage('/auth/login');
$I->fillField('email', 'bertrand@verticalops.com');
$I->fillField('password', 'retardko');
$I->click('Login');

# Dashboard
$I->seeCurrentUrlEquals('/dashboard');

# Profile
$I->click('Profile');
$I->seeCurrentUrlEquals('/profile/personal-details');

$I->click('Dependents');
$I->seeCurrentUrlEquals('/profile/dependents');

# Delete record
$I->see('Tested  Suited');
$I->click('button[title=Delete]');

$I->seeCurrentUrlEquals('/profile/dependents');
$I->click('Dependents');
$I->dontSee('Tested  Suited');
