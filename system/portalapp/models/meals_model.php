<?php
class Meals_Model extends TinyMVC_Model
{
    // error_log(print_R($var,TRUE));

    function add_item($name, $categoryId, $price, $ingredients, $nutrition, $updateBy) {
        $timestamp = date('Y-m-d H:i:s');

        return $this->db->insert('mealItems', array(
            'name' => $name,
            'categoryId' => $categoryId,
            'price' => $price,
            'ingredients' => $ingredients,
            'nutritionRegular' => $nutrition,
            'updateBy' => $updateBy,
            'createOn' => $timestamp,
            'updateOn' => $timestamp
        ));
    }

    function edit_item($itemId, $name, $categoryId, $price, $ingredients, $nutrition, $updateBy) {
        $timestamp = date('Y-m-d H:i:s');

        $this->db->where('mealItemId', $itemId);

        return $this->db->update('mealItems', array(
            'name' => $name,
            'categoryId' => $categoryId,
            'price' => $price,
            'ingredients' => $ingredients,
            'nutritionRegular' => $nutrition,
            'updateBy' => $updateBy,
            'updateOn' => $timestamp
        ));
    }

    function get_meal_item_in_use($item, $week)
    {
        return $this->db->query_all('SELECT m.*, m.name as mealName, calItems.mealsCalendarItemId
            FROM mealItems m, mealsCalendarItems calItems, mealsCalendar cal
            WHERE calItems.mealItemId = ?
            AND cal.mealsCalendarId = calItems.mealsCalendarId
            AND m.mealItemId = calItems.mealItemId
            AND cal.week >= ?', array($item, $week));
    }

    function delete_meal_from_library($itemId)
    {
        $this->db->query('DELETE FROM mealItems WHERE mealItemId = ?', array($itemId));
    }

    function delete_meal_from_calendar($itemId)
    {
        $this->db->query('DELETE FROM mealsCalendarItems WHERE mealsCalendarItemId = ?', array($itemId));
    }

    function get_calendar_data($week)
    {
        return $this->db->query_all('SELECT m.*, mC.*, mC.name as categoryName, m.name as mealName, calItems.mealsCalendarItemId
            FROM mealItems m, mealCategories mC, mealsCalendarItems calItems
            LEFT JOIN mealsCalendar cal ON cal.mealsCalendarId = calItems.mealsCalendarId
            WHERE m.categoryId = mC.mealCategoryId 
            AND cal.week = ?
            AND calItems.mealItemId = m.mealItemId
            ORDER BY mC.priority, m.name', array($week));
    }

    function get_calendar($week)
    {
        return $this->db->query_one('SELECT *
            FROM mealsCalendar
            WHERE week = ?', array($week));
    }

    function get_meals_all()
    {
		return $this->db->query_one('SELECT COUNT(*) AS count FROM mealItems m, mealCategories mC WHERE m.categoryId = mC.mealCategoryId ORDER BY mC.priority, m.name');
    }

	function get_meals($limit_offset)
    {
		return $this->db->query_all('SELECT m.*, mC.*, mC.name as categoryName, m.name as mealName FROM mealItems m, mealCategories mC WHERE m.categoryId = mC.mealCategoryId ORDER BY mC.priority, m.name LIMIT ' . $limit_offset['offset'] . ',' . $limit_offset['limit']);
    }

    function get_meals_categories()
    {
        return $this->db->query_all('SELECT * FROM mealCategories ORDER BY priority');
    }

    function get_meal_item($itemId)
    {
        return $this->db->query_one('SELECT m.*, mC.*, mC.name as categoryName, m.name as mealName, adminUsers.firstName, adminUsers.lastName
        	FROM (mealItems m, mealCategories mC)
        	LEFT JOIN adminUsers ON adminUsers.userId = m.updateBy
        	WHERE m.categoryId = mC.mealCategoryId 
        	AND m.mealItemId = ?
        	ORDER BY mC.priority, m.name', array($itemId));
    }

    function update_image($itemId, $name, $imageType)
    {

        if ($imageType == 'thumbnail') {
            $field = 'thumbnail';
        } else if ($imageType == 'image') {
            $field = 'image';
        }

        
        $this->db->where('mealItemId', $itemId);

        return $this->db->update('mealItems', array(
            $field => $name
        ));
    }

    function add_meal_to_calendar($mealsCalendarId, $mealItemId)
    {
        $sql = "INSERT INTO mealsCalendarItems (mealsCalendarId, mealItemId)
            SELECT '" . $mealsCalendarId . "', '" . $mealItemId . "' FROM DUAL 
            WHERE NOT EXISTS (SELECT * FROM mealsCalendarItems 
            WHERE mealsCalendarId = " . $mealsCalendarId . " AND mealItemId = " . $mealItemId . " LIMIT 1)";

        $result = $this->db->query($sql);
        return $result;
    }

    function add_meal_calendar($week, $weekName, $updateBy)
    {
        $timestamp = date('Y-m-d H:i:s');

        return $this->db->insert('mealsCalendar', array(
            'weekName' => $weekName,
            'week' => $week,
            'updateBy' => $updateBy,
            'updateOn' => $timestamp,
            'addedOn' => $timestamp
        ));
    }
}
