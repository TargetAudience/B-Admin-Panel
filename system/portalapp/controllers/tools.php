<?php
require_once(TMVC_BASEDIR . 'portalapp/libs/CURL.php');
require_once(TMVC_BASEDIR . 'portalapp/libs/OneSignal.php');

class Tools_Controller extends App_Controller
{
    // error_log(print_R($var,TRUE));

    function index2()
    {
        $this->load->model('User_Model', 'user');

        $config = ['appId' => ONESIGNAL_APP_ID, 'restApiKey' => ONESIGNAL_REST_API_KEY, 'authToken' => ONESIGNAL_AUTHTOKEN];

        $oneSignal = new OneSignal($config);

        $headings = array(
             "en" => "Your opinion matters!"
        );

        $content = array(
             "en" => "Please answer 3 questions to tell us what you think. We value your feedback!"
        );

        $parameters = [
            'include_player_ids' => ['e39b8a97-11ce-44b1-bbf1-e163243f45fa'],
            'content_available' => true,
            'contents' => $content, 
            'headings' => $headings
        ];

        // 'url' => "https://survey.zohopublic.com/zs/ZDBU36"

        $result = $oneSignal->sendSilent($parameters);

        echo  "<pre>";
        print_r(json_decode($result, true));
    }

    function viewNotifications()
    {
        $config = ['appId' => ONESIGNAL_APP_ID, 'restApiKey' => ONESIGNAL_REST_API_KEY, 'authToken' => ONESIGNAL_AUTHTOKEN];

        $oneSignal = new OneSignal($config);
        echo  "<pre>";
        print_r(json_decode($oneSignal->viewNotifications(0, 1), true));
    }
}