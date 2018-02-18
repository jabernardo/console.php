#!/usr/bin/php
<?php

// Require autoloader for console.php
require("../src/autoload.php");

// Sample Command Implementation using \Console\Command Interface
// ./index.php hello name:"Your Name" age:22
class HelloCommand implements \Console\Command {
    function __invoke(\Console\Input $i, \Console\Output $o) {
        if (!$i->hasOptions(['name', 'age'])) {
            $o->writeln('Invalid args.');
            return;
        }

        $o->writeln('Hello %s! So you are %d years old.', $i->getOption('name'), $i->getOption('age'));
    }
}

// Instantiate a new console application
$app = new \Console\Application();

// Register our test HelloCommand to our console application
$app->add('hello', new HelloCommand());

// You can also just declare a command by using callables
$app->add('help', function($i, $o) {
    $o->writeln('This is a sample application.');
}, true); // <-- `true` is to enable this as the default command

// Finally, App and Running!
$app->run();
