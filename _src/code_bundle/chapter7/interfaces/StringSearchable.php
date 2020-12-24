<?php

interface StringSearchable
{
    // define mathod signature with args like needle, haystack
    public function search($substring, $buffer);
}

?>