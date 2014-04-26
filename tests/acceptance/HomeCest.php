<?php
use \WebGuy;

class HomeCest
{

	public function _before()
	{
	}

	public function _after()
	{
	}

	// tests
	public function checkHomePageListPages(WebGuy $I)
	{
		$I->am('User');
		$I->wantTo('see a list of posts');
		$I->copyDir('tests/_data/config_list_home', 'config');
		$I->copyDir('tests/_data/content', 'content');
		$I->amOnPage('/');
		$I->see('how-to-create-awesome-posts-in-chula');
		$I->dontSee('wordpress-is-awesome');


	}

	// tests
	public function checkStaticHomePage(WebGuy $I)
	{
		$I->am('User');
		$I->wantTo('see a static home page');
		$I->copyDir('tests/_data/config_static_home', 'config');
		$I->amOnPage('/');
		$I->see('© Copyright 2014');
		$I->dontSee('how-to-create-awesome-posts-in-chula');
		$I->copyDir('tests/_data/config_list_home', 'config');


	}

}