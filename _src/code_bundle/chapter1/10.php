<?php

// get all constants organized by category
$allTokens = get_defined_constants(true);

// we're only interested in tokenizer constants
print_r($allTokens["tokenizer"]);

?>