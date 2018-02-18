# console.php
`console.php` is a skeleton for php command-line application.

```php

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

```

## Input

### hasFlag `:boolean`
Check if flag was passed on application.

### hasOption `:boolean`
Check if option was passed on application.

### hasOptions `:boolean`
Check if option(s) was passed on application.

### getOption `:mixed`
Returns the value of option being passed on.

### getOptions `:array`
Returns all options.

### getParameters `:array`
Returns all parameters.

## Output

### write `:void`
Write string buffer.

### writeln `:void`
Write a line of string.

## License

The `calf` is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
