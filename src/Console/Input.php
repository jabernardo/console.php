<?php

namespace Console;

/**
 * Console Input Class
 * 
 * @author      John Aldrich Bernardo <4ldrich@protonmail.com>
 * @package     console.php
 * 
 */
class Input
{
    /**
     * Command-line flags (toggle for features)
     * 
     * @var     array
     * @access  private
     */
    private $_flags = [];

    /**
     * Command-line options (key:value)
     * 
     * @var     array
     * @access  private
     */
    private $_options = [];

    /**
     * Command-line parameters
     *
     * @var     array
     * @access  private
     */
    private $_parameters = [];

    /**
     * Delimeter for options
     * 
     * @var     string
     * @access  private
     * 
     */
    private $_delimeter = ':';

    /**
     * Class construct
     * 
     * @access  public
     * @return  void
     */
    function __construct() {
        $this->parseArgs();
    }

    /**
     * Parse Args
     * 
     * @access  private
     * @return  void
     * 
     */
    private function parseArgs() {
        // Use the global $argv variable to retrieve command-line arguments
        global $argv;

        // Reset values
        $this->_flags       = [];
        $this->_options     = [];
        $this->_parameters  = [];

        // index[0] is the script name and index[1] is the command name
        // so count starts from 2 from now on
        for ($i = 2; $i < count($argv); $i++) {
            if (strpos($argv[$i], '-') === 0) {
                // In gnuopt flags are determined by parameters that starts with `-`
                $flag = ltrim($argv[$i], '-');
                // Make sure that every things splittable
                $flag = strlen($flag) > 1 ? str_split($flag) : [$flag];
                // Then register flags
                $this->_flags = array_merge($this->_flags, $flag);
            } else if (strpos($argv[$i], $this->_delimeter) > 0) {
                // In our history options are the parameters that lets the user
                // to set the value of a key 
                $tokens = explode($this->_delimeter, $argv[$i]);
                // Make sure to remove the option key
                $param_name = strtolower($tokens[0]);
                array_shift($tokens);
                // Then let the others to be the value
                $param_value = implode($this->_delimeter, $tokens);
                // Register options
                // NOTE: Options are allowed to be overwritten
                $this->_options[$param_name] = $param_value;
            } else {
                // Else, it a parameter
                $this->_parameters[] = $argv[$i];
            }
        }
    }

    /**
     * Check if flag exists
     *
     * @access  public
     * @param   string  $flag   Flag to be checked
     * @return  boolean True / False
     * @throws  \Console\Exception\InvalidArgument Parameter must be string
     */
    public function hasFlag($flag) {
        if (!is_string($flag)) {
            throw new \Console\Exception\InvalidArgument('Parameter must be string.');
        }
        
        return in_array($flag, $this->_flags);
    }

    /**
     * Check if option exists
     *
     * @access  public
     * @param   string  $option     Option name
     * @return  boolean True / False
     * @throws  \Console\Exception\InvalidArgument Parameter must be string
     */
    public function hasOption($option) {
        if (!is_string($option)) {
            throw new \Console\Exception\InvalidArgument('Parameter must be string.');
        }

        return isset($this->_options[$option]);
    }

    /**
     * Check if multiple options are given in the command-line arguments
     * 
     * @access  public
     * @param   array   $options    Options to be check
     * @return  boolean True / False
     */
    public function hasOptions(array $options) {
        $all = true;

        foreach ($options as $option) {
            if (!isset($this->_options[$option])) {
                $all = false;
            }
        }

        return $all;
    }

    /**
     * Get option value
     *
     * @access  public
     * @param   string  $option Option name
     * @return  mixed
     */
    public function getOption($option) {
        return isset($this->_options[$option]) ?
            $this->_options[$option] :
            null;
    }

    /**
     * Get options set from command-line arguments
     *
     * @access  public
     * @return  array
     */
    public function getOptions() {
        return $this->_options;
    }

    /**
     * Check parameters from command-line arguments
     *
     * @access  public
     * @return  void
     */
    public function getParameters() {
        return $this->_parameters;
    }

    /**
     * Set option delimeter
     * 
     * @access  public
     * @param   string  $delimeter  Option delimeter (:)
     * @return  void
     * 
     */
    public function setOptionDelimeter($delimeter = ':') {
        $this->_delimeter = $delimeter;

        $this->parseArgs();
    }

    /**
     * Get option delimeter
     * 
     * @access  public
     * @return  string
     * 
     */
    public function getOptionDelimeter() {
        return $this->_delimeter;
    }
}
