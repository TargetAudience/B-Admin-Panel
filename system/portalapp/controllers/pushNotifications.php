<?php
require_once(TMVC_BASEDIR . 'portalapp/libs/OneSignal.php');

class PushNotifications_Controller extends App_Controller
{
    // error_log(print_R($var,TRUE));

    public function send()
    {
        $this->checkSession();

        $successMessage = '';
        if (isset($_GET['mes'])) {
            $messageCode = $_GET['mes'];
            if ($messageCode == 's') {
                $successMessage = 'Your notification(s) have been sent.';
            }
        }

        $this->load->model('Push_Model', 'notifications');

        $id = $_GET['id'];
        $pushNotificationId = Crypt::enc_decrypt($id);

        $pushCount = $this->notifications->getPushUsersCount();

        $this->smarty->assign('pushCount', $pushCount['count']);
        $this->smarty->assign('notificationsIdEncoded', $id);

        $this->smarty->assign('successMessage', $successMessage);
        $this->smarty->assign('currentPage', 'pushNotifications');
        $this->smarty->assign('subPage', 'pushNotificationsSend');
        $this->smarty->assign('pageTitle', 'Send Push Notificatiosn');
        $this->smarty->assign('subPageJS', 'userNewAdd');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/push-notifications-send.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    function logs()
    {
        $this->checkSession();

        $this->load->model('Push_Model', 'notifications');

        $logData = $this->notifications->getLogs();

        foreach ($logData as &$data) {
            $data['updatedOn'] = date('M j, Y', strtotime($data['updatedOn']));
            $data['createdOn'] = date('M j, Y', strtotime($data['createdOn']));
            $encode = Crypt::enc_encrypt($data['pushNotificationId']);
            $data['pushNotificationIdEncoded'] = $encode;
        }

        $this->smarty->assign('logData', $logData);

        $this->smarty->assign('currentPage', 'pushNotifications');
        $this->smarty->assign('subPage', 'logs');
        $this->smarty->assign('pageTitle', 'Push Notifications Logs');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/push-notifications-logs.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    function index()
    {
        $this->checkSession();

        $this->load->model('Push_Model', 'notifications');

        $notificationsData = $this->notifications->getPushNotifications();

        foreach ($notificationsData as &$data) {
            $data['updatedOn'] = date('M j, Y', strtotime($data['updatedOn']));
            $data['createdOn'] = date('M j, Y', strtotime($data['createdOn']));
            $encode = Crypt::enc_encrypt($data['pushNotificationId']);
            $data['pushNotificationIdEncoded'] = $encode;
        }

        $this->smarty->assign('notificationsData', $notificationsData);

        $this->smarty->assign('currentPage', 'pushNotifications');
        $this->smarty->assign('subPage', '');
        $this->smarty->assign('pageTitle', 'Push Notifications');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/push-notifications.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    function notificationView()
    {
        $this->load->model('Push_Model', 'notifications');

        $id = $_GET['id'];
        $pushNotificationId = Crypt::enc_decrypt($id);

        $notificationData = $this->notifications->getNotificationDetails($pushNotificationId);

        $notificationData['createdOn'] = date('M j, Y', strtotime($notificationData['createdOn']));

        if ($notificationData['updatedOn']) {
            $updateOn = date('M j, Y', strtotime($notificationData['updatedOn']));
            $notificationData['lastUpdate'] = $updateOn . ' by ' . $notificationData['firstName'] . ' ' . $notificationData['lastName'];
        } else {
            $notificationData['lastUpdate'] = '-';
        }

        if (empty($notificationData['messageTitle'])) {
            $notificationData['messageTitle'] = '-';
        }

        $this->smarty->assign('notificationData', $notificationData);
        $this->smarty->assign('pushNotificationIdEncoded', $id);

        $this->smarty->assign('currentPage', 'pushNotifications');
        $this->smarty->assign('subPage', 'details');
        $this->smarty->assign('pageTitle', 'Push Notification View');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/push-notification-view.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function add()
    {
        $this->checkSession();

        $this->smarty->assign('formType', 'add');
        $this->smarty->assign('notificationsId', '');

        $this->smarty->assign('currentPage', 'pushNotifications');
        $this->smarty->assign('subPage', 'pushNotificationAdd');
        $this->smarty->assign('pageTitle', 'Add Push Notification');
        $this->smarty->assign('subPageJS', 'userNewAdd');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/push-notifications-add-edit.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
    }

    public function edit()
    {
        $this->checkSession();

        $this->load->model('Push_Model', 'notifications');

        $id = $_GET['id'];
        $pushNotificationId = Crypt::enc_decrypt($id);

        $notificationData = $this->notifications->getNotificationDetails($pushNotificationId);

        $this->smarty->assign('notificationData', $notificationData);
        $this->smarty->assign('formType', 'edit');
        $this->smarty->assign('notificationsIdEncoded', $id);

        $this->smarty->assign('currentPage', 'pushNotifications');
        $this->smarty->assign('subPage', 'pushNotificationEdut');
        $this->smarty->assign('pageTitle', 'Edit Push Notification');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/push-notifications-add-edit.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
    }

    public function addEditUser()
    {
        $this->checkSession('json');

        $this->load->model('Push_Model', 'notifications');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        // Define the rules and filters
        $filters = array(
            'internalName' => 'trim|sanitize_string',
            'messageTitle' => 'trim|sanitize_string',
            'messageBody'  => 'trim|sanitize_string',
        );
        $rules = array(
            'internalName' => 'required',
            'messageBody'  => 'required',
        );


        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);
        
        $errorArr = array();

        if ($validated !== true) {
            foreach ($validated as $v) {
                switch ($v['field']) {
                    case 'internalName':
                        $errorArr[] = "Please enter an internal name.";
                        break;
                    case 'messageBody':
                        $errorArr[] = "Please enter a message body.";
                        break;
                }
            }
        }

        if (count($errorArr) == 0):
            $internalName = $_POST['internalName'];
            $messageTitle = $_POST['messageTitle'];
            $messageBody = $_POST['messageBody'];
            $formType = $_POST['formType'];
            $updateBy = $_SESSION['userId'];

            if ($formType == 'add') {
                $insertId = $this->notifications->addNotification($internalName, $messageTitle, $messageBody, $updateBy);
                $redirect = 'notificationView?id=' . Crypt::enc_encrypt($insertId) . '&mes=ts';
            } else {
                $id = $_POST['notificationsIdEncoded'];
                $notificationsId = Crypt::enc_decrypt($id);
                $this->notifications->editNotification($notificationsId, $internalName, $messageTitle, $messageBody, $updateBy);
                $redirect = 'notificationView?id=' . $_POST['notificationsIdEncoded'] . '&mes=s';
            }

            $data = array("ok" => "true", "redirect" => $redirect);

            session_write_close();
            header('Content-Type: application/json');
            echo json_encode($data);
            exit();
        else:
            $data = array("ok" => "false", "title" => "Oops!", "content" => json_encode($errorArr));

            session_write_close();
            header('Content-Type: application/json');
            echo json_encode($data);
            exit();
        endif;
    }

    public function sendNotification()
    {
        if (!array_key_exists(7, $_SESSION['role'])) {
            exit();
        }

        $this->checkSession('json');

        $id = $_POST['notificationsIdEncoded'];
        $pushNotificationId = Crypt::enc_decrypt($id);

        $selectPushType = $_POST['selectPushType'];
        $selectedUserId = $_POST['selectedUserId'];

        error_log(print_R($_POST,TRUE));
        error_log(print_R($pushNotificationId,TRUE));

        $this->load->model('Push_Model', 'notifications');

        $errorArr = array();

        if ($selectPushType == '') {
            $errorArr[] = "Please select a segment to send to.";
         }

        if ($selectPushType == 'singleUser' && $selectedUserId == '') {
           $errorArr[] = "Please enter a single user.";
        }

        if (count($errorArr) == 0):
            $updateBy = $_SESSION['userId'];

            $getMessage = $this->notifications->getMessage($pushNotificationId);
            $messageTitle = $getMessage['messageTitle'];
            $messageBody = $getMessage['messageBody'];

            if ($selectPushType == 'singleUser') {
                $singleUser = $this->notifications->getUser($selectedUserId);
                error_log(print_R($singleUser,TRUE));

                $playerIdsArr = array();
                $playerIdsArr[] = $singleUser['playerId'];
                $this->sendActualPushNotification($messageTitle, $messageBody, $playerIdsArr);
            } else {

            }

            error_log(print_R($messageTitle,TRUE));
            error_log(print_R($messageBody,TRUE));

            //$notificationMessageId = $this->notifications->addNotificationMessage($body, $updateBy);

            /*$getUsers = $this->notifications->getUsers();

            $playerIdsArr = array();
            foreach ($getUsers as &$item) {
                if ($item['pushNotifications'] == 1 || $item['smsNotifications'] == 1) {
                    if ($item['pushNotifications'] == 1 && $item['playerId'] != '') {
                        $sentPush = 1;
                    } else {
                        $sentPush = 0;
                    }

                    $this->notifications->addUserNotification($item['userId'], $notificationMessageId, $sentPush, 0);
                }
                if ($item['pushNotifications'] == 1 && $item['playerId'] != '') {
                    $playerIdsArr[] = $item['playerId'];
                }
            }

            //$this->sendActualPushNotification($title, $body, $playerIdsArr);

           */

            $redirect = 'send?id=' . $id . '&mes=s';

            $data = array("ok" => "true", "redirect" => $redirect);

            session_write_close();
            header('Content-Type: application/json');
            echo json_encode($data);
            exit(); 
        else:
            $data = array("ok" => "false", "title" => "Oops!", "content" => json_encode($errorArr));

            session_write_close();
            header('Content-Type: application/json');
            echo json_encode($data);
            exit();
        endif;
    }

    function sendActualPushNotification($title, $body, $playerIds)
    {
        $config = ['appId' => ONESIGNAL_APP_ID, 'restApiKey' => ONESIGNAL_REST_API_KEY, 'authToken' => ONESIGNAL_AUTH_KEY];

        $oneSignal = new OneSignal($config);

        $headings = array(
             "en" => $title
        );

        $content = array(
             "en" => $body
        );

        $parameters = [
            'include_player_ids' => $playerIds,
            'content_available' => true,
            'contents' => $content, 
            'headings' => $headings
        ];

        error_log(print_R('sendActualPushNotification:',TRUE));
        error_log(print_R($parameters,TRUE));

        $result = $oneSignal->sendSilent($parameters);

        error_log(print_R('result:',TRUE));
        error_log(print_R($result,TRUE));
    }

    public function getPagination($per_page, $page_number, $total_count)
    {
        $page_number = (isset($page_number)) ? $page_number : 1;
        $total_pages = ceil($total_count / $per_page);
        $curr_offset = ($page_number - 1) * $per_page;
        $limit_offset = array(
            'limit' => $per_page, 'offset' => $curr_offset, 'page_number' => $page_number, 'total_pages' => $total_pages
        );
        return $limit_offset;
    }
}
