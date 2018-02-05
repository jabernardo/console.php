<?php

namespace Console;

/**
 * Command Interface
 * 
 * @version     1.0
 * @author      John Aldrich Bernardo <4ldrich@protonmail.com>
 * @package     console.php
 * 
 */
interface Command
{
    /**
     * Invoke function
     * 
     * @param   \Console\Input  $input  Console Input Object
     * @param   \Console\Output $output Console Output Object
     * @return  void
     */
    public function __invoke(\Console\Input $input, \Console\Output $output);
}
