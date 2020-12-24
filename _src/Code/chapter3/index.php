<?php

require_once('includes/interfaces/Configurable.php');
require_once('includes/classes/Config/Xml.php');

$config = Config_Xml::getInstance('/Users/dirk/Documents/Work/WaferThin/Packt/Book/Code/chapter4/config/settings.xml');

echo 'Application name: ' . $config->getSetting('application', 'name') . "\n";

?>