<?php

require_once(TMVC_BASEDIR . 'portalapp/libs/Mail.php');
require_once(TMVC_BASEDIR . 'portalapp/libs/Languages.php');

class PromoCodes_Controller extends App_Controller
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

        $userData = $this->administration->get_all_promoCodes();

        foreach ($userData as &$user) {
            $user['userType'] = $page;
            $user['expiresOn'] = date('M j, Y', strtotime($user['expiresOn']));
            $user['createdOn'] = date('M j, Y', strtotime($user['createdOn']));
            $encode = Crypt::enc_encrypt($user['promoCodeId']);
            $user['promoCodeId'] = $encode;
        }

        $this->smarty->assign('userData', $userData);
        $this->smarty->assign('page_nums', $pagination);
        //$this->smarty->assign('transportationPurchaseCount', $transportationPurchaseCount['count']);
        $this->smarty->assign('currentPage', 'promoCodes');
        $this->smarty->assign('subPage', '');
        $this->smarty->assign('pageTitle', 'Promo Codes');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/promo-codes.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function details()
    {
        $this->checkSession();

        $this->load->model('Administration_Model', 'administration');

        $successMessage = '';
        if (isset($_GET['mes'])) {
            $messageCode = $_GET['mes'];
            if ($messageCode == 'ts') {
                $successMessage = 'Details has been added.';
            } elseif ($messageCode == 'u') {
                $successMessage = 'Details has been updated.';
            }
        }

        $id = $_GET['id'];
        $userId = Crypt::enc_decrypt($id);

        $userData = $this->administration->get_promo_code_details($userId);

        $user['expiresOn'] = date('M j, Y', strtotime($user['expiresOn']));
        $user['createdOn'] = date('M j, Y', strtotime($user['createdOn']));

        $this->smarty->assign('userData', $userData);

        $this->smarty->assign('userIdEncoded', $id);
        $this->smarty->assign('successMessage', $successMessage);
        $this->smarty->assign('newUser', false);

        $this->smarty->assign('currentPage', 'promoCodes');
        $this->smarty->assign('subPage', '');
        $this->smarty->assign('pageTitle', 'Promo Codes Details');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/promo-codes-view.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer.tpl');
    }

    public function edit()
    {
        $this->checkSession();

        $this->load->model('Administration_Model', 'administration');

        $id = $_GET['id'];
        $userId = Crypt::enc_decrypt($id);

        $userData = $this->administration->get_promo_code_details($userId);

        $users = $this->administration->get_all_users();
        $verticals = $this->administration->get_all_verticals();

        if($userData['userId'] == NULL)
        {
            $userData['name'] = "";
        }
        else
        {
            $userData['name'] = $userData['firstName'] . " " . $userData['lastName'];
        }

        $this->smarty->assign('users', $users);
        $this->smarty->assign('verticals', $verticals);

        
        $this->smarty->assign('userData', $userData);
        $this->smarty->assign('newUser', false);
        $this->smarty->assign('userIdEncoded', $id);

        $this->smarty->assign('currentPage', 'promoCodes');
        $this->smarty->assign('subPage', '');
        $this->smarty->assign('pageTitle', 'Promo Codes Edit');
        $this->smarty->assign('subPageJS', 'userNewEdit');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        if (count($userData) > 1):
            $this->smarty->display(portalapp_THEME . '/promo-codes-edit.tpl');
        endif;
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
    }

    public function update()
    {
        $this->checkSession('json');

        $this->load->model('Administration_Model', 'administration');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        // Define the rules and filters
        $filters = array(
            'promoCode'           => 'trim|sanitize_string',
            'discount'     => 'trim|sanitize_string',
            'minimumPurchase'          => 'trim|sanitize_string',
            'specificUserId'    => 'trim|sanitize_string',
            'specificVertical'      => 'trim|sanitize_string',
            'expiresOn' => 'trim|sanitize_string'
        );
        $rules = array(
            'promoCode'           => 'required',
            'discount'     => 'required',
            'minimumPurchase'          => 'required',
            'expiresOn'    => 'required'
        );


        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);

        $errorArr = array();

        if ($validated !== true) {
            foreach ($validated as $v) {
                switch ($v['field']) {
                    case 'promoCode':
                        $errorArr[] = "Please enter the name.";
                        break;
                    case 'discount':
                        $errorArr[] = "Please enter the discount amount.";
                        break;
                    case 'minimumPurchase':
                        $errorArr[] = "Please enter the minimum purchase price.";
                        break;
                    case 'expiresOn':
                        $errorArr[] = "Please enter the expiry date.";
                        break;
                }
            }
        }

        if (count($errorArr) == 0):
            $uuid                = $_POST['uuid'];
            $promoCode = $_POST['promoCode'];
            $discount = $_POST['discount'];
            $minimumPurchase = $_POST['minimumPurchase'];
            $specificUserId = $_POST['specificUserId'];
            $specificVertical = $_POST['specificVertical'];
            $expiresOn = $_POST['expiresOn'];


            $id = trim($_POST['userId']);
            $userId = Crypt::enc_decrypt($id);

            if($_POST['userAutoComplete'] == "")
            {
                $specificUserId = null;
            }

            $userId = $this->administration->update_item($uuid, $userId, $promoCode, $discount, $minimumPurchase, $specificUserId, $specificVertical, $expiresOn);

            $redirect = 'details?id=' . $id . '&mes=u';

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

    public function create()
    {
        
        $this->checkSession();

        $this->load->model('Administration_Model', 'administration');

        $users = $this->administration->get_all_users();
        $verticals = $this->administration->get_all_verticals();

        $this->smarty->assign('users', $users);
        $this->smarty->assign('verticals', $verticals);

        $this->smarty->assign('currentPage', 'promoCodes');
        $this->smarty->assign('subPage', '');
        $this->smarty->assign('pageTitle', 'Promo Codes Add');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/promo-code-new.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function add()
    {

        $this->checkSession('json');

        $this->load->model('Administration_Model', 'administration');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        // Define the rules and filters
        $filters = array(
            'promoCode'           => 'trim|sanitize_string',
            'discount'     => 'trim|sanitize_string',
            'minimumPurchase'          => 'trim|sanitize_string',
            'specificUserId'    => 'trim|sanitize_string',
            'specificVertical'      => 'trim|sanitize_string',
            'expiresOn' => 'trim|sanitize_string'
        );
        $rules = array(
            'promoCode'           => 'required',
            'discount'     => 'required',
            'minimumPurchase'          => 'required',
            'expiresOn'    => 'required'
        );

        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);
        $errorArr = array();

        if ($validated !== true) {
            foreach ($validated as $v) {
                switch ($v['field']) {
                    case 'promoCode':
                        $errorArr[] = "Please enter the name.";
                        break;
                    case 'discount':
                        $errorArr[] = "Please enter the discount amount.";
                        break;
                    case 'minimumPurchase':
                        $errorArr[] = "Please enter the minimum purchase price.";
                        break;
                    case 'expiresOn':
                        $errorArr[] = "Please enter the expiry date.";
                        break;
                }
            }
        }
        
        if (count($errorArr) == 0):

            $promoCode = $_POST['promoCode'];
            $discount = $_POST['discount'];
            $minimumPurchase = $_POST['minimumPurchase'];
            $specificUserId = $_POST['specificUserId'];
            $specificVertical = $_POST['specificVertical'];
            $expiresOn = $_POST['expiresOn'];

            $insertId = $this->administration->add_item($promoCode, $discount, $minimumPurchase, $specificUserId, $specificVertical, $expiresOn);
            $redirect = 'details?id=' . Crypt::enc_encrypt($insertId) . '&mes=ts';

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

}

?>