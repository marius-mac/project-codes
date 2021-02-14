# AutoInsanity

[![Build Status](https://scrutinizer-ci.com/g/nfqakademija/autoinsanity/badges/build.png?b=master)](https://scrutinizer-ci.com/g/nfqakademija/autoinsanity/build-status/master)

# Project Description

This web project collects vehicle adverts from various websites and allows users to browse this data.

# Environment requirements

* PHP 7.0
* MySQL
* Symfony 3.2

# Installation
## Download and prepare the project

1. Install [Git](https://git-scm.com/downloads)
1. Clone repository `git clone https://github.com/nfqakademija/autoinsanity.git`
1. cd 'autoinsanity'
1. Get [Composer](https://getcomposer.org/download/)
1. Run `composer install`

## Prepare database - run commands:
1. Create database with `php bin/console doctrine:database:create --if-not-exists`
1. Create tables with `php bin/console doctrine:schema:update --force`
1. Run `php bin/console doctrine:fixtures:load` to insert all needed fixtures to the database.

## Prepare assets
1. Run `php bin/console assets:install --symlink`

## Run project

1. Run `php bin/console server:start`
1. Go to `http://127.0.0.1:8000/`

## Run crawler
- The first time you need to run `php bin/console crawler:start`. This command browses through all adverts and collects them.
- All other times use `php bin/console crawler:start --update`. This will save time as only newly updated adverts will be parsed.
