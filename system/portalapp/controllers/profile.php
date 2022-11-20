<?php
class Profile_Controller extends App_Controller
{
    //error_log(print_R($validated,TRUE));

    function index()
    {
        $this->checkSession();

        $path = tmvc::instance()->url_segments;
        $successMessage = '';
        if (count($path) == 3)
        {
            if ($path[3] == 's')
            {
                $successMessage = 'Your profile has been updated.';
            }
        }
        $this->smarty->assign('successMessage', $successMessage);

        $this->load->model('User_Model', 'user');

        $userData = $this->user->get_user_userid_b($_SESSION['userId']);

        $this->smarty->assign('userData', $userData);

        $this->smarty->assign('currentPage', '');
        $this->smarty->assign('subPage', 'profile');
        $this->smarty->assign('pageTitle', 'My Profile');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header.tpl');
        $this->smarty->display(portalapp_THEME . '/profile.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer.tpl');
    }
    
    function createUpdateProfile()
    {
        $this->checkSession('json');

        $this->load->model('User_Model', 'user');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        // Define the rules and filters
        $filters = array(
            'currentPassword' => 'trim',
            'newPassword'     => 'trim',
            'confirmPassword' => 'trim'
        );
        $rules = array(
            'currentPassword' => 'required',
            'newPassword'     => 'required',
            'confirmPassword' => 'required'
        );

        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);

        $errorArr = array();

        if($validated !== TRUE) {
            foreach($validated as $v) {
                switch($v['field']) {
                    case 'currentPassword':
                        $errorArr[] = "Please enter your current password.";
                        break;
                    case 'newPassword':
                        $errorArr[] = "Please enter a new password.";
                        break;
                    case 'confirmPassword':
                        $errorArr[] = "Please confirm your new password.";
                        break;
                }
            }
        }

        $currentPassword = trim($_POST['currentPassword']);
        $newPassword = trim($_POST['newPassword']);
        $confirmPassword = trim($_POST['confirmPassword']);

        if (count($errorArr) == 0) {
            if ($newPassword != $confirmPassword) {
                $errorArr[] = "Please be sure your new password and your confirm password match.";
            }
            if (strlen($newPassword) < 8) {
                $errorArr[] = "Please be sure your new password is at least 8 characters.";
            }
            $user = $this->user->get_user_userid_b($_SESSION['userId']);

            error_log(print_R(password_verify($currentPassword, $user['passwordHash']),TRUE));

            if (!password_verify($currentPassword, $user['passwordHash'])) {
                $errorArr[] = "Your current password was incorrect. Please try again.";
            }
        }

        if (count($errorArr) == 0): 
            $hash = password_hash($newPassword, PASSWORD_BCRYPT);
            $this->user->update_password($_SESSION['userId'], $hash);

            $messageType = "s";
            $data = array("ok" => "true", "messageType" => $messageType);

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
}