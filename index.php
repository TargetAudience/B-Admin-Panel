<?php
/* PHP error reporting level, if different from default */
error_reporting(E_ALL);

/* starting sessions, for user login etc */
session_start();

/* define to 0 if you want errors/exceptions handled externally */
define('TMVC_ERROR_HANDLING',0);

/* directory separator alias */
if(!defined('DS'))
  define('DS',DIRECTORY_SEPARATOR);

/* set the base directory */
if(!defined('TMVC_BASEDIR'))
  define('TMVC_BASEDIR',__DIR__ . DS . 'system' . DS);

/* include Panty config */
require TMVC_BASEDIR . 'portalapp' . DS . 'configs' . DS . 'config.php';

/* set the assets directory */
if(!defined('TMVC_ASSDIR'))
  define('TMVC_ASSDIR',TMVC_URL . 'assets/');

require TMVC_BASEDIR . 'sysfiles' . DS . 'TinyMVC.php';

/* instantiate */
$tmvc = new tmvc();

/* tally-ho! */
$tmvc->main();
