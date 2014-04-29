<?php
use \WebGuy;

class PageCest
{

    public function _before()
    {
    }

    public function _after()
    {
    }

    protected function setup(WebGuy $I)
    {
        $I->cleanDir('content/drafts'); # cleanup
        $I->cleanDir('content/pages');
        AdminLoginPage::of($I)->login('admin', 'foo'); # login
    }

    // tests
    /**
     * @before setup
     */
    public function createNewPage(WebGuy $I)
    {

        $I->am('Administrator');
        $I->wantTo('create a new page');
        AdminHomePage::of($I)->clickNewPage();
        NewPage::of($I)->createPage('test-draft', '#Testing');
        $I->see('Drafts');
        $I->seeElement('#drafts td');
        $I->see('test-draft');
        $I->seeFileFound('test-draft', 'content/drafts');
    }

	/**
	 * @before createNewPage
	 */
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

    /**
     * @before createNewPage
     */
    public function publishDraft(WebGuy $I)
    {
        $I->am('Administrator');
        $I->wantTo('publish a draft');
        $I->canSeeFileFound('test-draft', 'content/drafts');
        AdminLoginPage::of($I)->login('admin', 'foo');
        AdminHomePage::of($I)->clickPublishPage('test-draft');
        $I->see('Your Pages');
        $I->seeElement('#published td');
        $I->canSeeFileFound('test-draft', 'content/pages');
    }

    /**
     * @before publishDraft
     */
    public function editExistingPage(WebGuy $I)
    {
        $I->am('Administrator');
        $I->wantTo('edit a page');
        $I->canSeeFileFound('test-draft', 'content/pages');
        AdminLoginPage::of($I)->login('admin', 'foo');
        AdminHomePage::of($I)->clickEditPage('test-draft', 'published');
        $I->seeElement('#page_slug');
        $I->seeElement('#page_content');
        $I->seeInField('#page_slug', 'test-draft');
        $I->fillField('#page_content', 'This is a great page');
        $I->click('submit');
        $I->amOnPage('/test-draft');
        $I->see('This is a great page');
    }

    /**
     * @before publishDraft
     */
    public function deletePageBadStatus(WebGuy $I)
    {
        $I->am('Administrator');
        $I->wantTo('delete a page with a bad status');
        $I->canSeeFileFound('test-draft', 'content/pages');
        AdminLoginPage::of($I)->login('admin', 'foo');
        AdminHomePage::of($I)->clickDeletePage('test-draft', 'pages');
        $I->see('That type does not exist');
        $I->dontSee('test-draft');
    }

    /**
     * @before publishDraft
     */
    public function deletePage(WebGuy $I)
    {
        $I->am('Administrator');
        $I->wantTo('delete a page');
        $I->canSeeFileFound('test-draft', 'content/pages');
        AdminLoginPage::of($I)->login('admin', 'foo');
        AdminHomePage::of($I)->clickDeletePage('test-draft', 'published');
        $I->see('Your Pages');
        $I->dontSee('test-draft');
    }



}