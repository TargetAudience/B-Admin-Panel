<?php
require_once(TMVC_BASEDIR . 'portalapp/libs/Mail.php');
require_once(TMVC_BASEDIR . 'portalapp/libs/Languages.php');
require_once(TMVC_BASEDIR . '../vendor/autoload.php');

use Ramsey\Uuid\Uuid;

class Meals_Controller extends App_Controller
{
    // error_log(print_R($var,TRUE));

    public function item()
    {
        $this->checkSession();

        $this->load->model('Meals_Model', 'meals');
        
        $successMessage = '';
        if (isset($_GET['mes'])) {
            $messageCode = $_GET['mes'];
            if ($messageCode == 's') {
                $successMessage = 'The meal has been updated.';
            } else if ($messageCode == 'ts') {
                $successMessage = 'The meal has been added.';
            }
        }

        $id = $_GET['id'];
        $itemId = Crypt::enc_decrypt($id);

        $mealData = $this->meals->get_meal_item($itemId);

        $mealData['createOn'] = date('M j, Y', strtotime($mealData['createOn']));
        if ($mealData['updateOn']) {
            $updateOn = date('M j, Y', strtotime($mealData['updateOn']));
            $mealData['lastUpdate'] = $updateOn . ' by ' . $mealData['firstName'] . ' ' . $equipmentData['lastName'];
        } else {
            $mealData['lastUpdate'] = '-';
        }

        $this->smarty->assign('mealData', $mealData);

        $this->smarty->assign('mealItemIdEncoded', $id);

        $this->smarty->assign('successMessage', $successMessage);
        $this->smarty->assign('currentPage', 'meals');
        $this->smarty->assign('subPage', 'details');
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/meals-item.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function newMeal()
    {
        $this->checkSession();

        $this->load->model('Meals_Model', 'meals');

        $mealsCategories = $this->meals->get_meals_categories();

        $this->smarty->assign('mealsCategories', $mealsCategories);

        $this->smarty->assign('currentPage', 'meals');
        $this->smarty->assign('subPage', 'meals');
        $this->smarty->assign('pageTitle', 'Meals');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/meals-new.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function index()
    {
        $this->checkSession();

        $successMessage = '';
        if (isset($_GET['mes'])) {
            $messageCode = $_GET['mes'];
            if ($messageCode == 'r') {
                $successMessage = 'The meal has been removed.';
            } else if ($messageCode == 'i') {
                $successMessage = 'Sorry! This meal exists in the calendar.';
            }
        }

        $this->load->model('Meals_Model', 'meals');

        $per_page = 50;
        if (isset($_GET['page'])) {
            $page_number = $_GET['page'];
        } else {
            $page_number = 1;
        }

        $userDataCount = $this->meals->get_meals_all();
        $pagination = $this->getPagination($per_page, $page_number, $userDataCount['count']);

        $mealsData = $this->meals->get_meals($pagination);

        foreach ($mealsData as &$item) {
            $encode = Crypt::enc_encrypt($item['mealItemId']);
            $item['mealItemIdEncoded'] = $encode;
        }

        $dia = date ("d");
        $mes = date ("n");
        $ano = date ("Y");
        $date_timestamp = strtotime($ano . "-" . $mes . "-" . $dia);
        $previous_week = strtotime("+1 day");
        $start_week = strtotime("last monday midnight", $previous_week);

        $week = date("Y-m-d", $start_week);

        $this->smarty->assign('mealsData', $mealsData);
        $this->smarty->assign('page_nums', $pagination);
        $this->smarty->assign('week', $week);

        $this->smarty->assign('successMessage', $successMessage);
        $this->smarty->assign('currentPage', 'meals');
        $this->smarty->assign('subPage', 'meals');
        $this->smarty->assign('pageTitle', 'Meals');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/meals.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function image()
    {
        // 2 => Meals, 7 => Admin
        if (!array_key_exists(7, $_SESSION['role']) && !array_key_exists(2, $_SESSION['role'])) {
            exit();
        }

        $this->checkSession();

        $this->load->model('Meals_Model', 'meals');

        $id = $_GET['id'];
        $itemId = Crypt::enc_decrypt($id);

        $mealData = $this->meals->get_meal_item($itemId);

        $this->smarty->assign('mealData', $mealData);

        $this->smarty->assign('mealItemIdEncoded', $id);

        $this->smarty->assign('currentPage', 'meals');
        $this->smarty->assign('subPage', 'image');
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/meals-image.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

////////////////
// EDITS
////////////////

    public function editMeal()
    {
        $this->checkSession();

        $this->load->model('Meals_Model', 'meals');

        $id = $_GET['id'];
        $itemId = Crypt::enc_decrypt($id);

        $mealData = $this->meals->get_meal_item($itemId);

        $mealData['createOn'] = date('M j, Y', strtotime($mealData['createOn']));
        if ($mealData['updateOn']) {
            $updateOn = date('M j, Y', strtotime($mealData['updateOn']));
            $mealData['lastUpdate'] = $updateOn . ' by ' . $mealData['firstName'] . ' ' . $equipmentData['lastName'];
        } else {
            $mealData['lastUpdate'] = '-';
        }

        $mealsCategories = $this->meals->get_meals_categories();

        $this->smarty->assign('mealData', $mealData);
        $this->smarty->assign('mealsCategories', $mealsCategories);

        $this->smarty->assign('mealItemIdEncoded', $id);

        $this->smarty->assign('currentPage', 'meals');
        $this->smarty->assign('subPage', 'details');
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/meal-item-edit.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

////////////////
// ADD EDIT
////////////////

    public function addUpdateItem()
    {
        $this->checkSession('json');

        $this->load->model('Meals_Model', 'meals');

        require_once(TMVC_BASEDIR . 'portalapp/libs/gump.class.php');

        $validator = new GUMP();

        // Define the rules and filters
        $filters = array(
            'name'           => 'trim|sanitize_string',
            'categoryId'     => 'trim|sanitize_string',
            'price'          => 'trim|sanitize_string',
            'ingredients'    => 'trim|sanitize_string',
            'nutrition'      => 'trim|sanitize_string'
        );
        $rules = array(
            'name'           => 'required',
            'categoryId'     => 'required',
            'price'          => 'required',
            'ingredients'    => 'required',
            'nutrition'      => 'required'
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
                    case 'categoryId':
                        $errorArr[] = "Please enter the category.";
                        break;
                    case 'price':
                        $errorArr[] = "Please enter the price.";
                        break;
                    case 'ingredients':
                        $errorArr[] = "Please enter the ingredients.";
                        break;
                    case 'nutrition':
                        $errorArr[] = "Please enter the nutrition information.";
                        break;
                }
            }
        }

        if (count($errorArr) == 0):
            $uuid = Uuid::uuid4();
            
            $name = $_POST['name'];
            $categoryId = $_POST['categoryId'];
            $price = $_POST['price'];
            $ingredients = $_POST['ingredients'];
            $nutrition = $_POST['nutrition'];
            $updateBy = $_SESSION['userId'];

            $formType = $_POST['formType'];

            if ($formType == 'add') {
                $insertId = $this->meals->add_item($name, $categoryId, $price, $ingredients, $nutrition, $updateBy);
                $redirect = 'item?id=' . Crypt::enc_encrypt($insertId) . '&mes=ts';
            } else {
                $itemId = Crypt::enc_decrypt($_POST['itemId']);
                $this->meals->edit_item($itemId, $name, $categoryId, $price, $ingredients, $nutrition, $updateBy);
                $redirect = 'item?id=' . $_POST['itemId'] . '&mes=s';
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

    public function addMealsToWeek2()
    {
        $this->checkSession('json');

        $this->load->model('Meals_Model', 'meals');

        $errorArr = array();

        $week = $_POST['weekUrlParam'];
        $weekName = $_POST['weekName'];
        $updateBy = $_SESSION['userId'];

        if (isset($_POST['meal'])) {
            $meals = $_POST['meal'];

            $getMealsCalendar = $this->meals->get_calendar($week);

            if (empty($getMealsCalendar)) {
                $mealsCalendarId = $this->meals->add_meal_calendar($week, $weekName, $updateBy);
            } else {
                $mealsCalendarId = $getMealsCalendar['mealsCalendarId'];
            }

            foreach ($meals as $key => $meal) {
                $mealId = Crypt::enc_decrypt($meal);
                $insertId = $this->meals->add_meal_to_calendar($mealsCalendarId, $mealId);
            }

            $redirect = 'calendar?next=' . $week . '&mes=s';

            $data = array("ok" => "true", "redirect" => $redirect);
        } else {
            $errorArr[] = 'Please select at least one meal item';

            $data = array("ok" => "false", "title" => "Oops!", "content" => json_encode($errorArr));
        }

        session_write_close();
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    public function editImage()
    {
        $this->checkSession();

        $this->load->model('Meals_Model', 'meals');

        $id = $_GET['id'];
        $itemId = Crypt::enc_decrypt($id);

        $mealData = $this->meals->get_meal_item($itemId);

        $this->smarty->assign('mealData', $mealData);

        $this->smarty->assign('mealItemIdEncoded', $id);

        $this->smarty->assign('currentPage', 'meals');
        $this->smarty->assign('subPage', 'image');
        $this->smarty->assign('pageTitle', '');
        $this->smarty->assign('subPageJS', '');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/meals-image-edit.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function imageUploadMeals()
    {

        ini_set('display_errors',1);
error_reporting(E_ALL);

        $this->checkSession();

        $this->load->model('Meals_Model', 'meals');

        $file = array_shift($_FILES);
        $fileSize = $file['size'];

        if ($fileSize > 5242870) {
            $data = 'The image you are trying to upload is too large in size.';
        } else if (!empty($file)) {
            $itemId = Crypt::enc_decrypt($_GET['id']);
            $imageType = $_GET['imageType'];

            if ($file['error'] !== UPLOAD_ERR_OK) {
                $data = 'An error occurred uploading the file.';
            }

            if (!is_dir(UPLOAD_FOLDER . 'meals')) {
                mkdir(UPLOAD_FOLDER . 'meals', 0777);
            }

            $mealData = $this->meals->get_meal_item($itemId);

            if ($imageType == 'thumbnail') {
                if (!empty($mealData['thumbnail'])) {
                    $oldFile = UPLOAD_FOLDER . 'meals/' . $mealData['thumbnail'];
                    if(unlink($oldFile)) {}
                }
            } else if ($imageType == 'image') {
                if (!empty($mealData['image'])) {
                    $oldFile = UPLOAD_FOLDER . 'meals/' . $mealData['image'];
                    if(unlink($oldFile)) {}
                }
            }

            $filename = preg_replace("/[^A-Z0-9._-]/i", "_", $file["name"]);
            $parts = pathinfo($filename);
            $name = 'meals-' . $itemId . '-' . $imageType . '.' . $parts['extension'];

            $success = move_uploaded_file($file['tmp_name'], UPLOAD_FOLDER . 'meals/' . $name);
            if (!$success) {
                $data = 'An error occurred uploading a file.';
            } else {
                $data = 'ok';
            }

            chmod(UPLOAD_FOLDER . 'meals/' . $name, 0644);

            $this->meals->update_image($itemId, $name, $imageType);
        }

        $data = array("ok" => "true", "data" => $data);

        session_write_close();
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    public function calendar()
    {
        $this->checkSession();

        $successMessage = '';
        if (isset($_GET['mes'])) {
            $messageCode = $_GET['mes'];
            if ($messageCode == 's') {
                $successMessage = 'The meal(s) have been added to this week.';
            } else if ($messageCode == 'r') {
                $successMessage = 'The meal has been removed from this week.';
            }
        }

        $this->load->model('Meals_Model', 'meals');

        if (isset($_GET["prev"])) {
            $date_timestamp = strtotime($_GET["prev"]);
            $previous_week = strtotime("-1 week +1 day", $date_timestamp);
            $start_week = strtotime("last monday midnight", $previous_week);
            $end_week = strtotime("next monday", $start_week);
            $end_week_display = strtotime("next sunday", $start_week);
        } else if (isset($_GET["next"])) {
            $date_timestamp = strtotime($_GET["next"]);
            $start_week = $date_timestamp;
            $end_week = strtotime("next monday",$date_timestamp);
            $end_week_display = strtotime("next sunday", $date_timestamp);
        } else {
            $dia = date ("d");
            $mes = date ("n");
            $ano = date ("Y");
            $date_timestamp = strtotime($ano . "-" . $mes . "-" . $dia);
            $previous_week = strtotime("+1 day");
            $start_week = strtotime("last monday midnight",$previous_week);
            $end_week = strtotime("next monday",$start_week);
            $end_week_display = strtotime("next sunday", $start_week);
        }

        $startWeek = date("Y-m-d", $start_week);
        $endWeek = date("Y-m-d", $end_week);

        $startDisplay = date("l, M j, Y", $start_week);
        $endDisplay = date("l, M j, Y", $end_week_display);

        $buttons = array();
        $buttons['prev'] = $startWeek;
        $buttons['next'] = $endWeek;

        $calendarData = $this->meals->get_calendar_data($startWeek);

        foreach ($calendarData as &$item) {
            error_log(print_R($item,TRUE));

            $encode = Crypt::enc_encrypt($item['mealsCalendarItemId']);
            $item['mealsCalendarItemIdEncoded'] = $encode;
        }

        $this->smarty->assign('calendarData', $calendarData);

        $this->smarty->assign('buttons', $buttons);
        $this->smarty->assign('startDisplay', $startDisplay);
        $this->smarty->assign('endDisplay', $endDisplay);

        $this->smarty->assign('weekUrlParam', $startWeek);

        $this->smarty->assign('successMessage', $successMessage);
        $this->smarty->assign('currentPage', 'meals');
        $this->smarty->assign('subPage', 'calendar');
        $this->smarty->assign('pageTitle', 'Meals');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/meals-calendar.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
    }

    public function addMealsToWeek()
    {
        $this->checkSession();

        $this->load->model('Meals_Model', 'meals');

        $weekUrlParam = $_POST['weekUrlParam'];
        $date_timestamp = strtotime($weekUrlParam);
        $end_week_display = strtotime("next sunday", $date_timestamp);

        $weekDisplay = date("l, M j, Y", $date_timestamp);
        $endDisplay = date("l, M j, Y", $end_week_display);

        $mealsData = $this->meals->get_meals();

        foreach ($mealsData as &$item) {
            $encode = Crypt::enc_encrypt($item['mealItemId']);
            $item['mealItemIdEncoded'] = $encode;
        }

        $this->smarty->assign('mealsData', $mealsData);
        $this->smarty->assign('weekUrlParam', $weekUrlParam);
        $this->smarty->assign('weekDisplay', $weekDisplay);
        $this->smarty->assign('endDisplay', $endDisplay);

        $this->smarty->assign('currentPage', 'meals');
        $this->smarty->assign('subPage', 'calendar');
        $this->smarty->assign('pageTitle', 'Calendar');
        $this->smarty->assign('session', $_SESSION);
        $this->smarty->display(portalapp_THEME . '/page_meta.tpl');
        $this->smarty->display(portalapp_THEME . '/page_header_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/meals-add-to-week.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_inside.tpl');
        $this->smarty->display(portalapp_THEME . '/page_footer_meta.tpl');
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


/*
$date_string = "2012-10-18";
echo "Weeknummer: " . date("W", strtotime($date_string));
*/

