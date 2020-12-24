<?php
// logging & error settings for development
if (ENVIRONMENT == 'Development') {
    
    // level of log detail
    ini_set('error_reporting', 'E_ALL | E_STRICT');

    // display errors in browser
    ini_set('display_errors', 'On');

    // display startup errors as well
    ini_set('display_startup_errors', 'On');

    // write errors to log file
    ini_set('log_errors', 'On');

    // no size limit for error messages
    ini_set('log_errors_max_len', 0);

    // show multiple occurrence of error
    ini_set('ignore_repeated_errors', 'Off');

    // show same errors from different sources
    ini_set('ignore_repeated_source', 'Off');

    // can't display memory leaks with debug compile
    ini_set('report_memleaks', 'Off');

    // store last error in $php_errormsg
    ini_set('track_errors', 'On');

    // format errors in HTML
    ini_set('html_errors', 'On');

    // base URL of PHP manual
    ini_set('docref_root', 'http://www.php.net/manual/en/');

    // manual page file extension
    ini_set('docref_ext', '.php');

    // don't precede error with string
    ini_set('error_prepend_string', '');

    // don't prepend to error
    ini_set('error_append_string', '');

    // log file location
    ini_set('error_log', '/var/log/php_errors.txt');

// default logging & error settings
} else {
    // level of log detail
    ini_set('error_reporting', 'E_ERROR');

    // hide errors from browser
    ini_set('display_errors', 'Off');

    // hide startup errors
    ini_set('display_startup_errors', 'Off');

    // write errors to log file
    ini_set('log_errors', 'On');

    // no size limit for error messages
    ini_set('log_errors_max_len', 0);

    // show multiple occurrence of error
    ini_set('ignore_repeated_errors', 'Off');

    // show same errors from different sources
    ini_set('ignore_repeated_source', 'Off');

    // can't display memory leaks with debug compile
    ini_set('report_memleaks', 'Off');

    // store last error in $php_errormsg
    ini_set('track_errors', 'On');

    // format errors in plain text
    ini_set('html_errors', 'Off');

    // base URL of PHP manual not needed
    ini_set('docref_root', '');

    // manual page file extension not needed
    ini_set('docref_ext', '.php');

    // don't precede error with string
    ini_set('error_prepend_string', '');

    // don't prepend to error
    ini_set('error_append_string', '');

    // log file location
    ini_set('error_log', '/var/log/php_errors.txt');
}
?>