<?php

    // ...
    public function doSomething($arg1, $arg2, $arg3)
    {
        if ($arg1 == $arg2 == $arg3) {

            // notice blank line above
            $this->identical = true;
            echo "All three arguments are identical.\n";

        } else {

            echo "At least one argument is different.\n";
        }
    }
    // ...

?>