<?php

class AdminLoginPage
{
    // include url of current page
    static $URL = '/login';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    static $usernameField = '.form-signin input[name=_username]';
    static $passwordField = '.form-signin input[name=_password]';
    static $loginButton = ".form-signin input[type=submit]";

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
     * @return UserLoginPage
     */
    public static function of(WebGuy $I)
    {
        return new static($I);
    }

    public function login($name, $password)
    {
        $I = $this->webGuy;

        $I->amOnPage(self::$URL);
        $I->fillField(self::$usernameField, $name);
        $I->fillField(self::$passwordField, $password);
        $I->click(self::$loginButton);

        return $this;
    }
}