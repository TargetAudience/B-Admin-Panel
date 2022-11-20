<?php
error_reporting(E_ALL);
ini_set('display_errors', 'Off');
ini_set('error_log', 'logs/portalapp.log');

set_exception_handler(function($exception) {
   error_log($exception);
});

define('TITLE', 'Boom Health');

define('DB_HOST', 'localhost');
define('DB_NAME', 'boomhealth_admin');
define('DB_USER', 'boom');
define('DB_PASSWORD', "pP5Podr0f8sNUbl7");

define('ADMIN_USER', '');
define('SERVICE_URL', '');

if (!defined('TMVC_URL')) {
    define('TMVC_URL', 'http://boomhealth-admin2:8888/');
}

define('UPLOAD_FOLDER_MEDIA', 'http://boomhealth-api:8888/v1.0.1/uploads/');
define('UPLOAD_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/boomhealth-api/v1.0.1/uploads/');

if (!defined('portalapp_PROD')) {
    define('portalapp_PROD', 0);
}

if (!defined('portalapp_THEME')) {
	define('portalapp_THEME', 'portalapp');
}

define('TWILIO_ACCOUNT_SID', 'ACee3425bc2c796c8aa9ac7bbb090b0daa');
define('TWILIO_API_KEY', 'SK4e2ac56011d0d1459b82ba240322647c');
define('TWILIO_API_SECRET', 'O9Jp5PVlNY463yI9mFnx4UdouNAphfvz');
define('TWILIO_AUTH_TOKEN', 'edd6244ee0db1021bcdffd9b3d8f7233');

define('ONESIGNAL_APP_ID', 'ab0838b0-7822-4eb4-8b0c-ff8a0d8d3a37');
define('ONESIGNAL_REST_API_KEY', 'MGIxYzg0MjEtNGI4ZS00ZjIzLWIzOWItMDRmN2JkM2M0OGRl');
define('ONESIGNAL_AUTH_KEY', 'OTQzMzkwZmItMDgxNy00MDEwLWE1YmEtMjFiMTA5YThhYjA1');

define("EMAIL_SENDER_ADDRESS", '');
define("EMAIL_SENDER_NAME", '');
?>
