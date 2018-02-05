<?php

namespace Console;

class Output
{
    public function write($str) {
        call_user_func_array('printf', func_get_args());
    }

    public function writeln($str) {
        call_user_func_array('printf', func_get_args());
        print(PHP_EOL);
    }
}
