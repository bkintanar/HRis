<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update Dependent. [Positive Test]');

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

# Add new record
$I->see('Test  Suite');
$I->click('button[title=Edit]');
$I->fillField('first_name', 'Tested');
$I->fillField('last_name', 'Suited');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/profile/dependents');
$I->see('Record successfully added.');
$I->see('Tested  Suited');
