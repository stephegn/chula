#chula

Small blogging/website framework.

[![Build Status](https://travis-ci.org/stephcook22/chula.svg?branch=master)](http://travis-ci.org/stephcook22/chula)

Task list: https://trello.com/b/EcvhEDaC/chula

##Installation
1. Run `composer create-project chula/chula chula 1.0.0-alpha`
3. Add content/draft and content/pages folders in the project root
4. You're done!

##Templating
A very basic example of a template set has been included. To make your own template simply copy this folder
and give it a new name.
Change the 'theme' config variable to your new folder name and Chula should then run off your theme.

For the moment there aren't a huge amount of twig variables available to you. If you find you need more please let us
know so we can add them to the main build.

To render the page content you MUST use `{{ content | raw}}`

###Global variables
The following are twig variables which are always accessible in any of your templates
  * `admin_path` - path to the admin kit
  * `app.request.getBaseURL()` - base url to the app


###Template Pages
The page templates currently called are:
  * home.twig
  * page.twig
  * 404.twig
  * error.twig

They must be named as shown above.

####home.twig
You are passed an array of pages.
Each page in this array has a slug, date and content.
To render the page content you MUST use `{{ content | raw}}`

####page.twig
You are currently passed the content to this page.
You are now also passed the `{{date}}` and the `{{slug}}`
To render the page content you MUST use `{{ content | raw}}`

You can format the date with the date filter in twig eg `{{page.date|date}}`
You also have access to the truncate filter eg `{{ page.content|truncate(150)|raw }}`

####error.twig and 404.twig
These are called if an error or specifically a 404 error occurs.
You are passed in the `{{message}}` which you can display if you like.

##Tests
Tests have been setup in the tests/ directory using Codeception.
###Coverage
wget https://raw.github.com/Codeception/c3/master/c3.php

vendor/codeception/codeception/codecept run --coverage --xml --html

