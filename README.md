#chula

Small blogging/website framework.

[![Build Status](https://travis-ci.org/stephcook22/chula.svg?branch=master)](http://travis-ci.org/stephcook22/chula)

![Codeship Status](https://www.codeship.io/projects/814a0670-ca4b-0131-bf83-1a857f2293be/status)]

Task list: https://trello.com/b/EcvhEDaC/chula

##[Installation](https://github.com/stephcook22/chula/wiki/Installation)


##[Templating](https://github.com/stephcook22/chula/wiki/Templating)

## Build
 * `composer install`
 * `mkdir -p content/drafts content/pages`
 * `php -S localhost:8000 -t web`

##Tests
Tests have been setup in the tests/ directory using Codeception.
 * `./bin/codecept build` (`bin\codecept.bat build`)
 * `mkdir -p tests/_log`
 * ``./bin/codecept(.bat) run` (`bin\codecept.bat run`)

###Coverage
 * `./bin/codecept run --coverage --xml --html`

