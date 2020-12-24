<?php

class ClassNameConverter
{
    public static $classRootDir = array('var', 'www', 'sites', 'my_app', 'includes', 'classes');

    public static function makeClassName($absolutePath)
    {
        $platformClassRootDir = DIRECTORY_SEPARATOR .
                                implode(DIRECTORY_SEPARATOR, self::$classRootDir) .
                                DIRECTORY_SEPARATOR;

        // remove path leading to class root directory
        $absolutePath = str_replace($platformClassRootDir, '', $absolutePath);

        // replace directory separators with underscores
        // and capitalize each word/directory
        $parts = explode(DIRECTORY_SEPARATOR, $absolutePath);
        
        foreach ($parts as $index => $value) {
            $parts[$index] = ucfirst(strtolower($value));
        }

        // join with underscores
        $absolutePath = implode('_', $parts);

        // remove trailing file extension
        $absolutePath = str_replace('.php', '', $absolutePath);

        return $absolutePath;
    }
}

$classNameExamples = array('/var/www/sites/my_app/includes/classes/logging/db/Mysql.php',
                            '/var/www/sites/my_app/includes/classes/logging/db/MysqlPatched.php',
                            '/var/www/sites/my_app/includes/classes/caching_lib/Memcached.php'
                            );

foreach ($classNameExamples as $path) {
    echo $path . ' converts to ' . ClassNameConverter::makeClassName($path) . "\n";
}

?>