<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Update Termination Reason. [Positive Test]');

# Authorize User
$I->amOnPage('/auth/login');
$I->fillField('email', 'bertrand@verticalops.com');
$I->fillField('password', 'retardko');
$I->click('Login');

# Dashboard
$I->seeCurrentUrlEquals('/dashboard');

# Termination Reasons
$I->click('Termination Reasons');
$I->seeCurrentUrlEquals('/pim/configuration/termination-reasons');

# Add new record
$I->see('Test');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$I->click("button[title=Edit][id=$id]");
$I->fillField('name', 'Tested');
$I->fillField('input[name=termination_reason_id]', $id);
$I->fillField('input[name=_method]', 'PATCH');
$I->click('Save changes');

$I->seeCurrentUrlEquals('/pim/configuration/termination-reasons');
//$I->see('Tested');

