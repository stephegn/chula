<?php
$I = new WebGuy($scenario);
$I->wantTo('Check the login page has the correct elements');
$I->amOnPage('/login');
$I->see('Please sign in');
$I->seeElement("form input[name=_username]");
$I->seeElement("form input[name=_password]");
$I->seeElement("form input[type=submit]");
