<?php

namespace Console;

class Input
{
    private $_flags = [];

    private $_options = [];

    private $_parameters = [];

    function __construct() {
        global $argv;

        for ($i = 2; $i < count($argv); $i++) {
            if (strpos($argv[$i], '-') === 0) {
                $flag = ltrim($argv[$i], '-');
                $flag = strlen($flag) > 1 ? str_split($flag) : [$flag];
                
                $this->_flags = array_merge($this->_flags, $flag);
            } else if (strpos($argv[$i], ':') > 0) {
                $tokens = explode(':', $argv[$i]);

                $param_name = $tokens[0];
                array_shift($tokens);
                $param_value = implode(':', $tokens);
                $this->_options[$param_name] = $param_value;
            } else {
                $this->_parameters[] = $argv[$i];
            }
        }
    }

    public function hasFlag($flag) {
        if (!is_string($flag)) return;
        
        return in_array($flag, $this->_flags);
    }

    public function hasOption($option) {
        if (!is_string($option)) return;

        return isset($this->_options[$option]);
    }

    public function hasOptions(array $options) {
        $all = true;

        foreach ($options as $option) {
            if (!isset($this->_options[$option])) {
                $all = false;
            }
        }

        return $all;
    }

    public function getOption($option) {
        return isset($this->_options[$option]) ?
            $this->_options[$option] :
            null;
    }

    public function getOptions() {
        return $this->_options;
    }

    public function getParameters() {
        return $this->_parameters;
    }
}
