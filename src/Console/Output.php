<?php

namespace Console;

/**
 * Console Output Class
 * 
 * @version     1.0
 * @author      John Aldrich Bernardo <4ldrich@protonmail.com>
 * @package     console.php
 * 
 */
class Output
{
    /**
     * Write output
     *
     * @param   string  $str    String buffer
     * @return  void
     */
    public function write($str) {
        call_user_func_array('printf', func_get_args());
    }

    /**
     * Write line
     *
     * @param   string  $str    String buffer
     * @return  void
     */
    public function writeln($str) {
        call_user_func_array('printf', func_get_args());
        print(PHP_EOL);
    }
}
