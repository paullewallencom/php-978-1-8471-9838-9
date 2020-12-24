<?php

interface Interrogator
{
    public function probe($host, $port);
    public function maxProbesExceeded($host, $port);
}

?>