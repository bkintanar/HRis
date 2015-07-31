<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update My Personal Details. [Positive Test]');

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

# Modify record
$I->click('Modify');
$I->seeCurrentUrlEquals('/profile/personal-details/edit');
$I->fillField('first_name', 'test');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/profile/personal-details');
$I->see('Record successfully updated.');
