<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Delete Job Title. [Positive Test]');

# Authorize User
$I->amOnPage('/auth/login');
$I->fillField('email', 'bertrand@verticalops.com');
$I->fillField('password', 'retardko');
$I->click('Login');

# Dashboard
$I->seeCurrentUrlEquals('/dashboard');

# Job Title
$I->click('Job Titles');
$I->seeCurrentUrlEquals('/admin/job/titles');

# Add new record
$I->see('Test');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$token = $I->grabAttributeFrom('input[name=_token]', 'value');

$I->sendAjaxPostRequest('/ajax/delete-job-title', ['id' => $id, '_token' => $token, '_method' => 'DELETE']); // POST
$I->dontSee('Tested');


