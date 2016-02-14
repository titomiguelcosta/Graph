XML GRAPH
=========

A Symfony3 project that parses, validates and transverses a graph data structure.

Dependencies
------------

* Git
* Composer
* PostgreSQL
* PHP 5.5+

Deploy
------

$ git clone https://github.com/titomiguelcosta/Graph graphistry

Change to project directory:
$ mv graphistry

Install dependencies:
$ composer install

Edit the PostgreSQL database parameters on app/config/parameters.yml

Update database schema:
$ php bin/console doctrine:migrations:migrate

Start web server:
$ php bin/console server:run

Visit on your favourite browser http://127.0.0.1:8000

To run the unit tests (PHPUnit):
$ php vendor/bin/phpunit

To run the function tests (Behat):
$ php vendor/bin/behat

Libraries
---------

* [JMSSerializer](http://jmsyst.com/libs/serializer) - to deserialize objects to xml/json
* [Validator](http://symfony.com/doc/current/book/validation.html) - to validate objects
* [Doctrine](http://www.doctrine-project.org/) - ORM/DBAL to interact with PostgreSQL

References
----------

Some interesting articles that helped me out to implement this project

* [SQL recursive queries](http://www.vertabelo.com/blog/technical-articles/sql-recursive-queries)
* [A PHP Graph library](https://github.com/clue/graph)
* [Symfony](http://symfony.com/doc/current/index.html)

Links
-----

* [Homepage](http://graphistry.titomiguelcosta.com)
* [Source code](https://github.com/titomiguelcosta/Graph)