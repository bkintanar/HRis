<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Add Dependent. [Positive Test]');

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

# Dependents
$I->click('Dependents');
$I->seeCurrentUrlEquals('/profile/dependents');

# Add new record
$I->see('Add a new row');
$I->fillField('first_name', 'Test');
$I->fillField('last_name', 'Suite');
$I->click('Save changes');
$I->amOnRoute('Save changes');

$I->seeCurrentUrlEquals('/profile/dependents');
$I->see('Record successfully added.');
$I->see('Test  Suite');
