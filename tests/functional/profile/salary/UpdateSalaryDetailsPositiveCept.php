<?php

$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update Salary Details. [Positive Test]');

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
$I->click('Modify');
$I->seeCurrentUrlEquals('/profile/salary/edit');

//$I->see('input[id=salary]');

$id = $I->grabAttributeFrom('input[id=salary]', 'type');
//$I->see('xs '.$id);
