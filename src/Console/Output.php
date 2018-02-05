<?php

namespace Console;

class Output
{
    public function write($str) {
        print($str);
    }

    public function writeln($str) {
        print($str . PHP_EOL);
    }
}
