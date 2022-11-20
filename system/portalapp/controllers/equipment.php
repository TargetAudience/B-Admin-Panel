<?php
require_once(TMVC_BASEDIR . 'portalapp/libs/Mail.php');
require_once(TMVC_BASEDIR . 'portalapp/libs/Languages.php');
require_once(TMVC_BASEDIR . '../vendor/autoload.php');

use Ramsey\Uuid\Uuid;

class Equipment_Controller extends App_Controller
{
    // error_log(print_R($var,TRUE));

    public function newItem()
    {
        $this->checkSession();

        $this->load->model('Equipment_Model', 'equipment');

        $type = 'purchase';
        if ($_POST['button_click'] == 'ADD RENTAL ITEM') {
            $type = 'rent';
        }

        $equipmentCategories = $this->equipment->get_equipment_categories();

        $this->smarty->assign('equipmentCategories', $equipmentCategories);

        $this->smarty->assign('type', $type);

        $this->smarty->assign('currentPage', 'equipment');
        $this->smarty->assign('subPage', 'newItem');
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/equipment-new-item.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function index()
    {
        $this->checkSession();

        $this->load->model('Equipment_Model', 'equipment');

        $page = 'rent';
        if (isset($_GET['type'])) {
            $page = $_GET['type'];
        }

        $per_page = 50;
        if (isset($_GET['page'])) {
            $page_number = $_GET['page'];
        } else {
            $page_number = 1;
        }

        $equipmentRentalCount = $this->equipment->get_equipment_rent_all();
        $equipmentPurchaseCount = $this->equipment->get_equipment_purchase_all();

        if ($page == 'rent') {
            $pagination = $this->getPagination($per_page, $page_number, $equipmentRentalCount['count']);
            $equipmentData = $this->equipment->get_equipment_rent($pagination);
            $template = 'equipment-rent';
            $userType = 1;
        } elseif ($page == 'purchase') {
            $pagination = $this->getPagination($per_page, $page_number, $equipmentPurchaseCount['count']);
            $equipmentData = $this->equipment->get_equipment_purchase($pagination);
            $template = 'equipment-purchase';
            $userType = 0;
        }

        foreach ($equipmentData as &$item) {
            if ($page == 'purchase') {
                $item['price'] = number_format($item['price'], 2);
            }

            $encode = Crypt::enc_encrypt($item['itemUuid']);
            $item['equipmentIdEncoded'] = $encode;
        }

        $this->smarty->assign('equipmentRentalCount', $equipmentPurchaseCount['count']);
        $this->smarty->assign('equipmentPurchaseCount', $equipmentRentalCount['count']);
        $this->smarty->assign('equipmentData', $equipmentData);
        $this->smarty->assign('page_nums', $pagination);

        $this->smarty->assign('type', $page);

        $this->smarty->assign('currentPage', 'equipment');
        $this->smarty->assign('subPage', $page);
        $this->smarty->assign('pageTitle', 'Equipment');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/equipment.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function item()
    {
        $this->checkSession();

        $this->load->model('Equipment_Model', 'equipment');
        
        $successMessage = '';
        if (isset($_GET['mes'])) {
            $messageCode = $_GET['mes'];
            if ($messageCode == 's') {
                $successMessage = 'The equipment item has been updated.';
            } else if ($messageCode == 'ts') {
                $successMessage = 'The equipment item has been added.';
            }
        }

        $type = $_GET['type'];
        $id = $_GET['id'];
        $itemId = Crypt::enc_decrypt($id);

        if ($type == 'rent') {
            $equipmentData = $this->equipment->get_equipment_rent_item($itemId);
            $equipmentOptions = $this->equipment->get_equipment_rent_options($itemId);
            $equipmentData['options'] = $equipmentOptions;
        } else {
            $equipmentData = $this->equipment->get_equipment_purchase_item($itemId);
        }

        $equipmentData['createOn'] = date('M j, Y', strtotime($equipmentData['createOn']));
        if ($equipmentData['updateOn']) {
            $updateOn = date('M j, Y', strtotime($equipmentData['updateOn']));
            $equipmentData['lastUpdate'] = $updateOn . ' by ' . $equipmentData['firstName'] . ' ' . $equipmentData['lastName'];
        } else {
            $equipmentData['lastUpdate'] = '-';
        }

        $this->smarty->assign('equipmentData', $equipmentData);

        $this->smarty->assign('itemIdEncoded', $id);
        $this->smarty->assign('type', $type);

        $this->smarty->assign('successMessage', $successMessage);
        $this->smarty->assign('currentPage', 'equipment');
        $this->smarty->assign('subPage', 'details');
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/equipment-item.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function pricing()
    {
        $this->checkSession();

        $this->load->model('Equipment_Model', 'equipment');

        $successMessage = '';
        if (isset($_GET['mes'])) {
            $messageCode = $_GET['mes'];
            if ($messageCode == 's') {
                $successMessage = 'The equipment pricing has been saved.';
            }
        }

        $type = $_GET['type'];
        $id = $_GET['id'];
        $itemId = Crypt::enc_decrypt($id);

        $options = $this->equipment->get_equipment_rent_options($itemId);

        $this->smarty->assign('options', $options);

        $this->smarty->assign('itemIdEncoded', $id);
        $this->smarty->assign('type', $type);

        $this->smarty->assign('successMessage', $successMessage);
        $this->smarty->assign('currentPage', 'equipment');
        $this->smarty->assign('subPage', 'pricing');
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/equipment-pricing.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function sizes()
    {
        $this->checkSession();

        $this->load->model('Equipment_Model', 'equipment');

        $successMessage = '';
        if (isset($_GET['mes'])) {
            $messageCode = $_GET['mes'];
            if ($messageCode == 's') {
                $successMessage = 'The equipment sizes has been saved.';
            }
        }

        $type = $_GET['type'];
        $id = $_GET['id'];
        $itemId = Crypt::enc_decrypt($id);

        $options = $this->equipment->get_equipment_rent_sizes($itemId);

        $this->smarty->assign('options', $options);

        $this->smarty->assign('itemIdEncoded', $id);
        $this->smarty->assign('type', $type);

        $this->smarty->assign('successMessage', $successMessage);
        $this->smarty->assign('currentPage', 'equipment');
        $this->smarty->assign('subPage', 'sizes');
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/equipment-sizes.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function images()
    {
        $this->checkSession();

        $this->load->model('Equipment_Model', 'equipment');

        $type = $_GET['type'];
        $id = $_GET['id'];
        $itemId = Crypt::enc_decrypt($id);

        if ($type == 'rent') {
            $equipmentData = $this->equipment->get_equipment_rent_item($itemId);
        } else {
            $equipmentData = $this->equipment->get_equipment_purchase_item($itemId);
        }

        $this->smarty->assign('equipmentData', $equipmentData);

        $this->smarty->assign('itemIdEncoded', $id);
        $this->smarty->assign('type', $type);

        $this->smarty->assign('currentPage', 'equipment');
        $this->smarty->assign('subPage', 'images');
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/equipment-images.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

////////////////
// EDITS
////////////////

    public function editItem()
    {
        $this->checkSession();

        $this->load->model('Equipment_Model', 'equipment');

        $type = $_GET['type'];
        $id = $_GET['id'];
        $itemId = Crypt::enc_decrypt($id);

        if ($type == 'rent') {
            $equipmentData = $this->equipment->get_equipment_rent_item($itemId);
            $equipmentOptions = $this->equipment->get_equipment_rent_options($itemId);
            $equipmentData['options'] = $equipmentOptions;
        } else {
            $equipmentData = $this->equipment->get_equipment_purchase_item($itemId);
        }

        $equipmentCategories = $this->equipment->get_equipment_categories();

        $equipmentData['createOn'] = date('M j, Y', strtotime($equipmentData['createOn']));
        if ($equipmentData['updateOn']) {
            $updateOn = date('M j, Y', strtotime($equipmentData['updateOn']));
            $equipmentData['lastUpdate'] = $updateOn . ' by ' . $equipmentData['firstName'] . ' ' . $equipmentData['lastName'];
        } else {
            $equipmentData['lastUpdate'] = '-';
        }

        $this->smarty->assign('equipmentData', $equipmentData);
        $this->smarty->assign('equipmentCategories', $equipmentCategories);

        $this->smarty->assign('itemIdEncoded', $id);
        $this->smarty->assign('type', $type);

        $this->smarty->assign('currentPage', 'equipment');
        $this->smarty->assign('subPage', 'details');
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/equipment-item-edit.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function editPricing()
    {
        $this->checkSession();

        $this->load->model('Equipment_Model', 'equipment');

        $type = $_GET['type'];
        $id = $_GET['id'];
        $itemId = Crypt::enc_decrypt($id);

        $options = $this->equipment->get_equipment_rent_options($itemId);
        
        if (!empty($options)) {
            $order = $this->get_counter('9', FALSE, 1);
            $extras = $this->get_counter('3', FALSE, 1);
            $count = 9;
        } else {
            $order = $this->get_counter('5', FALSE, 1);
            $extras = $this->get_counter('5', FALSE, 1);
            $count = 5;
        }

        $this->smarty->assign('options', $options);
        $this->smarty->assign('order', $order);
        $this->smarty->assign('extras', $extras);
        $this->smarty->assign('count', $count);

        $this->smarty->assign('itemIdEncoded', $id);
        $this->smarty->assign('type', $type);

        $this->smarty->assign('currentPage', 'equipment');
        $this->smarty->assign('subPage', 'pricing');
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/equipment-pricing-edit.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function editSizes()
    {

        $this->checkSession();

        $this->load->model('Equipment_Model', 'equipment');

        $type = $_GET['type'];
        $id = $_GET['id'];
        $itemId = Crypt::enc_decrypt($id);

        $options = $this->equipment->get_equipment_rent_sizes($itemId);
        
        if (!empty($options)) {
            $order = $this->get_counter('9', FALSE, 1);
            $extras = $this->get_counter('3', FALSE, 1);
            $count = 9;
        } else {
            $order = $this->get_counter('5', FALSE, 1);
            $extras = $this->get_counter('5', FALSE, 1);
            $count = 5;
        }

        $this->smarty->assign('options', $options);
        $this->smarty->assign('order', $order);
        $this->smarty->assign('extras', $extras);
        $this->smarty->assign('count', $count);

        $this->smarty->assign('itemIdEncoded', $id);
        $this->smarty->assign('type', $type);

        $this->smarty->assign('currentPage', 'equipment');
        $this->smarty->assign('subPage', 'sizes');
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/equipment-sizes-edit.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function editImages()
    {

        $this->checkSession();

        $this->load->model('Equipment_Model', 'equipment');

        $type = $_GET['type'];
        $id = $_GET['id'];
        $itemId = Crypt::enc_decrypt($id);

        $equipmentData = $this->equipment->get_equipment_rent_item($itemId);

        $this->smarty->assign('equipmentData', $equipmentData);

        $this->smarty->assign('itemIdEncoded', $id);
        $this->smarty->assign('type', $type);

        $this->smarty->assign('currentPage', 'equipment');
        $this->smarty->assign('subPage', 'images');
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/equipment-images-edit.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function imageUpload()
    {

        $this->checkSession();

        $this->load->model('Equipment_Model', 'equipment');

        $file = array_shift($_FILES);
        $fileSize = $file['size'];

        if ($fileSize > 5242870) {
            $data = 'The image you are trying to upload is too large in size.';
        } else if (!empty($file)) {
            $itemId = Crypt::enc_decrypt($_GET['id']);
            $imageType = $_GET['imageType'];
            $type = $_GET['type'];

            if ($file['error'] !== UPLOAD_ERR_OK) {
                $data = 'An error occurred uploading the file.';
            }

            if (!is_dir(UPLOAD_FOLDER . 'equipment')) {
                mkdir(UPLOAD_FOLDER . 'equipment', 0755);
            }

            if ($type == 'rent') {
                $equipmentData = $this->equipment->get_equipment_rent_item($itemId);
            } else {
                $equipmentData = $this->equipment->get_equipment_purchase_item($itemId);
            }

            if ($imageType == 'thumb') {
                if (!empty($equipmentData['thumb'])) {
                    $oldFile = UPLOAD_FOLDER . 'equipment/' . $equipmentData['thumb'];
                    if(unlink($oldFile)) {}
                }
            } else if ($imageType == 'main') {
                if (!empty($equipmentData['featureImage'])) {
                    $oldFile = UPLOAD_FOLDER . 'equipment/' . $equipmentData['featureImage'];
                    if(unlink($oldFile)) {}
                }
            }

            $filename = preg_replace("/[^A-Z0-9._-]/i", "_", $file["name"]);
            $parts = pathinfo($filename);
            $name = 'equipment-' . $itemId . '-' . $imageType . '.' . $parts['extension'];

            $success = move_uploaded_file($file['tmp_name'], UPLOAD_FOLDER . 'equipment/' . $name);
            if (!$success) {
                $data = 'An error occurred uploading a file.';
            } else {
                $data = 'ok';
            }

            chmod(UPLOAD_FOLDER . 'equipment/' . $name, 0644);

            $this->equipment->update_image($itemId, $name, $imageType, $type);
        }

        $data = array("ok" => "true", "data" => $data);

        session_write_close();
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    public function editInStock()
    {

        // $this->checkSession('json');

        $this->load->model('Equipment_Model', 'equipment');

        $id = $_POST['id'];
        $type = $_POST['type'];
        $value = $_POST['value'];
        $itemId = Crypt::enc_decrypt($id);

        $this->equipment->update_stock($itemId, $type, $value);

        $data = array("ok" => "true");

        session_write_close();
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

////////////////
// ADD EDIT
////////////////

    public function addUpdateItem()
    {

        $this->checkSession('json');

        $this->load->model('Equipment_Model', 'equipment');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $type  = $_POST['type'];
        $priceRequired = 'required';
        if ($type == 'rent') {
            $priceRequired = 'notrequired';
        }

        $validator = new GUMP();

        // Define the rules and filters
        $filters = array(
            'name'           => 'trim|sanitize_string',
            'productNumber'  => 'trim|sanitize_string',
            'categoryId'     => 'trim|sanitize_string',
            'price'          => 'trim|sanitize_string',
            'inStock'        => 'trim|sanitize_string',
            'delivery'       => 'trim|sanitize_string',
            'urgentDelivery' => 'trim|sanitize_string',
            'description'    => 'trim|sanitize_string',
            'active'         => 'trim|sanitize_string'
        );
        $rules = array(
            'name'           => 'required',
            'productNumber'  => 'required',
            'categoryId'     => 'required',
            'price'          => $priceRequired,
            'inStock'        => 'required',
            'delivery'       => 'required',
            'urgentDelivery' => 'required',
            'description'    => 'required'
        );

        $_POST = $validator->filter($_POST, $filters);
        $validated = $validator->validate($_POST, $rules);

        $errorArr = array();

        if ($validated !== true) {
            foreach ($validated as $v) {
                switch ($v['field']) {
                    case 'name':
                        $errorArr[] = "Please enter the name.";
                        break;
                    case 'productNumber':
                        $errorArr[] = "Please select the product number.";
                        break;
                    case 'categoryId':
                        $errorArr[] = "Please enter the category.";
                        break;
                    case 'price':
                        $errorArr[] = "Please enter the price.";
                        break;
                    case 'inStock':
                        $errorArr[] = "Please enter the number in stock.";
                        break;
                    case 'delivery':
                        $errorArr[] = "Please enter the delivery price.";
                        break;
                    case 'urgentDelivery':
                        $errorArr[] = "Please enter the urgent delivery price.";
                        break;
                    case 'description':
                        $errorArr[] = "Please enter the description.";
                        break;
                }
            }
        }

        if (count($errorArr) == 0):
            $uuid = Uuid::uuid4();
            
            $name = $_POST['name'];
            $productNumber = $_POST['productNumber'];
            $categoryId = $_POST['categoryId'];
            if (isset($_POST['price'])) {
                $price = $_POST['price'];
            } else {
                $price = '0.00';
            }
            $inStock = $_POST['inStock'];
            $delivery = $_POST['delivery'];
            $urgentDelivery = $_POST['urgentDelivery'];
            $description = $_POST['description'];
            $updateBy = $_SESSION['userId'];

            if(array_key_exists(7, $_SESSION['role'])) {
                $active = $_POST['active'];
            } else {
                $active = 0;
            }

            $formType = $_POST['formType'];

            if ($formType == 'add') {
                $this->equipment->add_item($type, $uuid->toString(), $name, $productNumber, $categoryId, $price, $inStock, $delivery, $urgentDelivery, $description, $active, $updateBy);
                $redirect = 'item?type=' . $type . '&id=' . Crypt::enc_encrypt($uuid->toString()) . '&mes=ts';
            } else {
                $itemId = Crypt::enc_decrypt($_POST['itemId']);
                $this->equipment->edit_item($type, $itemId, $name, $productNumber, $categoryId, $price, $inStock, $delivery, $urgentDelivery, $description, $active, $updateBy);
                $redirect = 'item?type=' . $type . '&id=' . $_POST['itemId'] . '&mes=s';
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

    public function editPricing2()
    {

        $this->checkSession('json');

        $this->load->model('Equipment_Model', 'equipment');

        $id = $_POST['itemId'];
        $itemId = Crypt::enc_decrypt($id);
        $type = $_POST['type'];
        $count = $_POST['count'];
 
        $this->equipment->delete_rent_options($itemId);

        if (isset($_POST['duration'])) {
            $duration = $_POST['duration'];
            $price = $_POST['price'];
        }
        $durationAdd = $_POST['durationAdd'];
        $priceAdd = $_POST['priceAdd'];

        if(array_key_exists(7, $_SESSION['role'])) {
            if (isset($_POST['duration'])) {
                $priority = $_POST['priority'];
            }
            $priorityAdd = $_POST['priorityAdd'];

            if (isset($duration)) {
                $count = 0;
                foreach ($duration as $key => $durationVal) {
                    if (!empty($durationVal)) {
                        $this->equipment->add_rent_option($itemId, $durationVal, $price[$count], $priority[$count]);
                   }
                   $count = $count + 1;
                }
            }

            $count = 0;
            foreach ($durationAdd as $key => $durationAddVal) {
                if (!empty($durationAddVal)) {
                    $this->equipment->add_rent_option($itemId, $durationAddVal, $priceAdd[$count], $priorityAdd[$count]);
                }
                $count = $count + 1;
            }
        } else {
            $lastPriority = 0;
            if (isset($_POST['duration'])) {
                $count2 = count($duration);
                if (isset($duration)) {
                    for ($k = 0 ; $k < $count2; $k++ ) {
                        $durationVal = $duration[$k];
                        if (!empty($durationVal)) {
                            $this->equipment->add_rent_option($itemId, $durationVal, $price[$k], $k + 1);
                            $lastPriority = $k + 1;
                        }
                    }
                }
            }

            $count3 = count($durationAdd);
            for ($j = 0 ; $j < $count3; $j++ ) {
                $durationAddVal = $durationAdd[$j];
                if (!empty($durationAddVal)) {
                    $priority = $j + $lastPriority + 1;
                    $this->equipment->add_rent_option($itemId, $durationAddVal, $priceAdd[$j], $priority);
                }
            }
        }

        $this->equipment->set_updated_by($type, $itemId, $_SESSION['userId']);

        $redirect = 'pricing?type=' . $type . '&id=' . $id . '&mes=s';

        $data = array("ok" => "true", "redirect" => $redirect);

        session_write_close();
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();     
    }

    public function editSizes2()
    {

        $this->checkSession('json');

        $this->load->model('Equipment_Model', 'equipment');

        $id = $_POST['itemId'];
        $itemId = Crypt::enc_decrypt($id);
        $type = $_POST['type'];
        $count = $_POST['count'];

        $errorArr = array();
        if (isset($_POST['size'])) {
            $size = $_POST['size'];
            $priority = $_POST['priority'];
        }
        $sizeAdd = $_POST['sizeAdd'];
        $priorityAdd = $_POST['priorityAdd'];

        $this->equipment->delete_rent_sizes($itemId);

        if(array_key_exists(7, $_SESSION['role'])) {
            if (isset($_POST['size'])) {
                $priority = $_POST['priority'];
            }
            $priorityAdd = $_POST['priorityAdd'];

            if (isset($size)) {
                $count = 0;
                foreach ($size as $key => $sizeVal) {
                    if (!empty($sizeVal)) {
                        $this->equipment->add_rent_size($itemId, $sizeVal, $priority[$count]);
                   }
                   $count = $count + 1;
                }
            }

            $count = 0;
            foreach ($sizeAdd as $key => $sizeAddVal) {
                if (!empty($sizeAddVal)) {
                    $this->equipment->add_rent_size($itemId, $sizeAddVal, $priorityAdd[$count]);
                }
                $count = $count + 1;
            }
        } else {
            $lastPriority = 0;
            if (isset($_POST['size'])) {
                $count2 = count($size);
                if (isset($size)) {
                    for ($k = 0 ; $k < $count2; $k++ ) {
                        $sizeVal = $size[$k];
                        if (!empty($sizeVal)) {
                            $this->equipment->add_rent_size($itemId, $sizeVal, $k + 1);
                            $lastPriority = $k + 1;
                        }
                    }
                }
            }

            $count3 = count($sizeAdd);
            for ($j = 0 ; $j < $count3; $j++ ) {
                $sizeAddVal = $sizeAdd[$j];
                if (!empty($sizeAddVal)) {
                    $priority = $j + $lastPriority + 1;
                    $this->equipment->add_rent_size($itemId, $sizeAddVal, $priority);
                }
            }
        }

        $this->equipment->set_updated_by($type, $itemId, $_SESSION['userId']);

        $redirect = 'sizes?type=' . $type . '&id=' . $id . '&mes=s';

        $data = array("ok" => "true", "redirect" => $redirect);

        session_write_close();
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();     
    }

    public function newUser()
    {

        $this->checkSession();

        $this->load->model('Administration_Model', 'administration');

        $getCategories = $this->administration->get_categories();
        $this->smarty->assign('getCategories', $getCategories);

        $languages = Languages::$LanguageData;
        $this->smarty->assign('languages', $languages);

        $this->smarty->assign('userData', null);
        $this->smarty->assign('newUser', true);

        $this->smarty->assign('currentPage', 'users');
        $this->smarty->assign('subPage', 'newUser');
        $this->smarty->assign('pageTitle', 'Add User');
        $this->smarty->assign('subPageJS', 'userNewEdit');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header.tpl');
        $this->smarty->display(portalapp_THEME . '/administration-user-edit.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer.tpl');
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

    function get_counter($iterations, $startAtZero, $step)
    {
        $countArray = array();
        $start = 1;
        if ($startAtZero == TRUE) {
            $start = 0;
        }
        for ($leap = $start; $leap <= $iterations; $leap = $leap + $step) {
            array_push($countArray, $leap);
        }
        return $countArray;
    }
}
