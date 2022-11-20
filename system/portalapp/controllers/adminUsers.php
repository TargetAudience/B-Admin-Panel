<?php
require_once(TMVC_BASEDIR . 'portalapp/libs/Mail.php');
require_once(TMVC_BASEDIR . 'portalapp/libs/Languages.php');

class adminUsers_Controller extends App_Controller
{
    public function index()
    {
        $this->checkSession();

        $this->load->model('Administration_Model', 'administration');

        $per_page = 50;
        if (isset($_GET['page'])) {
            $page_number = $_GET['page'];
        } else {
            $page_number = 1;
        }

        $userDataCount = $this->administration->get_users_admin_all();
        $pagination = $this->getPagination($per_page, $page_number, $userDataCount['count']);
        $userData = $this->administration->get_users_admin($pagination);

        foreach ($userData as &$user) {
            $user['userType'] = $page;
            $user['dateCreated'] = date('M j, Y', strtotime($user['dateCreated']));
            $encode = Crypt::enc_encrypt($user['userId']);
            $user['userIdEncoded'] = $encode;
        }

        $this->smarty->assign('userData', $userData);
        $this->smarty->assign('page_nums', $pagination);

        $this->smarty->assign('currentPage', 'adminUsers');
        $this->smarty->assign('subPage', '');
        $this->smarty->assign('pageTitle', 'Admin Users');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/user-admin.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function userProfile()
    {
        $this->checkSession();

        $this->load->model('Users_Model', 'users');

        $successMessage = '';
        if (isset($_GET['mes'])) {
            $messageCode = $_GET['mes'];
            if ($messageCode == 't') {
                $successMessage = 'The user has been added.';
            } elseif ($messageCode == 'u') {
                $successMessage = 'The user has been updated.';
            }
        }

        $id = $_GET['id'];
        $userId = Crypt::enc_decrypt($id);

        $userData = $this->users->get_admin_user($userId);

        $userData['dateCreated'] = date('M j, Y', strtotime($userData['dateCreated']));
        $userData['lastLogin'] = date('M j, Y', strtotime($userData['lastLogin']));

        $this->smarty->assign('userData', $userData);

        $this->smarty->assign('userIdEncoded', $id);
        $this->smarty->assign('successMessage', $successMessage);
        $this->smarty->assign('newUser', false);

        $this->smarty->assign('currentPage', 'adminUsers');
        $this->smarty->assign('subPage', 'adminUserProfile');
        $this->smarty->assign('pageTitle', 'Admin User Profile | ' . $userData['firstName']);
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/user-admin-view.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer.tpl');
    }

    public function addUser()
    {
        $this->checkSession();

        $this->load->model('Administration_Model', 'administration');
        $adminRoles = $this->administration->get_admin_roles();
        
        $this->smarty->assign('adminRoles', $adminRoles);
        $this->smarty->assign('newUser', true);
        $this->smarty->assign('currentPage', 'usersRegistered');
        $this->smarty->assign('subPage', 'addAdminUser');
        $this->smarty->assign('pageTitle', 'Add Admin User');
        $this->smarty->assign('subPageJS', 'userNewAdd');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/user-admin-add.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
    }

    public function insertUser()
    {
        $this->checkSession('json');

        $this->load->model('Administration_Model', 'administration');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        // Define the rules and filters
        $filters = array(
            'firstName'    => 'trim|sanitize_string',
            'lastName'     => 'trim|sanitize_string',
            'emailAddress'         => 'trim|sanitize_email',


        );
        $rules = array(
            'firstName'    => 'required',
            'lastName'     => 'required',
            'emailAddress'  => 'required|valid_email',
            'role'          => 'required',
        );


        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);
        
        $errorArr = array();
        $role               = $_POST['role'];
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
                    case 'password':
                        $errorArr[] = "Please enter a password.";
                        break;
                    case 'confirmpassword':
                        $errorArr[] = "Please enter a confirm password.";
                        break;
                }
            }
        }
        else if (count($role) == 0 || (count($role) == 1 && $role[0] == '')) $errorArr[] = "Please enter a role.";

        if ($_POST['password'] != $_POST['confirmpassword']) {
            $errorArr[] = "Please be sure your new password and your confirm password match.";
        }

        if (count($errorArr) == 0):
        $first_name          = $_POST['firstName'];
        $last_name           = $_POST['lastName'];
        $email               = $_POST['emailAddress'];
        $password               = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $passwordConfirm               = $_POST['confirmpassword'];

        $userId = $this->administration->create_admin_user($first_name, $last_name, $email, $role, $password);

        $redirect = 'userProfile?id=' . Crypt::enc_encrypt($userId) . '&mes=ts';

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

    public function editUser()
    {
        $this->checkSession();

        $this->load->model('Users_Model', 'users');

        $id = $_GET['id'];
        $userId = Crypt::enc_decrypt($id);

        $userData = $this->users->get_admin_user($userId);

        $this->load->model('Administration_Model', 'administration');
        $adminRoles = $this->administration->get_admin_roles();
        $adminUserRoles = [];
        // Converting adminUserRoles to [roleId => roleId] format so we can access it in O(1) complexity
        foreach($this->administration->get_admin_user_roles($userId) as $role) {
            $adminUserRoles[$role['roleId']] = $role['roleId'];
        }


        $this->smarty->assign('adminRoles', $adminRoles);
        $this->smarty->assign('adminUserRoles', $adminUserRoles);
        $this->smarty->assign('userData', $userData);
        $this->smarty->assign('newUser', false);
        $this->smarty->assign('userIdEncoded', $id);

        $this->smarty->assign('currentPage', 'usersRegistered');
        $this->smarty->assign('subPage', 'editAdminUser');
        $this->smarty->assign('pageTitle', 'Edit Admin User');
        $this->smarty->assign('subPageJS', 'userNewEdit');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        if (count($userData) > 1):
            $this->smarty->display(portalapp_THEME . '/user-admin-edit.tpl');
        endif;
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
    }

    public function createUpdateUser()
    {
        $this->checkSession('json');

        $this->load->model('Administration_Model', 'administration');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        // Define the rules and filters
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

        $role               = $_POST['role'];
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
        else if (count($role) == 0 || (count($role) == 1 && $role[0] == '')) $errorArr[] = "Please enter a role.";
        if (count($errorArr) == 0):
            $uuid                = $_POST['uuid'];
        $first_name          = $_POST['firstName'];
        $last_name           = $_POST['lastName'];
        $email               = $_POST['emailAddress'];

        $id = trim($_POST['userId']);
        $userId = Crypt::enc_decrypt($id);

        if ($userId == null) {
            $uuid = utilities::createUUID;
            $userId = $this->administration->create_admin_user($first_name, $last_name, $email, $role);

            $redirect = 'userProfile?id=' . Crypt::enc_encrypt($userId) . '&mes=ts';
        } else {
            $this->administration->update_admin_user($userId, $first_name, $last_name, $email, $role);
            $redirect = 'userProfile?id=' . $id . '&mes=u';
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


?>