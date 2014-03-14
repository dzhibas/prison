(exception)Prison
=======================

![prison](https://raw.github.com/dzhibas/prison/master/public/images/prison-logo.png)

real time event logging and aggregation platform. error monitoring ported to PHP from well known python project Sentry

you can re-use [Sentry](https://github.com/getsentry/sentry) clients (Raven-*) to report exception to Prison:

    - https://github.com/getsentry/raven-php (php client)
    - https://github.com/getsentry/raven-js (javascript client)

Installation
===============

* clone project
* curl -sS https://getcomposer.org/installer | php  # install composer
* php composer.phar install # install project dependencies
* cp config/autoload/local.php.dist config/autoload/local.php # copy local configuration
* vim config/autload/local.php # add doctrine connection details
* create database (database name was mentioned in configuration file local.php)
* vendor/bin/doctrine-module orm:schema-tool:create # create database schemas out of doctrine entities

Note: for testing / development purposes you can run internal PHP server in root of prison:

    php -S localhost:8080 -t public/

prison is up and running. hit URL, create new account, team and project and you will see guide how to register
exception handler for your specified platform.

Queue workers
================

    php public/index.php queue doctrine "Prison\Queue" --start