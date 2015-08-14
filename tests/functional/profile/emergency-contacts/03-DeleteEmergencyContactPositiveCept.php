<?php

$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Delete Emergency Contact. [Positive Test]');

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

# Delete record
$I->see('Tested  Suited');
$id = $I->grabAttributeFrom('button[title=Delete]', 'id');
$token = $I->grabAttributeFrom('input[name=_token]', 'value');
$I->fillField('input[name=emergency_contact_id]', $id);

$I->sendAjaxPostRequest('/ajax/profile/emergency-contacts', ['id' => $id, '_token' => $token, '_method' => 'DELETE']); // POST
$I->dontSee('Tested  Suited');
