<?php
use \WebGuy;

class PublishPageCest
{

	public function _before()
	{
	}

	public function _after()
	{
	}

	// tests
	public function publishADraftPage(WebGuy $I)
	{
		$I->am('Administrator');
		$I->wantTo('publish a page');
		$I->copyDir('tests/_data/content', 'content');
		AdminLoginPage::of($I)->login('admin', 'foo');
		$I->amOnPage('/admin-kit');
		$I->see('wordpress-is-awesome');
		$I->see('Publish');
		$I->click('Publish');
		$I->amOnPage('/');
		$I->see('wordpress-is-awesome');


	}

}