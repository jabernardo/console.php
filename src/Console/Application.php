<?php

namespace Console;

/**
 * Console Application Class
 * 
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
     * Default command to run
     * 
     * @access  public
     * @var     mixed
     */
    private $_default;

    /**
     * Class construct function
     * 
     * @access  public
     * @return  void
     * @throws  \Console\Exception\Runtime  If applicationn wasn't run on CLI SAPI
     */
    function __construct() {
        if (php_sapi_name() !== 'cli') {
            // Check for SAPI in used
            throw new \Console\Exception\Runtime('Application must be run from CLI only.');
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
     * @param   boolean     $default    Use as default command (false)
     * @return  void
     * @throws  \Console\Exception\Runtime  Duplicated command registered
     */
    public function add($name, callable $command, $default = false) {
        // Make sure to unify command name
        $commandName = strtolower($name);

        if (isset($this->_command[$commandName])) {
            throw new \Console\Exception\Runtime('Duplicated command.');
        }

        if (!is_null($this->_default) && $default) {
            throw new \Console\Exception\Runtime('Default command was already declared.');
        }

        if ($default) {
            $this->_default = $command;
        }

        // Add command
        $this->_commands[$commandName] = $command;
    }

    /**
     * Get command callback
     * 
     * @access  public
     * @param   string  $command 
     * @return  mixed
     * 
     */
    public function get($command) {
        return isset($this->_commands[$command]) ?
            $this->_commands[$command] :
            null;
    }

    /**
     * Get registered commands
     * 
     * @access  public
     * @return  array
     * 
     */
    public function getCommands() {
        return array_keys($this->_commands);
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
                return call_user_func($cmd, $this->_input, $this->_output);
            } else {
                // Command not found
                exit('Command not found: "' . $commandName . '"' . PHP_EOL);
            }
        }

        // Call the default command if set
        if (!is_null($this->_default) && is_callable($this->_default)) {
            return call_user_func($this->_default, $this->_input, $this->_output);
        }
    }
}
