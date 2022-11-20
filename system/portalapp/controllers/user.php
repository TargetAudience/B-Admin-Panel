<?php
require_once(TMVC_BASEDIR . 'portalapp/libs/Mail.php');

class User_Controller extends TinyMVC_Controller
{
    // error_log(print_R($var,TRUE));
    // {$session.var|@debug_print_var}

    function index()
    {
        $this->refreshSessionStart();

        $this->load->model('User_Model', 'user');

        $cookieEmail = '';
        if (!empty($_COOKIE['cookieEmail'])) {
            $cookieEmail = $_COOKIE['cookieEmail'];
        }

        $successMessage = '';
        if (isset($_GET['mes'])) {
            $messageCode = $_GET['mes'];
            if ($messageCode == 'ts') {
                $successMessage = 'The user has been added.';
            } elseif ($messageCode == 'u') {
                $successMessage = 'The user has been updated.';
            }
        }

        $this->smarty->assign('cookieEmail', $cookieEmail);
        $this->smarty->assign('successMessage', $successMessage);
        $this->smarty->assign('currentPage', 'preLogin');
        $this->smarty->assign('subPage', 'login');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/login.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer.tpl');
    }

    function userLogin()
    {
        ini_set("display_errors", 1);
        error_reporting(1);

        $this->load->model('User_Model', 'user');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        // Define the rules and filters
        $filters = array(
            'emailAddress'     => 'trim|sanitize_email',
            'password'         => 'trim|sanitize_string'
        );
        $rules = array(
            'emailAddress'      => 'required|valid_email',
            'password'          => 'required'
        );

        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);

        $errorArr = array();

        $emailAddress = trim(htmlentities($_POST['emailAddress']));
        $password = trim($_POST['password']);

        if ($validated === TRUE) {
            $user = $this->user->get_user_login($emailAddress);

            if (!password_verify($password, $user[0]['passwordHash'])) {
                $errorArr[] = "We couldn't find your e-mail address or your password was incorrect. Please try again.";
            }
        } else {
            foreach ($validated as $v) {
                switch ($v['field']) {
                    case 'emailAddress':
                        $errorArr[] = "Please enter a valid e-mail address.";
                        break;
                    case 'password':
                        $errorArr[] = "Please enter a password.";
                        break;
                }
            }
        }

        if (count($errorArr) == 0):
            $user = $this->user->get_user_email($emailAddress);

            $_SESSION['logged'] = TRUE;
            $_SESSION['timeout'] = time();
            $_SESSION['userId'] = $user['userId'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['lastName'] = $user['lastName'];
            $_SESSION['emailAddress'] = $user['emailAddress'];
            $_SESSION['firstInitial'] = $user['firstName'][0];
            $_SESSION['lastInitial'] = $user['lastName'][0];
            $_SESSION['adminRoles'] = $this->administration->get_admin_roles();

            // To validate in menu-side bar, we will validate role only if it contains in adminRoles
            $_SESSION['adminRoleIds'] = array_flip(array_column($_SESSION['adminRoles'], 'id'));
            // In format of [roleId => index]; we only care about roleId to access it in O(1)
            $_SESSION['role'] = array_flip(array_column($this->administration->get_admin_user_roles($_SESSION['userId']), 'roleId'));
            
            if (array_key_exists(1, $_SESSION['role'])) {
                $redirect = 'users';
            } else if (array_key_exists(2, $_SESSION['role'])) {
                $redirect = 'meals';
            } else if (array_key_exists(3, $_SESSION['role'])) {
                $redirect = 'equipment';
            } else if (array_key_exists(4, $_SESSION['role'])) {
                $redirect = 'purchases';
            } else if (array_key_exists(5, $_SESSION['role'])) {
                $redirect = 'promoCodes';
            } else if (array_key_exists(6, $_SESSION['role'])) {
                $redirect = 'pushNotifications';
            } else if (array_key_exists(7, $_SESSION['role'])) {
                $redirect = 'adminUsers';
            }
            

            $this->user->update_login_data($user['userId']);

            $cookieEmail = '';
            if (isset($_POST['rememberMe'])):
                $cookieEmail = $emailAddress;
            endif;

            $data = array("ok" => "true", "redirect" => TMVC_URL . $redirect . '/', "cookieEmail" => $cookieEmail);

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

    function refreshSessionStart()
    {
        if (session_id() == '') {
            session_start();
            // Remove all session variables
            session_unset();
            // Destroy the session
            session_destroy();
            session_start();
        }
    }

    function password()
    {
        $this->refreshSessionStart();
        $this->smarty->assign('currentPage', 'password');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/password.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer.tpl');
    }

    function emailSent()
    {
        $this->refreshSessionStart();
        $this->smarty->assign('currentPage', 'password');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/password-sent.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer.tpl');
    }

    function resetPassword()
    {
        $this->refreshSessionStart();
        $this->smarty->assign('currentPage', 'password');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->assign('token', $_GET['token']);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->load->model('User_Model', 'users');
        $this->users->get_user_token($_GET['token']) === false
            ? $this->smarty->display(portalapp_THEME . '/password-invalid-link.tpl')
            : $this->smarty->display(portalapp_THEME . '/reset-password.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer.tpl');
    }

    function passwordReset()
    {

        $this->refreshSessionStart();

        $token = $_POST['token'];
        
        $this->load->model('Users_Model', 'users');
        
        $user = $this->users->get_user_token($token);

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        $filters = array(
            'newPassword'     => 'trim',
            'confirmPassword' => 'trim'
        );
        $rules = array(
            'newPassword'     => 'required',
            'confirmPassword' => 'required'
        );

        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);

        $errorArr = array();

        if (count($user) == 0) {
            $errorArr[] = "We couldn't find your e-mail address in our system.";
        }

        if($validated !== TRUE) {
            foreach($validated as $v) {
                switch($v['field']) {
                    case 'newPassword':
                        $errorArr[] = "Please enter a new password.";
                        break;
                    case 'confirmPassword':
                        $errorArr[] = "Please confirm your new password.";
                        break;
                }
            }
        }

        $newPassword = trim($_POST['newPassword']);
        $confirmPassword = trim($_POST['confirmPassword']);

        if (count($errorArr) == 0) {
            if ($newPassword != $confirmPassword) {
                $errorArr[] = "Please be sure your new password and your confirm password match.";
            }
            if (strlen($newPassword) < 8) {
                $errorArr[] = "Please be sure your new password is at least 8 characters.";
            }
        }

        if (count($errorArr) == 0): 
            $hash = password_hash($newPassword, PASSWORD_BCRYPT);

            $this->users->update_admin_password($user['userId'], $hash);

            $redirect = "/?mes=u";
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

    function sendResetPasswordEmail()
    {
        $this->refreshSessionStart();
        $this->load->model('User_Model', 'user');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        // Define the rules and filters
        $filters = array(
            'emailAddress' => 'trim|sanitize_email'
        );
        $rules = array(
            'emailAddress' => 'required|valid_email'
        );

        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);

        $errorArr = array();
        $successMessage = '';

        if ($validated !== TRUE) {
            foreach ($validated as $v) {
                switch ($v['field']) {
                    case 'emailAddress':
                        $errorArr[] = "Please enter a valid e-mail address.";
                        break;
                }
            }
        } else {
            $emailAddress = trim(htmlentities($_POST['emailAddress']));
            $user = $this->user->get_users_email($emailAddress);
            if (count($user) == 0) {
                $errorArr[] = "We couldn't find your e-mail address in our system.";
            }
        }
        if (count($errorArr) == 0) {
            $user = $user[0];
            $this->user->sendForgotPasswordLink($user['userId'], $emailAddress);

            $redirect = "emailSent";
            $data = array("ok" => "true", "redirect" => $redirect);
            session_write_close();
            header('Content-Type: application/json');
            echo json_encode($data);
            exit();
        }
        else {
            $data = array("ok" => "false", "title" => "Oops!", "content" => json_encode($errorArr));

            session_write_close();
            header('Content-Type: application/json');
            echo json_encode($data);
            exit();
        }
    }

    function passwordQuestion()
    {
        $this->smarty->assign('securityQuestion', $_SESSION['securityQuestion']);
        $this->smarty->assign('currentPage', 'passwordQuestion');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/password2.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer.tpl');
    }

    function passwordQuestion2()
    {
        $this->load->model('User_Model', 'user');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        // Define the rules and filters
        $filters = array(
            'answer' => 'trim'
        );
        $rules = array(
            'answer' => 'required'
        );

        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);

        $errorArr = array();

        if ($validated !== TRUE) {
            foreach ($validated as $v) {
                switch ($v['field']) {
                    case 'answer':
                        $errorArr[] = "Please enter your security answer.";
                        break;
                }
            }
        }

        if (count($errorArr) == 0) {
            $security_answer = trim(htmlentities($_POST['answer']));
            
            $match = $this->user->get_security_answer_match($_SESSION['securityEmailAddress'], $security_answer);

            if (count($match) == 1) {
                $this->sendResetPasswordEmail($_SESSION['securityEmailAddress']);

                $successMessage = "An e-mail has been sent to you with instructions to reset your password.";
            } else {
                $errorArr[] = "Your answer didn't match the answer we have stored. Please try again.";
            }
        }

        if (count($errorArr) == 1) {
            $data = array("ok" => "false", "title" => "Oops!", "content" => json_encode($errorArr));
        } else {
            $data = array("ok" => "true", "content" => $successMessage);
        }

        session_write_close();
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    function resetMyPassword()
    {
        $this->load->model('User_Model', 'user');

        $validLink = TRUE;

        if(isset($_GET['key'])) {
            $urlKey = trim(htmlentities($_GET['key']));

            $tempUser = $this->user->get_temp_userB($urlKey);
            if (!$tempUser) {
                $validLink = FALSE;
                $invalidTitle = 'Oh No! We couldn\'t find this information for you.';
                $invalidMessage = 'Your link information wasn\'t found or your link has been used already.';
            }
            else
            {
                // 48 hours, in seconds
                $timeout = 86400 * 2;
                if ((time() - $tempUser[0]['timeStamp']) > $timeout) {
                    $validLink = FALSE;
                    $invalidTitle = 'Oh No! The link has expired.';
                    $invalidMessage = 'The link you are using is over 48 hours old and has expired. Please try again.';
                }
            }
        }

        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        if ($validLink == TRUE)
        {
            $this->smarty->assign('urlKey', $urlKey);
            $this->smarty->display(portalapp_THEME . '/completeResetPassword.tpl');
        }
        else
        {
            $this->smarty->assign('invalidTitle', $invalidTitle);
            $this->smarty->assign('invalidMessage', $invalidMessage);
            $this->smarty->display(portalapp_THEME . '/completeResetPasswordInvalid.tpl');
        }
        $this->smarty->display(portalapp_THEME . '/page_footer.tpl');
    }

    function resetMyPassword2qwefqwefwqef()
    {
        $this->refreshSessionStart();
        $this->load->model('User_Model', 'user');
        $this->load->model('Administration_Model', 'administration');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        // Define the rules and filters
        $filters = array(
            'password'        => 'trim|sanitize_string',
            'confirmPassword' => 'trim|sanitize_string'
        );
        $rules = array(
            'password'        => 'required',
            'confirmPassword' => 'required'
        );

        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);

        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirmPassword']);
        $urlKey = trim($_POST['urlKey']);

        $errorArr = array();

        if ($validated !== TRUE) {
            foreach ($validated as $v) {
                switch ($v['field']) {
                    case 'password':
                        $errorArr[] = "Please enter a password.";
                        break;
                    case 'confirmPassword':
                        $errorArr[] = "Please enter a confirmation password.";
                        break;
                }
            }
        }

        if (count($errorArr) == 0)
        {
            if ($password != $confirmPassword) {
                $errorArr[] = "Please be sure your passwords match.";
            }
            if (strlen($password) < 8) {
                $errorArr[] = "Please be sure your password is at least 8 characters.";
            }
            if (!preg_match('/[A-Z]/', $password)) {
                $errorArr[] = "Please be sure your password contains at least 1 uppercase letter.";
            }
            if (!preg_match('/[a-z]/', $password)) {
                $errorArr[] = "Please be sure your password contains at least 1 lowercase letter.";
            }
            if (!preg_match('/\d/', $password)) {
                $errorArr[] = "Please be sure your password contains at least 1 number.";
            }
            if (preg_match('/(.)\1{2,}/', $password)) {
                $errorArr[] = "Please be sure your password doesn't contain more than 2 identical characters in a row.";
            }
        }

        if (count($errorArr) == 0)
        {
            $tempUser = $this->user->get_temp_userB($urlKey);
            if ($tempUser)
            {
                $userId = $tempUser[0]['userId'];
                $userInfo = $this->user->get_user_userid($userId);

                $hash = password_hash($password, PASSWORD_BCRYPT);
                $this->user->update_password($userId, $hash);

                $userOrganization = $this->user->get_organization_info($userId);

                $localOrganizationId = $userOrganization[0]['organizationId'];
                $organizationName = $userOrganization[0]['organizationName'];
                $remoteGroupId = $userOrganization[0]['remoteGroupId'];
                $emailAddress = $userInfo['emailAddress'];

                $firstName = $userInfo['firstName'];
                $lastName = $userInfo['lastName'];
                $roleId = $userInfo['roleId'];
                $menuAFlag = $userInfo['menuAFlag'];
                $menuBFlag = $userInfo['menuBFlag'];

                $role = $this->user->get_role($roleId);

                $this->user->clean_tempB($emailAddress);

                $this->sessionLogin($userId, 0, NULL, $firstName, $lastName, $emailAddress, $organizationName, $localOrganizationId, $roleId, $menuAFlag, $menuBFlag);
            }

            if (count($errorArr) == 0)
            {
                $data = array("ok" => "true", "redirect" => TMVC_URL . 'schedules/weekview');
            }
            else
            {
                $data = array("ok" => "false", "title" => "Oops!", "content" => json_encode($errorArr));
            }
        }
        else
        {
            $data = array("ok" => "false", "title" => "Oops!", "content" => json_encode($errorArr));
        }

        session_write_close();
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

     function completeRegistration()
    {
        $this->load->model('User_Model', 'user');

        $validLink = TRUE;

        $urlKey = trim(htmlentities($_GET['userKey']));

        $tempUser = $this->user->get_temp_userB($urlKey);
        if (!$tempUser) {
            $validLink = FALSE;
        }

        // 48 hours, in seconds
        $timeout = 86400 * 2;
        if ((time() - $tempUser[0]['timeStamp']) > $timeout) {
            $validLink = FALSE;
        }

        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        if ($validLink == TRUE)
        {
            $this->smarty->assign('urlKey', $urlKey);
            $this->smarty->display(portalapp_THEME . '/completeRegistration.tpl');
        }
        else
        {
            $this->smarty->display(portalapp_THEME . '/completeRegistrationInvalid.tpl');
        }
        $this->smarty->display(portalapp_THEME . '/page_footer.tpl');
    }

    function completeRegistration2qwefqwef()
    {
        require_once(TMVC_BASEDIR . 'portalapp/libs/Mobile_Detect.php');
        $isMobile = FALSE;
        if (class_exists('Mobile_Detect')) {
            $detect = new Mobile_Detect;
            $isMobile = $detect->isMobile();
        }

        $this->refreshSessionStart();
        $this->load->model('User_Model', 'user');
        $this->load->model('Administration_Model', 'administration');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        // Define the rules and filters
        $filters = array(
            'selectSecurity'  => 'trim|sanitize_string',
            'answer'          => 'trim|sanitize_string',
            'password'        => 'trim|sanitize_string',
            'confirmPassword' => 'trim|sanitize_string'
        );
        $rules = array(
            'selectSecurity'  => 'required',
            'answer'          => 'required',
            'password'        => 'required',
            'confirmPassword' => 'required'
        );

        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);

        $securityId = trim(htmlentities($_POST['selectSecurity']));
        $security_answer = trim(htmlentities($_POST['answer']));

        $password = trim(htmlentities($_POST['password']));
        $confirmPassword = trim(htmlentities($_POST['confirmPassword']));
        
        $errorArr = array();

        if ($validated !== TRUE) {
            foreach ($validated as $v) {
                switch ($v['field']) {
                    case 'selectSecurity':
                        $errorArr[] = "Please select a security question.";
                        break;
                    case 'answer':
                        $errorArr[] = "Please enter an answer.";
                        break;
                    case 'password':
                        $errorArr[] = "Please enter a password.";
                        break;
                    case 'confirmPassword':
                        $errorArr[] = "Please enter a confirmation password.";
                        break;
                }
            }
        }

        if (count($errorArr) == 0)
        {
            if ($password != $confirmPassword) {
                $errorArr[] = "Please be sure your passwords match.";
            }
            if (strlen($password) < 8) {
                $errorArr[] = "Please be sure your password is at least 8 characters.";
            }
            if (!preg_match('/[A-Z]/', $password)) {
                $errorArr[] = "Please be sure your password contains at least 1 uppercase letter.";
            }
            if (!preg_match('/[a-z]/', $password)) {
                $errorArr[] = "Please be sure your password contains at least 1 lowercase letter.";
            }
            if (!preg_match('/\d/', $password)) {
                $errorArr[] = "Please be sure your password contains at least 1 number.";
            }
            if (preg_match('/(.)\1{2,}/', $password)) {
                $errorArr[] = "Please be sure your password doesn't contain more than 2 identical characters in a row.";
            }
        }

        if (count($errorArr) == 0)
        {
            $redirectURL = "";
            $errorMessage = "There was a problem processing your information. Please try registering again.";

            $urlKey = trim(htmlentities($_POST['urlKey']));

            $security_question = '';
            switch ($securityId) {
                case '1':
                    $security_question = "What is your mother&#039;s maiden name?";
                    break;
                case '2':
                    $security_question = "What is your father&#039;s middle name?";
                    break;
                case '3':
                    $security_question = "What&#039;s the name of the first school you attended?";
                    break;
                case '4':
                    $security_question = "What&#039;s your favorite band?";
                    break;
                case '5':
                    $security_question = "What&#039;s the name of your first pet?";
                    break;
                case '6':
                    $security_question = "What&#039;s the name of your favorite movie?";
                    break;
                case '7':
                    $security_question = "What&#039;s the name of your first childhood friend?";
                    break;
                case '8':
                    $security_question = "What was the first car that you owned?";
                    break;
            }

            $errorMessage = "There was a problem processing your information. Please try contact your administrator.";

            // This user is coming from the administration user setup.
            $tempUser = $this->user->get_temp_userB($urlKey);
            if ($tempUser)
            {
                $userId = $tempUser[0]['userId'];

                $userInfo = $this->user->get_user_userid($userId);
                $userOrganization = $this->user->get_organization_info($userId);

                $localOrganizationId = $userOrganization[0]['organizationId'];
                $organizationName = $userOrganization[0]['organizationName'];
                $remoteGroupId = $userOrganization[0]['remoteGroupId'];
                $emailAddress = $userInfo['emailAddress'];
                $firstName = $userInfo['firstName'];
                $lastName = $userInfo['lastName'];
                $roleId = $userInfo['roleId'];
                $menuAFlag = $userInfo['menuAFlag'];
                $menuBFlag = $userInfo['menuBFlag'];
                $userTypeId = $userInfo['userTypeId'];
                $gender = $userInfo['gender'];

                if ($gender != '') {
                    if ($gender == 'M') {
                        $gender = 1;
                    } else if ($gender == 'F') {
                        $gender = 2;
                    }
                } else {
                    $gender = 1;
                }
                $userType = $this->getUserType($userTypeId);

                        $role = $this->user->get_role($roleId);

                        $this->user->clean_tempB($emailAddress);

                        $this->sessionLogin($userId, 0, NULL, $firstName, $lastName, $emailAddress, $organizationName, $localOrganizationId, $roleId, $menuAFlag, $menuBFlag);


                            $redirectURL = "schedules/weekwiew";

            }
  

            if (count($errorArr) == 0)
            {
                $data = array("ok" => "true", "redirect" => TMVC_URL . $redirectURL);
            }
            else
            {
                $data = array("ok" => "false", "title" => "Oops!", "content" => json_encode($errorArr));
            }
        }
        else
        {
            $data = array("ok" => "false", "title" => "Oops!", "content" => json_encode($errorArr));
        }

        session_write_close();
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    function sessionLogin($userId, $remoteUserId, $photo, $firstName, $lastName, $emailAddress, $organizationName, $organizationId, $roleId, $menuAFlag, $menuBFlag)
    {
        $this->load->model('User_Model', 'user');

        $org = $this->user->get_organization_info_use_md_chat($organizationId);

        $_SESSION['logged'] = TRUE;
        $_SESSION['timeout'] = time();

        $_SESSION['userId'] = $userId;
        $_SESSION['remoteUserId'] = NULL;
        $_SESSION['photo'] = $photo;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['emailAddress'] = $emailAddress;
        $_SESSION['organizationName'] = $organizationName;
        $_SESSION['organizationId'] = $organizationId;
        $_SESSION['permissions'] = $this->getUserPermissions($roleId, $organizationId);
        $_SESSION['adminRoles'] = $this->administration->get_admin_roles();
        // To validate in menu-side bar, we will validate role only if it contains in adminRoles
        $_SESSION['adminRoleIds'] = array_flip(array_column($_SESSION['adminRoles'], 'id'));
        // In format of [roleId => index]; we only care about roleId to access it in O(1)
        $_SESSION['role'] = array_flip(array_column($this->administration->get_admin_user_roles($_SESSION['userId']), 'roleId'));
        $_SESSION['multipleLocationsOrg'] = $this->user->isMultipleLocationsOrg($organizationId);
        $_SESSION['administrationMenuFlag'] = $menuBFlag;

        $_SESSION['filterData'] = NULL;
        $_SESSION['filterDataLocations'] = NULL;
        $_SESSION['tempLogin'] = NULL;
        $_SESSION['filterHospitals'] = NULL;
        $_SESSION['filterLocations'] = NULL;
        $_SESSION['filterProviders'] = NULL;
        $_SESSION['filterDepartments'] = NULL;
        $_SESSION['showWelcomePopup'] = NULL;
        $_SESSION['calendarView'] = 'monthview';

        $user = $this->user->update_login_data($userId);
    }

    function getUserPermissionsqwefqwfeqwfe($roleId, $organizationId)
    {
        $roleQuery = $this->user->get_role_permissions($roleId, $organizationId);
        $permissions = array();
        foreach ($roleQuery as &$permission) {

                array_push($permissions, $permission['permission']);

        }
        return $permissions;
    }

    function sendMail($emailAddress, $subject, $message)
    {
        $mail = new Mail();
        $mail->prepare($subject, $message, $emailAddress, EMAIL_SENDER_ADDRESS, EMAIL_SENDER_NAME);
        $mail->IsHTML(true);
        $mail->Send();
    }

    function signout()
    {
        if (isset($_SESSION['logged']))
        {
            $_SESSION['isAdmin'] = 0;
            $_SESSION['userId'] = NULL;
            $_SESSION['firstName'] = NULL;
            $_SESSION['lastName'] = NULL;
            $_SESSION['emailAddress'] = NULL;
            $_SESSION['adminRoles'] = NULL;
            $_SESSION['adminRoleIds'] = NULL;
            $_SESSION['role'] = NULL;
            $_SESSION['logged'] = FALSE;
            $_SESSION['timeout'] = NULL;
        }
        header("Location: " . TMVC_URL);
        exit;
    }

    function generatePasswordHash()
    {
        $hash = password_hash('martinez9876', PASSWORD_BCRYPT);
        echo $hash;
    }
}