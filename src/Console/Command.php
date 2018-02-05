<?php

namespace Console;

interface Command
{
    public function __invoke(\Console\Input $input, \Console\Output $output);
}
