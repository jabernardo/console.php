<?php

if (file_exists('PHPUnit/Autoload.php'))
    require_once('PHPUnit/Autoload.php');

// backward compatibility
if (!class_exists('\PHPUnit\Framework\TestCase') &&
    class_exists('\PHPUnit_Framework_TestCase')) {
    class_alias('\PHPUnit_Framework_TestCase', '\PHPUnit\Framework\TestCase');
}

class ConsoleTest extends \PHPUnit\Framework\TestCase
{
    function testConsole() {
        global $argv;
        $argv = [
            'index.php',
            'test',
            'sample2',
            'name:aldrich',
            'age:22',
            '-qf',
            'sample'
        ];

        $app = new \Console\Application();

        $this->assertTrue($app instanceof \Console\Application);

        $app->add('test', function(\Console\Input $i, \Console\Output $o) {
            $this->assertTrue($i->hasOption('name'));
            $this->assertEquals($i->getOption('name'), 'aldrich');
            $this->assertEquals($i->getOption('age'), 22);
            $this->assertTrue($i->hasFlag('q'));
            $this->assertEquals(count($i->getParameters()), 2);
        });

        $app->run();
    }
}
