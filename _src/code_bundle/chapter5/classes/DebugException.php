<?php

class DebugException extends Exception
{
    const PLAIN = 0;
    const HTML  = 1;

    public static $sourceCodeSpan  = 10;
    public static $outputFormat    = self::HTML;
    public static $errorScope      = E_ERROR;

    protected $addedDebug    = array();

    public function __construct($message, $code = 0)
    {
        // make sure everything is assigned properly
        parent::__construct($message, $code);

        // additional debug info?
        if (func_num_args() > 2) {
            $this->addedDebug = array_slice(func_get_args(), 2);
        }
    }

    public function __destruct()
    {
        // intentionally left blank
    }

    // to be called statically once to handle all exceptions & errors
    public static function init()
    {
        // handle all exceptions with this class
        set_exception_handler(array('DebugException', 'exceptionHandler'));
        
        // handle all errors with this class
        set_error_handler(array('DebugException', 'errorHandler'), self::$errorScope);
        
        // auto-detect / guess the output format
        if (php_sapi_name() == 'cli') {

            // plain text for CLI use
            self::$outputFormat = self::PLAIN;

        } else {

            // HTML output otherwise
            self::$outputFormat = self::HTML;
        }
    }

    // unregister error and exception handlers
    public static function unInit()
    {
        // pop exception handler stack 
        restore_exception_handler();

        // pop error handler stack
        restore_error_handler();
    }

    // turn errors into DebugExceptions
    public static function errorHandler($number,
                                        $message,
                                        $file,
                                        $line,
                                        $context)
    {
        // convert error to excepton and throw it
        $debugException = new DebugException($number, 0, $context);

        // transfer info to DebugException
        $debugException->file = $file;
        $debugException->line = $line;
        
        // throw the new DebugException
        throw $debugException;
     }

    // catching regular exceptions
    public static function exceptionHandler($exception)
    {
        // explicitly call this class's __toString()
        self::output($exception);
    }
    
    // collects & outputs the debug info
    public static function output(Exception $exception)
    {
        $output = array();

        // output file name and line number
        $output[] = array('Summary:', 'An exception occurred in file ' . basename($exception->getFile())
                    . ' on line ' . $exception->getLine() . '.');
                    
        // output message
        $output[] = array('Error message: ', $exception->getMessage());
        
        // get source code of file that threw exception
        $sourceExcerpt = self::getSourceExcerpt($exception->getFile(), $exception->getLine());
        
        $output[] = 'Source code excerpt of lines ' . $sourceExcerpt['start']
                    . ' through ' . $sourceExcerpt['end'] . ' of file ' . $exception->getFile() . ':';

        // highlight syntax for HTML output
        if (self::$outputFormat == self::HTML) {
            $output[] = array('', highlight_string(implode('', $sourceExcerpt['source']), TRUE));
        } elseif (self::$outputFormat == self::PLAIN) {
            $output[] = implode('', $sourceExcerpt['source']);
        }
        
        // get backtrace nicely formatted
        $formattedTraces = self::getFormattedTrace($exception);
        
        // get additionally debug info nicely formatted
        $output = array_merge($output, self::getFormattedDebugInfo($exception));

        // format output depending on how $outputFormat is set
        // output HTML first
        if (self::$outputFormat == self::HTML) {

            // have a show/hide link for each trace
            for ($i = 0; $i < sizeof($formattedTraces); $i++) {
                $output[] = '<a href="" onclick="var bt = document.getElementById(\'backtrace' . ($i + 1) . '\');if (bt.style.display == \'\') bt.style.display = \'none\';else bt.style.display = \'\';return false;">Backtrace step ' . ($i + 1) . ' (click to toggle):</a>';
                $output[] = self::arrayToTable($formattedTraces[$i], 'backtrace' . ($i + 1));
            }

            echo self::arrayToTable($output, null, 'Debug Output', FALSE);

        // output plain text
        } elseif (self::$outputFormat == self::PLAIN) {
        
            // merge traces into output array
            $output = array_merge($output, $formattedTraces);

            // flatten the multi-dimensional array(s) for simple outputting
            $flattenedOutput = self::flattenArray($output);

            echo implode(PHP_EOL, $flattenedOutput);
        }
    }
    
    // extracts +/- $sourceCodeSpan lines from line $line of file $file
    public static function getSourceExcerpt($file, $line)
    {
        // get source code of file that threw exception
        $source = file($file);

        // limit source code listing to +/- $sourceCodeSpan lines
        $startLine = max(0, $line - self::$sourceCodeSpan - 1);
        $offset = min(2 * self::$sourceCodeSpan + 1, count($source) - $line + self::$sourceCodeSpan + 1);

        $sourceExcerpt = array_slice($source, $startLine, $offset);
        
        if ($startLine > 0) {
            array_unshift($sourceExcerpt, "<?php\n", "// ...\n");
        }

        // return source excerpt and start/end lines
        return array('source' => $sourceExcerpt,
                     'start'  => $startLine,
                     'end'    => $startLine + $offset);
    }

    // creates array containing formatted backtrace
    // uses syntax highlighting for source code if
    // $outputFormat is HTML
    public static function getFormattedTrace(Exception $exception)
    {
        // init output array of formatted traces
        $formattedTraces = array();

        // get traces from exception
        $traces = $exception->getTrace();
        
        // init counter
        $count = 1;

        // iterate over traces
        foreach ($traces as $aTrace) {

            // skip the method where we turned an error into an Exception
            if ($aTrace['function'] != 'errorHandler') {

                // init output for this trace
                $output = array();

                $output[] = "Backtrace step $count:";

                // output class if given
                if (array_key_exists('class', $aTrace)) {
                    $output[] = array('Class: ', $aTrace['class']);
                }

                // output type if given
                if (array_key_exists('type', $aTrace)) {
                    $output[] = array('Type: ', $aTrace['type']);
                }

                // output function if given
                if (array_key_exists('function', $aTrace)) {

                    $output[] = array('Function: ', $aTrace['function']);

                    // output argument to function
                    if (array_key_exists('args', $aTrace)) {
                        $output[] = array('', 'with argument(s): ' . implode(', ', $aTrace['args']));
                    }
                }

                // get source code of file that threw exception
                $sourceExcerpt = self::getSourceExcerpt($aTrace['file'], $aTrace['line']);

                $output[] = 'Source code excerpt of lines ' . $sourceExcerpt['start']
                            . ' through ' . $sourceExcerpt['end'] . ' of file ' . $aTrace['file'] . ':';
        
                // highlight syntax for HTML output
                if (self::$outputFormat == self::HTML) {
                    $output[] = array('', highlight_string(implode('', $sourceExcerpt['source']), TRUE));
                } elseif (self::$outputFormat == self::PLAIN) {
                    $output[] = implode('', $sourceExcerpt['source']);
                }

                $formattedTraces[] = $output;

                // increase step counter
                $count++;
            }
        }

        return $formattedTraces;
    }

    // formats the variables & objects passed to the constructor
    // and stored in $addedDebug. Uses syntax highlighting for
    // source code if $outputFormat is HTML
    public static function getFormattedDebugInfo(Exception $exception)
    {
        // init output array
        $output = array();

        // only the DebugException class has the addedDebug property
        if (get_class($exception) == __CLASS__) {
            
            if (count($exception->addedDebug) > 0) {
                $output[] = 'Additional debug info:';
            }
            
            // iterate over each variable
            foreach ($exception->addedDebug as $addBug) {
                foreach ($addBug as $debugLabel => $debugVar) {
                
                    // format with print_r
                    if (self::$outputFormat == self::HTML) {
                        $output[] = array($debugLabel, '<pre>' . print_r($debugVar, TRUE) . '</pre>');
                    } elseif (self::$outputFormat == self::PLAIN) {
                        $output[] = array($debugLabel, print_r($debugVar, TRUE));
                    }
                }
            }
        }
        
        return $output;
    }
    
    // converts an array of items to output to an HTML table
    // expects format:
    //         array('some text here',         <- single cell on row 1
    //               array('label', $value),   <- two cells on row 2
    //                                             (label and value)
    //               ...);
    public static function arrayToTable(array $contents = array(),
                                        $id = null,
                                        $caption = null,
                                        $hideByDefault = TRUE)
    {
        $html = '';

        // open table tag
        if (count($contents) > 0) {
            $html .= '<table style="width: 100%;border: 2px solid #666;display: ';
            $html .= ($hideByDefault) ? 'none' : '';
            $html .= ';"';
            $html .= ($id != null) ? " id=\"$id\"" : '';
            $html .= ">\n";
        }

        // add caption
        if (!empty($caption) > 0) {
            $html .= '<caption><h2>' . htmlentities($caption) . "</h2></caption>\n";
        }

        $rowCount = 1;
        $rowColors = array('#fff', '#ccc');
        
        // iterate over input array
        foreach ($contents as $row) {
            $html .= "<tr style=\"background: " . $rowColors[($rowCount % 2)] . ";\">\n";
            
            // split arrays into label and field
            if (is_array($row) && count($row) >= 2) {
                $html .= '<td><strong>' . htmlentities($row[0]) . "</strong></td>\n"
                        . '<td>' . $row[1] . "</td>\n";
                        
            // output single strings on a row by themselves
            } else {
                $html .= '<th colspan="2" style="text-align: left;">' . $row . "</th>\n";
            }
            
            $html .= "</tr>\n";
            
            $rowCount++;
        }

        // close table tag
        if (count($contents) > 0) {
            $html .= "</table>\n";
        }
        
        return $html;
    }
    
    // takes a multi-dimensional array and flattens it for plain text output
    public static function flattenArray(array $inputArray = array())
    {
       $outputArray = array();
       
       // iterate over input array items
       foreach ($inputArray as $item) {
       
           if (is_array($item)) {
               // use recursion to traverse the hierarchy
               $outputArray = array_merge($outputArray, self::flattenArray($item));
           } else {
               array_push($outputArray, $item);
           }
       }
       
       return $outputArray;
    }
}

DebugException::init();

?>