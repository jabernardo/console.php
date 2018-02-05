#!/usr/bin/php
<?php

require("./src/autoload.php");

class TestCommand implements \Console\Command {
    function __invoke(\Console\Input $i, \Console\Output $o) {
        if (!$i->hasOptions(['name', 'age'])) {
            $o->writeln('Invalid args.');
            return;
        }

        $o->writeln('Hello %s!', $i->getOption('name'));
    }
}

$app = new \Console\Application();
$app->add('create', new TestCommand());
$app->run();
