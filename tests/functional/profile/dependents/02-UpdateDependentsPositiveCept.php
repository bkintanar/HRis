<?php

$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update Dependent. [Positive Test]');

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

# Update record
$I->see('Test  Suite');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$I->click("button[title=Edit][id=$id]");
$I->fillField('first_name', 'Tested');
$I->fillField('last_name', 'Suited');
$I->fillField('input[name=dependent_id]', $id);
$I->fillField('input[name=_method]', 'PATCH');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/profile/dependents');
$I->see('Record successfully updated.');
$I->see('Tested  Suited');
