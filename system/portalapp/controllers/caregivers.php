<?php
require_once(TMVC_BASEDIR . 'portalapp/libs/Mail.php');
require_once(TMVC_BASEDIR . 'portalapp/libs/Languages.php');

class Caregivers_Controller extends App_Controller
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
        $userDataCount = $this->administration->get_users_registered_caregivers_all();
        $pagination = $this->getPagination($per_page, $page_number, $userDataCount['count']);
        $userData = $this->administration->get_users_registered_caregivers($pagination);

        foreach ($userData as &$user) {
            $user['userType'] = $page;
            $encode = Crypt::enc_encrypt($user['userId']);
            $user['userIdEncoded'] = $encode;
        }

        $this->smarty->assign('userData', $userData);
        $this->smarty->assign('page_nums', $pagination);
        $this->smarty->assign('currentPage', 'caregivers');
        $this->smarty->assign('subPage', '');
        $this->smarty->assign('pageTitle', 'Caregivers');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/caregivers.tpl');
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
            if ($messageCode == 'ts') {
                $successMessage = 'The user has been added.';
            } elseif ($messageCode == 'u') {
                $successMessage = 'The user has been updated.';
            }
        }

        $id = $_GET['id'];
        $userId = Crypt::enc_decrypt($id);

        $userData = $this->users->get_user($userId);

        $userData['createOn'] = date('M j, Y', strtotime($userData['createOn']));
        $userData['primaryCarePerson'] = $userData['accountHolder'] == 1 ? 'Yes' : 'No';

        if ($userData['updatedOn']) {
            $userData['lastVisitOn'] = date('M j, Y', strtotime($userData['updatedOn']));
        } else {
            $userData['lastVisitOn'] = '-';
        }

        $userData['phoneNumber'] = $this->formatPhoneNumber($userData['phoneNumber']);
        $userData['additionalPhoneNumber'] = $this->formatPhoneNumber($userData['additionalPhoneNumber']);
        $userData['alternateContactNumber'] = $this->formatPhoneNumber($userData['alternateContactNumber']);

        $this->smarty->assign('userData', $userData);

        $this->smarty->assign('userIdEncoded', $id);
        $this->smarty->assign('successMessage', $successMessage);
        $this->smarty->assign('newUser', false);

        $this->smarty->assign('currentPage', 'caregivers');
        $this->smarty->assign('subPage', 'userProfile');
        $this->smarty->assign('pageTitle', 'Caregivers | ' . $userData['firstName']);
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/caregivers-view.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer.tpl');
    }

    public function addUser()
    {
        $this->checkSession();

        $this->smarty->assign('newUser', true);

        $this->smarty->assign('currentPage', 'caregivers');
        $this->smarty->assign('subPage', 'addUser');
        $this->smarty->assign('pageTitle', 'Caregivers');
        $this->smarty->assign('subPageJS', 'userNewEdit');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/caregivers-add.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
    }

    public function editUser()
    {
        $this->checkSession();

        $this->load->model('Administration_Model', 'administration');

        $id = $_GET['id'];
        $userId = Crypt::enc_decrypt($id);

        $userData = $this->administration->get_user($userId);
        
        $this->smarty->assign('userData', $userData);
        $this->smarty->assign('newUser', false);
        $this->smarty->assign('userIdEncoded', $id);

        $this->smarty->assign('currentPage', 'caregivers');
        $this->smarty->assign('subPage', 'editUser');
        $this->smarty->assign('pageTitle', 'Caregivers | ' . $userData['firstName']);
        $this->smarty->assign('subPageJS', 'userNewEdit');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        if (count($userData) > 1):
            $this->smarty->display(portalapp_THEME . '/caregivers-edit.tpl');
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
            'accountHolder' => 'trim|sanitize_string',
            'street' => 'trim|sanitize_string',
            'city' => 'trim|sanitize_string',
            'province' => 'trim|sanitize_string',
            'postalCode' => 'trim|sanitize_string',
            'phoneNumber' => 'trim|sanitize_string',
            'additionalPhoneNumber' => 'trim|sanitize_string',
            'alternateContactName' => 'trim|sanitize_string'


        );
        $rules = array(
            'firstName'    => 'required',
            'lastName'     => 'required',
            'emailAddress'         => 'required|valid_email',
            'street'     => 'required',
            'city'     => 'required',
            'province'     => 'required',
            'postalCode'     => 'required',
            'phoneNumber'     => 'required',
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
                    case 'accountHolder':
                        $errorArr[] = "Please enter a primary care person.";
                        break;
                    case 'street':
                        $errorArr[] = "Please enter a street.";
                        break;
                    case 'city':
                        $errorArr[] = "Please enter a city.";
                        break;
                    case 'province':
                        $errorArr[] = "Please enter a province.";
                        break;
                    case 'postalCode':
                        $errorArr[] = "Please enter a postal code.";
                        break;
                    case 'phoneNumber':
                        $errorArr[] = "Please enter a phone number.";
                        break;
                }
            }
        }

        if (count($errorArr) == 0):
            $uuid                = $_POST['uuid'];
        $first_name          = $_POST['firstName'];
        $last_name           = $_POST['lastName'];
        $email               = $_POST['emailAddress'];
        $primaryCarePerson               = $_POST['accountHolder'];
        $street               = $_POST['street'];
        $city                = $_POST['city'];
        $province               = $_POST['province'];
        $postalCode               = $_POST['postalCode'];
        $phoneNumber               = $_POST['phoneNumber'];
        $additionalPhoneNumber               = $_POST['additionalPhoneNumber'];
        $alternateContactName               = $_POST['alternateContactName'];

        $id = trim($_POST['userId']);
        $userId = Crypt::enc_decrypt($id);

        if ($userId == null) {

            $userId = $this->administration->create_caregiver($first_name, $last_name, $email, $primaryCarePerson, $street, $city, $province, $postalCode, $phoneNumber, $additionalPhoneNumber, $alternateContactName);

            $redirect = 'userProfile?id=' . Crypt::enc_encrypt($userId) . '&mes=ts';
        } else {
            $this->administration->update_user($uuid, $userId, $first_name, $last_name, $email, $primaryCarePerson, $street, $city, $province, $postalCode, $phoneNumber, $additionalPhoneNumber, $alternateContactName);
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

    function formatPhoneNumber($phoneNumber) {
        $phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

        if(strlen($phoneNumber) > 10) {
            $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
            $areaCode = substr($phoneNumber, -10, 3);
            $nextThree = substr($phoneNumber, -7, 3);
            $lastFour = substr($phoneNumber, -4, 4);

            $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
        }
        else if(strlen($phoneNumber) == 10) {
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3, 3);
            $lastFour = substr($phoneNumber, 6, 4);

            $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
        }
        else if(strlen($phoneNumber) == 7) {
            $nextThree = substr($phoneNumber, 0, 3);
            $lastFour = substr($phoneNumber, 3, 4);

            $phoneNumber = $nextThree.'-'.$lastFour;
        }

        return $phoneNumber;
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