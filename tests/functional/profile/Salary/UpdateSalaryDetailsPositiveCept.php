<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update My Salary Details. [Positive Test]');

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

# Salary
$I->click('Salary');
$I->seeCurrentUrlEquals('/profile/salary');

# Modify record
$I->amOnPage('/profile/salary/edit');
$I->fillField('Monthly_Basic["value"]', '50000.00');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/profile/salary');
$I->see('Record successfully updated.');


