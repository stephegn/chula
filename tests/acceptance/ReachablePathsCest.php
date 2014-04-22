<?php
use \WebGuy;

class ReachablePathsCest
{

  public function _before()
  {
  }

  public function _after()
  {
  }

  // tests
  public function tryToAccessHomepage(WebGuy $I)
  {
    $I->am('Visitor');
    $I->wantTo('Ensure homepage is accessible');
    $I->amOnPage('/');
    $I->see('List of all the posts');
  }

  public function tryToAccessLogin(WebGuy $I)
  {
    $I->am('Administrator');
    $I->wantTo('Ensure login page is accessible'); # assume I'm not logged in
    $I->amOnPage('/login');
    $I->see('Please sign in');
  }

}