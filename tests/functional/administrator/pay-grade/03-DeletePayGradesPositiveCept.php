<?php
$I = new FunctionalTester($scenario);

$I->am('HRis User');
$I->wantTo('Delete Pay Grades. [Positive Test]');

# Authorize User
$I->amOnPage('/auth/login');
$I->fillField('email', 'bertrand@verticalops.com');
$I->fillField('password', 'retardko');
$I->click('Login');

# Dashboard
$I->seeCurrentUrlEquals('/dashboard');

# Pay Grades
$I->click('Pay Grades');
$I->seeCurrentUrlEquals('/admin/job/pay-grades');

# Add new record
$I->see('Tested');
$id = $I->grabAttributeFrom('button[title=Edit]', 'id');
$token = $I->grabAttributeFrom('input[name=_token]', 'value');

$I->sendAjaxPostRequest('/ajax/delete-pay-grade', ['id' => $id, '_token' => $token, '_method' => 'DELETE']); // POST
$I->dontSee('Tested');
