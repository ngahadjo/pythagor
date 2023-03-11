PHPUnit Installation

To get started, create and initiate a new project with composer using these commands:

`
$ mkdir test-project
$ cd test-project
$ composer init
`
Follow the prompt, filling in the details as required (the default values are fine)
PHPUnit is supposed to be a dev-dependency because testing as a whole should only happen during development.
Accept the other defaults and proceed to generating the composer.json file. The generated file should look like this currently:

`
{
    "name": "zubair/test-project",
    "require-dev": {
        "phpunit/phpunit": "^9.5"
    },
    "autoload": {
        "psr-4": {
            "Zubair\\TestProject\\": "src/"
        }
    },
    "authors": [
        {
            "name": "Idris Aweda Zubair",
            "email": "zubairidrisaweda@gmail.com"
        }
    ],
    "require": {}
}
`
https://www.freecodecamp.org/news/test-php-code-with-phpunit/