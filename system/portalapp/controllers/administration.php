<?php
class Administration_Controller extends App_Controller
{
    // error_log(print_R($var,TRUE));

    function getUsers()
    {
        $this->checkSession('json');
        $this->load->model('Administration_Model', 'administration');
        $data = $this->administration->get_all_users();
        echo json_encode($data);
        exit();
    }

    function getUsersAutoComplete()
    {
        $this->checkSession('json');
        $this->load->model('Administration_Model', 'administration');
        $data = $this->administration->get_all_users_autocomplete();
        echo json_encode($data);
        exit();
    }

    function getUsersPushAutoComplete()
    {
        $this->checkSession('json');
        $this->load->model('Administration_Model', 'administration');
        $data = $this->administration->get_all_push_users_autocomplete();
        echo json_encode($data);
        exit();
    }
 
    function remove()
    {
        $this->checkSession('json');

        $errorArr = array();

        if ($_GET['type'] == 'equipment') {
            $this->load->model('Equipment_Model', 'equipment');

            $id = $_GET['id'];
            $equipmentType = $_GET['equipmentType'];
            $itemUuid = Crypt::enc_decrypt($id);

            if ($equipmentType == 'rent') {
                $this->equipment->delete_rent_options($itemUuid);
                $this->equipment->delete_rent_sizes($itemUuid);
            }
            $this->equipment->delete_item($itemUuid, $equipmentType);

            $redirect = 'equipment?type=' . $equipmentType . '&mes=r';
        } else if ($_GET['type'] == 'users') {

            $this->load->model('Administration_Model', 'administration');

            $id = $_GET['id'];

            $itemUuid = Crypt::enc_decrypt($id);

            $this->administration->delete_user($itemUuid);

            $redirect = 'users';

        } else if ($_GET['type'] == 'usersPurchases') {

            $this->load->model('Administration_Model', 'administration');

            $id = $_GET['id'];

            $itemUuid = Crypt::enc_decrypt($id);

            $this->administration->delete_purchase($itemUuid);

            $redirect = 'users/usersPurchases?id=' . $itemUuid;


        } else if ($_GET['type'] == 'caregivers') {

            $this->load->model('Administration_Model', 'administration');

            $id = $_GET['id'];

            $itemUuid = Crypt::enc_decrypt($id);

            $this->administration->delete_user($itemUuid);

            $redirect = "caregivers";

        } else if ($_GET['type'] == 'personalCare') {

            $this->load->model('Administration_Model', 'administration');

            $id = $_GET['id'];

            $itemUuid = Crypt::enc_decrypt($id);

            $this->administration->delete_user($itemUuid);

            $redirect = "personalCareWorkers";

        } else if ($_GET['type'] == 'promoCodes') {

            $this->load->model('Administration_Model', 'administration');

            $id = $_GET['id'];

            $itemUuid = Crypt::enc_decrypt($id);

            $this->administration->delete_promoCodes($itemUuid);

            $redirect = 'promoCodes';

        } else if ($_GET['type'] == 'adminUsers') {

            $this->load->model('Administration_Model', 'administration');

            $id = $_GET['id'];

            $itemUuid = Crypt::enc_decrypt($id);

            $this->administration->delete_adminUsers($itemUuid);

            $redirect = 'adminUsers';

        } else if ($_GET['type'] == 'purchases') {

            $this->load->model('Administration_Model', 'administration');

            $id = $_GET['id'];

            $itemUuid = Crypt::enc_decrypt($id);

            $this->administration->delete_purchase($itemUuid);

            $redirect = 'purchases';

        } else if ($_GET['type'] == 'meals') {
            $this->load->model('Meals_Model', 'meals');

            $week = $_GET['week'];
            $id = trim(htmlentities($_GET['id']));
            $item = Crypt::enc_decrypt($id);

            $this->meals->delete_meal_from_calendar($item);

            $redirect = 'meals/calendar?mes=r&next=' . $week;
        } else if ($_GET['type'] == 'mealLibrary') {
            $this->load->model('Meals_Model', 'meals');

            $week = $_GET['week'];
            $id = trim(htmlentities($_GET['id']));
            $item = Crypt::enc_decrypt($id);

            $getMealsInUse = $this->meals->get_meal_item_in_use($item, $week);
            if (empty($getMealsInUse)) {
                $this->meals->delete_meal_from_library($item);
                $redirect = 'meals?mes=r';
            } else {
                $redirect = 'meals?mes=i';
            }
        }

        if (count($errorArr) == 0):
            $data = array("ok" => "true", "redirect" => TMVC_URL . $redirect);

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
