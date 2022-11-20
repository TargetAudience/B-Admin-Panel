<?php
class App_Controller extends TinyMVC_Controller
{
    function __construct() {
        parent::__construct();
    }

    public function checkSession($pageType = 'default')
    {
        // 24 mins in seconds. 1440
        $inactive = 1440; 

        $session_life = time() - $_SESSION['timeout'];

        if(session_status() !== PHP_SESSION_ACTIVE || $session_life > $inactive) {
            // session_start();
            // Remove all session variables.
            session_unset();
            // Destroy the session.
            session_destroy();
            session_start();

            if ($pageType == 'default') {
    			header("Location: " . TMVC_URL);
    		} else {
    			$data = array("ok" => "true", "redirect" => TMVC_URL);
	            session_write_close();
	            header('Content-Type: application/json');
	            echo json_encode($data);
    		}
    		exit();
        } else {
            /*error_log(print_R($_SESSION,TRUE));
            error_log(print_R($session_life . ' = ' . $inactive,TRUE));
            error_log(print_R(session_status(),TRUE));
            error_log(print_R(session_id(),TRUE));*/
        }

        $_SESSION['timeout'] = time();
    }
}
?>