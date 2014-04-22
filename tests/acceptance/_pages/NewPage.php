<?php

class NewPage
{
	// include url of current page
	static $URL = '/admin-kit/new/page';

	/**
	 * Declare UI map for this page here. CSS or XPath allowed.
	 * public static $usernameField = '#username';
	 * public static $formSubmitButton = "#mainForm input[type=submit]";
	 */

	public static $slugField = '#page_slug';
	public static $contentField = '#page_content';
	public static $formSubmitButton = 'input[type=submit]';

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
	 * @return NewPage
	 */
	public static function of(WebGuy $I)
	{
		return new static($I);
	}

	public function createPage($slug, $content)
	{
		$I = $this->webGuy;

		$I->amOnPage(self::$URL);
		$I->fillField(self::$slugField, $slug);
		$I->fillField(self::$contentField, $content);
		$I->click(self::$formSubmitButton);

		return $this;
	}
}