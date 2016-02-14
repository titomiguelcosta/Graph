XML GRAPH
=========

A Symfony3 project that parses, validates and transverses a graph data structure.

Deploy
------

$ composer create-project https://github.com/titomiguelcosta/Graph Graphistry

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

* JMSSerializer - to deserialize objects to xml/json
* Validator - to validate objects
* Doctrine - ORM/DBAL to interact with PostgreSQL

References
----------

Some interesting articles that helped me out to implement this project

* SQL recursive queries: http://www.vertabelo.com/blog/technical-articles/sql-recursive-queries
* A PHP Graph library: https://github.com/clue/graph
* Symfony: http://symfony.com/doc/current/index.html

Links
-----

* Homepage: http://graphistry.titomiguelcosta.com
* Source code: https://github.com/titomiguelcosta/Graph