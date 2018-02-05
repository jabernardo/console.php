<?php

namespace Console;

/**
 * Console Application Class
 * 
 * @version     1.0
 * @author      John Aldrich Bernardo <4ldrich@protonmail.com>
 * @package     console.php
 * 
 */
class Application
{
    /**
     * Commands added to the application
     * 
     * @var     array
     * @access  private
     */
    private $_commands = [];

    /**
     * Console Input Object
     * 
     * @var     object
     * @access  private
     */
    private $_input;

    /**
     * Console Output Object
     * 
     * @var     object
     * @access  private
     */
    private $_output;

    /**
     * Class construct function
     * 
     * @access  public
     * @return  void
     * 
     */
    function __construct() {
        if (php_sapi_name() !== 'cli') {
            // Check for SAPI in used
            exit('Application must be run from CLI only.' . PHP_EOL);
        }

        // Instantiate a new Console Input/Output
        $this->_input = new \Console\Input();
        $this->_output = new \Console\Output();
    }

    /**
     * Add console command
     *
     * @param   string      $name       Command Name
     * @param   callable    $command    Callable command
     * @return  void
     */
    public function add($name, callable $command) {
        // Make sure to unify command name
        $commandName = strtolower($name);

        if (isset($this->_command[$commandName])) {
            // throw here
        }

        // Add command
        $this->_commands[$commandName] = $command;
    }
    
    /**
     * Run console application
     *
     * @return void
     */
    public function run() {
        // Use the global $argv variable to retrieve command-line arguments
        global $argv;
        
        // index[0] is the script name and index[1] is the command name
        if (isset($argv[1])) {
            // Get the command through map
            $commandName = strtolower($argv[1]);

            if (isset($this->_commands[$commandName])) {
                $cmd = $this->_commands[$commandName];

                // Execute the command
                return $cmd($this->_input, $this->_output);
            }

            // Execute default command here...
        }
    }
}
