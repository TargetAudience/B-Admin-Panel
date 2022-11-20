<?php
require_once(TMVC_BASEDIR . 'portalapp/libs/Mail.php');
require_once(TMVC_BASEDIR . 'portalapp/libs/Languages.php');

class Purchases_Controller extends App_Controller
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

        $userDataCount = $this->administration->get_all_purchases_all();
        $pagination = $this->getPagination($per_page, $page_number, $userDataCount['count']);
        $userData = $this->administration->get_all_purchases($pagination);
        $purchaseVerticals = $this->administration->getPurchaseVerticals();

        foreach ($userData as &$user) {
            $user['dateCreated'] = date('M j, Y', strtotime($user['createOn']));
            $encode = Crypt::enc_encrypt($user['purchaseId']);
            $user['purchaseIdEncoded'] = $encode;
        }

        $this->smarty->assign('purchaseVerticals', $purchaseVerticals);
        $this->smarty->assign('userData', $userData);
        $this->smarty->assign('page_nums', $pagination);
        $this->smarty->assign('currentPage', 'purchases');
        $this->smarty->assign('subPage', '');
        $this->smarty->assign('pageTitle', 'Purchases');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/purchases.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function filter()
    {
        $this->checkSession();

        $this->load->model('Administration_Model', 'administration');

        $per_page = 50;
        if (isset($_GET['page'])) {
            $page_number = $_GET['page'];
        } else {
            $page_number = 1;
        }

        $userDataCount = $this->administration->get_all_purchases_filtered_all($_POST['purchaseVerticals']);
        $pagination = $this->getPagination($per_page, $page_number, $userDataCount['count']);
        $userData = $this->administration->get_all_purchases_filtered($pagination, $_POST['purchaseVerticals']);
        $purchaseVerticals = $this->administration->getPurchaseVerticals();

        foreach ($userData as &$user) {
            $user['dateCreated'] = date('M j, Y', strtotime($user['createOn']));
            $encode = Crypt::enc_encrypt($user['purchaseId']);
            $user['purchaseIdEncoded'] = $encode;
        }

        $this->smarty->assign('currentVertical', $_POST['purchaseVerticals']);
        $this->smarty->assign('purchaseVerticals', $purchaseVerticals);
        $this->smarty->assign('userData', $userData);
        $this->smarty->assign('page_nums', $pagination);
        $this->smarty->assign('currentPage', 'purchases');
        $this->smarty->assign('subPage', '');
        $this->smarty->assign('pageTitle', 'Purchases');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/purchases.tpl');
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
            if ($messageCode == 't') {
                $successMessage = 'The item has been added.';
            } elseif ($messageCode == 'u') {
                $successMessage = 'The item has been updated.';
            }
        }

        $id = $_GET['id'];
        $userId = Crypt::enc_decrypt($id);

        $userData = $this->administration->get_all_purchases_details($userId);

        $userData['dateCreated'] = date('M j, Y', strtotime($userData['createOn']));
        $userData['cardType'] = ucwords($userData['cardType']);
        $userData['promoCode'] = $userData['promoCode'] == "" ? 'No' : $userData['promoCode'];

        $this->smarty->assign('userData', $userData);

        $this->smarty->assign('userIdEncoded', $id);
        $this->smarty->assign('successMessage', $successMessage);
        $this->smarty->assign('newUser', false);

        $this->smarty->assign('currentPage', 'purchases');
        $this->smarty->assign('subPage', '');
        $this->smarty->assign('pageTitle', 'Purchases - Details');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/purchases-view.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer.tpl');
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