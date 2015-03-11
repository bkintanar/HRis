<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Delete Work Shifts. [Positive Test]');

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

$I->click('Work Shifts');
$I->seeCurrentUrlEquals('/profile/work-shifts');

$I->click('Modify');
$I->seeCurrentUrlEquals('/profile/work-shifts/edit');

# Delete record
$I->see("<td>Admin</td>");
$id = $I->grabAttributeFrom('button[title=Delete]', 'id');
$token = $I->grabAttributeFrom('input[name=_token]', 'value');

$I->sendAjaxPostRequest('/ajax/profile/work-shifts/edit', ['id' => $id, '_token' => $token, '_method' => 'DELETE']); // POST
$I->dontSee("<td>Admin</td>");