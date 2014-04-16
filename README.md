#chula

Small blogging/website framework.

Task list: https://trello.com/b/EcvhEDaC/chula

##Installation
1. Checkout this repo
2. Composer install
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

They must be named as shown above.

####home.twig
You are passed an array of pages.
Each page in this array has a slug and content.
To render the page content you MUST use `{{ content | raw}}`

####page.twig
You are currently only passed the content to this page
To render the page content you MUST use `{{ content | raw}}`

##Tests
Tests have been setup in the tests/ directory using Codeception.