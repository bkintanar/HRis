<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Add Emergency Contact. [Positive Test]');

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

# Emergency Contacts
$I->click('Emergency Contacts');
$I->seeCurrentUrlEquals('/profile/emergency-contacts');

# Add new record
$I->see('Add a new row');
$I->fillField('first_name', 'Test');
$I->fillField('last_name', 'Suite');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/profile/emergency-contacts');
$I->see('Record successfully added.');
$I->see('Test  Suite');
