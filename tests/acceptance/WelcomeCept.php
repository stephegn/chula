<?php
$I = new WebGuy($scenario);
$I->wantTo('Ensure homepage is accessible');
$I->amOnPage('/');
$I->see('List of all the posts');
