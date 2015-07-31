<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update My Contact Details. [Positive Test]');

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

$I->click('Contact Details');
$I->seeCurrentUrlEquals('/profile/contact-details');

# Modify record
$I->click('Modify');
$I->seeCurrentUrlEquals('/profile/contact-details/edit');
$I->fillField('address_1', 'test');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/profile/contact-details');
$I->see('Record successfully updated.');
