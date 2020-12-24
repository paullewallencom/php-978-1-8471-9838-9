#!/usr/local/apache2/php/bin/php
<?php

require_once('../includes/classes/Cli/Options.php');

$options = Cli_Options::getInstance(array('i', 'v', 'h', 'p:'));
$options->processCommandLine();

// testing script name parsing
echo 'script name: ' . $options->getScriptName() . "\n";

// testing option value parsing
echo "p:" . $options->getOptionValue('p') . "\n";

// testing argument parsing
echo "first argument: " . $options->getArgument(0) . "\n";

?>