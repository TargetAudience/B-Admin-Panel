<?php
class accessDenied_Controller extends App_Controller
{
    public function index()
    {
        $this->checkSession();

        $this->smarty->assign('currentPage', 'accessDenied');
        $this->smarty->assign('subPage', '');
        $this->smarty->assign('pageTitle', 'Access Denied');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/access-denied.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }
}
?>