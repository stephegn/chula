<?php

class AdminHomePage
{
    // include url of current page
    static $URL = '/admin-kit';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    public static $newPageLink = '#new-page';
    public static $viewSiteLink = '#view-site';
    public static $logoutLink = '#logout';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: EditPage::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }

    /**
     * @var WebGuy;
     */
    protected $webGuy;

    public function __construct(WebGuy $I)
    {
        $this->webGuy = $I;
    }

    /**
     * @return AdminHomePage
     */
    public static function of(WebGuy $I)
    {
        return new static($I);
    }

    public function clickNewPage()
    {
        $I = $this->webGuy;

        $I->amOnPage(self::$URL);
        $I->click(self::$newPageLink);

        return $this;
    }
}