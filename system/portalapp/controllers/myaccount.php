<?php
require_once(TMVC_BASEDIR . 'portalapp/libs/Mail.php');
require_once(TMVC_BASEDIR . 'portalapp/libs/Languages.php');

class MyAccount_Controller extends App_Controller 
{
    public function index()
    {
        $this->checkSession();

        $id = $_SESSION['userId'];
        $userId = Crypt::enc_encrypt($id);

        $successMessage = '';
        if (isset($_GET['mes'])) {
            $messageCode = $_GET['mes'];
            if ($messageCode == 'ts') {
                $successMessage = 'The user has been added.';
            } elseif ($messageCode == 'u') {
                $successMessage = 'The user has been updated.';
            }
        }

        if (array_key_exists(7, $_SESSION['role'])) {
            $this->load->model('Users_Model', 'users');
            $userData = $this->users->get_admin_user($id);
            $type = 'adminUser';
        }
        else
        {
            $this->load->model('Administration_Model', 'administration');
            $userData = $this->administration->get_user($id);
            $type = 'user';
        }

        $this->smarty->assign('type', $type);
        $this->smarty->assign('userData', $userData);
        $this->smarty->assign('userIdEncoded', $userId);
        $this->smarty->assign('successMessage', $successMessage);
        $this->smarty->assign('currentPage', 'myaccount');
        $this->smarty->assign('subPage', 'profile');
        $this->smarty->assign('pageTitle', 'My Account');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/myaccount.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');

    }

    public function resetPassword()
    {
        $this->checkSession();

        $id = $_SESSION['userId'];
        $userId = Crypt::enc_encrypt($id);

        if (array_key_exists(7, $_SESSION['role'])) {
            $this->load->model('Users_Model', 'users');
            $userData = $this->users->get_admin_user($id);
            $type = 'adminUser';
        }
        else
        {
            $this->load->model('Administration_Model', 'administration');
            $userData = $this->administration->get_user($id);
            $type = 'user';
        }

        $this->smarty->assign('type', $type);
        $this->smarty->assign('userData', $userData);
        $this->smarty->assign('userIdEncoded', $userId);
        $this->smarty->assign('currentPage', 'myaccount');
        $this->smarty->assign('subPage', 'resetPassword');
        $this->smarty->assign('pageTitle', 'My Account - Reset Password');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/reset_password.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function updatePassword()
    {
        $this->checkSession('json');

        $id = $_SESSION['userId'];
        
        if (array_key_exists(7, $_SESSION['role'])) {
            $this->load->model('Users_Model', 'users');
            $user = $this->users->get_admin_user($id);
        }
        else
        {
            $this->load->model('Administration_Model', 'administration');
            $user = $this->administration->get_user($id);
        }

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

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

            if (!password_verify($currentPassword, $user['passwordHash'])) {
                $errorArr[] = "Your current password was incorrect. Please try again.";
            }
        }

        if (count($errorArr) == 0): 
            $hash = password_hash($newPassword, PASSWORD_BCRYPT);

            if (array_key_exists(7, $_SESSION['role'])) {
                $this->users->update_admin_password($_SESSION['userId'], $hash);
            }
            else
            {
                $this->administration->update_password($_SESSION['userId'], $hash);
            }

            $redirect = "/myaccount?mes=u";
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

    public function update()
    {
        $this->checkSession('json');

        $this->load->model('Administration_Model', 'administration');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        $filters = array(
            'firstName'    => 'trim|sanitize_string',
            'lastName'     => 'trim|sanitize_string',
            'emailAddress'         => 'trim|sanitize_email',


        );
        $rules = array(
            'firstName'    => 'required',
            'lastName'     => 'required',
            'emailAddress'  => 'required|valid_email',
        );

        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);

        $errorArr = array();

        if ($validated !== true) {
            foreach ($validated as $v) {
                switch ($v['field']) {
                    case 'firstName':
                        $errorArr[] = "Please enter a first name.";
                        break;
                    case 'lastName':
                        $errorArr[] = "Please select a last name.";
                        break;
                    case 'emailAddress':
                        $errorArr[] = "Please enter an e-mail address.";
                        break;
                }
            }
        }

        if (count($errorArr) == 0):
            $uuid                = $_POST['uuid'];
            $first_name          = $_POST['firstName'];
            $last_name           = $_POST['lastName'];
            $email               = $_POST['emailAddress'];

            $id = trim($_POST['userId']);
            $userId = Crypt::enc_decrypt($id);

            if($_POST['type'] == "adminUser")
            {
                $this->administration->update_admin_user($userId, $first_name, $last_name, $email);
                $redirect = 'myaccount?mes=u';
            }
            else
            {
                $this->administration->update_user_profile($uuid, $userId, $first_name, $last_name, $email);
                $redirect = 'myaccount?mes=u';
            }

            $data = array("ok" => "true", "redirect" => $redirect);

            session_write_close();
            header('Content-Type: application/json');
            echo json_encode($data);
            exit(); else:
                $data = array("ok" => "false", "title" => "Oops!", "content" => json_encode($errorArr));
    
            session_write_close();
            header('Content-Type: application/json');
            echo json_encode($data);
            exit();
            endif;
    }
}

?>