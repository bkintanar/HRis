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

# Emergency Contacts
$I->click('Emergency Contacts');
$I->seeCurrentUrlEquals('/profile/emergency-contacts');

# Update record
$I->see('Test  Suite');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$I->click("button[title=Edit][id=$id]");
$I->fillField('input[name=first_name]', 'Tested');
$I->fillField('input[name=last_name]', 'Suited');
$I->fillField('input[name=emergency_contact_id]', $id);
$I->fillField('input[name=_method]', 'PATCH');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/profile/emergency-contacts');
$I->see('Record successfully updated.');
$I->see('Tested  Suited');
