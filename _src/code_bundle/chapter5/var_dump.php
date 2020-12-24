<?php

class VDump
{
    // private, protected, and public properties
    private $path = '/this/way';
    protected $extensions = array('csv', 'txt');
    public $file  = null;
    
    // constructor
    public function __construct($file)
    {
        $this->$file;
    }
    
    // private method
    private function getPath()
    {
        return $this->path;
    }
    
    // protected method
    protected function getFile()
    {
        return $this->file;
    }
    
    // public method
    public function getPathAndFile()
    {
        return $this->getPath() . '/' . $this->getFile();
    }
}

// instantiate sample object
$vdump = new VDump('data.csv');
function abc() {
    echo 'FILE: ' . __FILE__ . ', LINE: ' . __LINE__ . ', FUNCTION: ' . __FUNCTION__ . ', CLASS: ' . __CLASS__ . ', METHOD: ' . __METHOD__ . "\n";
    
}
//abc();
echo print_r(get_object_vars($vdump));
// var_dump example ...
//var_dump($vdump);

// print_r example ...
// ... same as:
// echo print_r($vdump, true);
//print_r($vdump);

?>