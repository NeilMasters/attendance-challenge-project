# Attendance

A challenge project to create an attendance recording service within a set time limit.

For a full list of common commands see the Makefile

## requirements

If you want to run this _easily_ locally you will need:

1. php 8.1
2. composer
3. symfony cli
4. docker

If you want to generate test-coverage reports you will require:

5. phpdbg

If you want to generate phpdocs you will require:

6. phpDocumenter https://docs.phpdoc.org/3.0/

## run it!

### just once

```bash
cp .env.example .env && composer install
```

### repeated dev env setups

`dev-up` will spin up a docker container for your database, run your migrations and
then fire up a local symfony cli server.

```bash
make dev-up
```

## test it!

`quality` will run phpstan, phpcs, unit tests and integration tests.

```bash
make quality
```

## beast it!

Using a modified version of https://gist.github.com/cirocosta/de576304f1432fad5b3a load-test will execute 
progressively more beasty volumes of requests.

Warning: Best not tinker with pushing the settings too high - your computer will sound like a hovercraft.

```bash
make load-test-(light|medium|heavy)
```