<?php

$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Delete Dependent. [Positive Test]');

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

# Delete record
$I->see('Tested  Suited');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$I->click("button[title=Edit][id=$id]");
$id = $I->grabAttributeFrom('button[title=Delete]', 'id');
$token = $I->grabAttributeFrom('input[name=_token]', 'value');
$I->click("button[title=Delete][id=$id]");
$I->fillField('input[name=dependent_id]', $id);

$I->sendAjaxPostRequest('/ajax/profile/dependents', ['id' => $id, '_token' => $token, '_method' => 'DELETE']); // POST
$I->dontSee('Tested  Suited');
