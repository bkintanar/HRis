<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Delete My Job Details. [Positive Test]');

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

# Job
$I->click('Job');
$I->seeCurrentUrlEquals('/profile/job');

# Delete Job record
$I->click('Modify');
$I->seeCurrentUrlEquals('/profile/job/edit');
$I->see('Sr Web Designer');
$id = $I->grabAttributeFrom('button[title=Delete]', 'id');
$token = $I->grabAttributeFrom('input[name=_token]', 'value');

$I->sendAjaxPostRequest('/ajax/profile/job/edit', ['id' => $id, '_token' => $token, '_method' => 'DELETE']); // POST
$I->dontSee('Test Suite');
