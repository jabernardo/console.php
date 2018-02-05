<?php

namespace Console;

class Application
{
    private $_commands = [];

    private $_input;

    private $_output;

    function __construct() {
        $this->_input = new \Console\Input();
        $this->_output = new \Console\Output();
    }

    public function add($name, callable $command) {
        $commandName = strtolower($name);
        $this->_commands[$commandName] = $command;
    }
    
    public function run() {
        global $argv;
        
        if (isset($argv[1])) {
            $commandName = strtolower($argv[1]);
            
            if (isset($this->_commands[$commandName])) {
                $cmd = $this->_commands[$commandName];
                $cmd($this->_input, $this->_output);
            }
        }
    }
}
