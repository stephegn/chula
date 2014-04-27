<?php
use \WebGuy;

class PageLoadCest
{

    public function _before()
    {
    }

    public function _after()
    {
    }

    // tests

    public function checkViewingAPage(WebGuy $I)
    {
        $I->am('User');
        $I->wantTo('view a page');
        $I->cleanDir('content/drafts');
        $I->cleanDir('content/pages');
        $I->copyDir('tests/_data/default_content', 'content');
        $I->amOnPage('/how-to-create-awesome-posts-in-chula/');
        $I->see('This is how to create great posts in chula');
    }

    public function viewAPageWhichDoesNotExist(WebGuy $I)
    {
        $I->am('User');
        $I->wantTo('view a page that does not exist');
        $I->cleanDir('content/drafts');
        $I->cleanDir('content/pages');
        $I->copyDir('tests/_data/default_content', 'content');
        $I->amOnPage('/this-page-doesnt-exist/');
        $I->see('Those monkeys couldn\'t find the page you were after, hard luck.');
    }
}
