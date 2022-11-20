<?php
define('SMARTY_SPL_AUTOLOAD', 1);
require(TMVC_BASEDIR . '/smarty/Smarty.class.php');
class TinyMVC_Library_Smarty_Wrapper Extends Smarty {
	function __construct() {
		parent::__construct();
		$this->setTemplateDir(TMVC_BASEDIR . '/smarty/templates/');
		$this->setCompileDir(TMVC_BASEDIR . '/smarty/templates_c/');
		$this->setConfigDir(TMVC_BASEDIR . '/smarty/configs/');
		$this->setCacheDir(TMVC_BASEDIR . '/smarty/cache/');
		$this->smarty->assign('ROOT', TMVC_BASEDIR);
		$this->smarty->assign('UPLOAD_FOLDER', UPLOAD_FOLDER);
		$this->smarty->assign('UPLOAD_FOLDER_MEDIA', UPLOAD_FOLDER_MEDIA);
		$this->smarty->assign('URL_ASSETS', TMVC_ASSDIR . portalapp_THEME);
		$this->smarty->assign('URL_ASSETS_GLOBAL', TMVC_ASSDIR . 'global');
		$this->smarty->assign('THEME', portalapp_THEME);
		$this->smarty->assign('URL', TMVC_URL);
		$this->smarty->assign('TITLE', TITLE);
		$this->smarty->assign('PRODUCTION', portalapp_PROD);
		$this->smarty->assign('NOCACHE', date('Y-m-d', strtotime('today')) . '-' . date('H'));

		if (!isset($subPageJS)) {
		    $this->smarty->assign('subPageJS', '');
		}
		if (!isset($subPage)) {
		    $this->smarty->assign('subPage', '');
		}
	}
}