Tijdschrift voor Geneeskunde
============================

Dit is de nieuwe gemoderniseerde website voor het tijdschrift der geneeskunde.
Management van de abbonees is de belangrijkste verbetering waaraan gewerkt zal
worden. Ook zal het betalen van het abonnement via de website moeten kunnen en
automatisch geupdate worden in de database

Developers
==========
[![Build Status](https://travis-ci.org/TijdschriftVoorGeneeskunde/TijdschriftVoorGeneeskunde.svg)](https://travis-ci.org/
TijdschriftVoorGeneeskunde/TijdschriftVoorGeneeskunde)
[![Join the chat at https://gitter.im/TijdschriftVoorGeneeskunde/TijdschriftVoorGeneeskunde](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/TijdschriftVoorGeneeskunde/TijdschriftVoorGeneeskunde?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
1) Checking your System Configuration
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

The script returns a status code of `0` if all mandatory requirements are met,
`1` otherwise.

If you get any warnings or recommendations, fix them before moving on.

2) Getting your copy of the project running
-------------------------------------------

You need the following programs installed.

    npm
    composer
    symfony
    bower
    gulp
    a database

Execute the following commands to get a working system on your pc.

    npm install                # Download the automation tools
    composer install           # Download php vendor libs + choose parameters
    bower install              # Download javascript and css vendor libs
    gulp dev {prod}            # Install / Concat / Uglify all the js and css in the right folders
    php app/console doctrine:database:create
    php app/console doctrine:schema:update --force # Create tables for the project
    php app/console doctrine:fixture:load          # Initial data likes roles, etc..
    php app/console server:run

3) Which commits get accepted?
------------------------------

I follow the following rule, "simplicity above all else". I will be an ass
about pull requests with very complex code unless you have a good reason. Always
include what you changed and why. If you add new logic or views be sure to
add or update tests.

4) Bundles or no bundles?
-------------------------

For this question I agree with the symfony best practices. Only create
different bundles if the functionality it will bring is 100% isolated from the
app specific code. If this is the case don't forget to check github for
existing implementations that you can reuse instead of writing it from scratch
yourself. Everything else goes in AppBundle.

I hope that by keeping everything
small, simple and not creating special cases or dependencies we can keep the
code as simple as a hello world.
