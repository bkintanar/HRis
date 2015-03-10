<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update Emergency Contact. [Positive Test]');

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

$I->click('Emergency Contacts');
$I->seeCurrentUrlEquals('/profile/emergency-contacts');

# Add new record
$I->see('Test  Suite');
$I->click('button[title=Edit]');
$I->fillField('first_name', 'Tested');
$I->fillField('last_name', 'Suited');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/profile/emergency-contacts');
$I->see('Record successfully updated.');
$I->see('Tested  Suited');
