<?php
//
/* 2010 - Modified by PhreeSoft for XML interface capability */
/** 
 * boolean used to see if we are in the admin script, obviously set to false here.
 * DO NOT REMOVE THE define BELOW. WILL BREAK ADMIN
 */
define('IS_ADMIN_FLAG', true);
/** 
 * integer saves the time at which the script started.
 */
// Start the clock for the page parse time log
define('PAGE_PARSE_START_TIME', microtime());
/**
 * set the level of error reporting
 */
error_reporting(E_ALL & ~E_NOTICE);
set_error_handler("PhreebooksErrorHandler");
function PhreebooksErrorHandler($errno, $errstr, $errfile, $errline){
    if (!(error_reporting() & $errno)) return; // This error code is not included in error_reporting
    switch ($errno) {
    	case E_ERROR:
    	case E_CORE_ERROR:
    	case E_COMPILE_ERROR:
    	case E_USER_ERROR:
    		echo '<?xml version="1.0" encoding="UTF-8" ?>' . chr(10);
			echo "<Response>" . chr(10);
			echo "\t<Version>1.00</Version>". chr(10);
			echo "\t<Result>$errno</Result>". chr(10);
			echo "\t<Text>$errstr</Text>". chr(10);
			echo "</Response>" . chr(10);
        	break;
    }
    /* Don't execute PHP internal error handler */
    return true;
}


// set php_self in the local scope
if (!isset($PHP_SELF)) $PHP_SELF = $_SERVER['PHP_SELF'];

// load the main configure file.
require('../includes/configure.php');
if ($za_dir = @dir(DIR_WS_INCLUDES . 'extra_configures')) {
  while ($zv_file = $za_dir->read()) {
    if (preg_match('/\.php$/', $zv_file) > 0) {
      // load any user/contribution specific configuration files.
      include(DIR_WS_INCLUDES . 'extra_configures/' . $zv_file);
    }
  }
}
// load special functions that fail during the autoload above
require(DIR_FS_ADMIN . 'includes/functions/general.php');
require(DIR_FS_ADMIN . 'includes/functions/database.php');
require(DIR_FS_ADMIN . 'includes/functions/password_funcs.php');

$autoLoadConfig = array();
include('config.core.php');
require(DIR_FS_CATALOG . 'includes/autoload_func.php');
?>