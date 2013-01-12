# Website for SG Tuggen using Symfony CMF

### You will need:
  * Git 1.6+
  * PHP 5.3.3+
  * php5-intl
  * phpunit 3.6+ (optional)
  * composer

## Get the code

    curl -s http://getcomposer.org/installer | php --
    php composer.phar create-project mjanser/sg-tuggen-website path/to/install

This will fetch the main project and all it's dependencies.

The next step is to setup the database, if you want to use Sqlite as your database backend just go ahead and run the following:

    app/console doctrine:database:create
    app/console doctrine:phpcr:init:dbal
    app/console doctrine:phpcr:register-system-node-types
    app/console doctrine:phpcr:fixtures:load

## Symfony CMF

Look at http://symfony.com/doc/master/cmf/index.html for more information about the Symfony CMF.

