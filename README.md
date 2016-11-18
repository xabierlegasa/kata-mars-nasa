# Kata Mars NASA


## Specification

See /public/docs/kata-mars-nasa.pdf


## Requirements

PHP >= 7.0
composer


## Run the Code

```
composer install
composer start
```

The kata should be running here: http://localhost:8080/


## Tests

```
./vendor/bin/phpunit --coverage-html public/code-coverage
```
This will update code coverage: http://localhost:8080/



## Some ideas for possible improvements
- More test should be done, if we are really sending something to Mars!
- I wrapped the project with slim framework and bootstrap to show it online. Functional tests covering this functionality could be done.
- Set more restrictions. E.g. Max number of input lines, max number of movements,...
