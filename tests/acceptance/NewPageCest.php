<?php
use \WebGuy;

class NewPageCest
{

	public function _before()
	{

	}

	public function _after()
	{

	}


	// tests
	public function createNewPage(WebGuy $I)
	{

		$I->am('Administrator');
		$I->wantTo('create a new page');
		$I->cleanDir('content/drafts');
		AdminLoginPage::of($I)->login('admin', 'foo');
		AdminHomePage::of($I)->clickNewPage();
		NewPage::of($I)->createPage('test-draft', '#Testing');
		$I->see('Drafts');
		$I->seeElement('#drafts td');
		$I->see('test-draft');
		$I->seeFileFound('test-draft','content/drafts');
	}

	public function createExistingPage(WebGuy $I)
	{

		$I->am('Administrator');
		$I->wantTo('create a new page which already exists');
		AdminLoginPage::of($I)->login('admin', 'foo');
		AdminHomePage::of($I)->clickNewPage();
		NewPage::of($I)->createPage('test-draft', '#Testing');
		$I->see('That page already exists');
		$I->cleanDir('content/drafts');
	}



}