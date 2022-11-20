<?php
class Equipment_Model extends TinyMVC_Model
{
    // error_log(print_R($var,TRUE));

    function set_updated_by($type, $itemUuid, $userId)
    {
        $timestamp = date('Y-m-d H:i:s');

        if ($type == 'rent') {
            $catalog = 'equipmentRentCatalog';
        } else if ($type == 'purchase') {
            $catalog = 'equipmentPurchaseCatalog';
        }

        $this->db->where('itemUuid', $itemUuid);

        return $this->db->update($catalog, array(
            'updateBy' => $userId,
            'updateOn' => $timestamp
        ));
    }

    function delete_rent_options($itemUuid)
    {
        $this->db->query('DELETE FROM equipmentRentOptions WHERE itemUuid = ?', array($itemUuid));
    }
    
    function delete_rent_sizes($itemUuid)
    {
        $this->db->query('DELETE FROM equipmentSizes WHERE itemUuid = ?', array($itemUuid));
    }

    function add_rent_size($uuid, $size, $priority) {
        return $this->db->insert('equipmentSizes', array(
            'itemUuid' => $uuid,
            'size' => $size,
            'priority' => $priority
        ));
    }

    function add_rent_option($uuid, $duration, $price, $priority) {
        return $this->db->insert('equipmentRentOptions', array(
            'itemUuid' => $uuid,
            'duration' => $duration,
            'price' => $price,
            'priority' => $priority
        ));
    }

    function delete_item($itemUuid, $type)
    {
        if ($type == 'rent') {
            $catalog = 'equipmentRentCatalog';
        } else if ($type == 'purchase') {
            $catalog = 'equipmentPurchaseCatalog';
        }

        $this->db->query('DELETE FROM ' . $catalog . ' WHERE itemUuid = ?', array($itemUuid));
    }

    function update_image($itemId, $name, $imageType, $type) {
        if ($type == 'rent') {
            $catalog = 'equipmentRentCatalog';
        } else if ($type == 'purchase') {
            $catalog = 'equipmentPurchaseCatalog';
        }

        if ($imageType == 'thumb') {
            $field = 'thumb';
        } else if ($imageType == 'main') {
            $field = 'featureImage';
        }

        $this->db->where('itemUuid', $itemId);

        return $this->db->update($catalog, array(
            $field => $name
        ));
    }

    function update_stock($itemId, $type, $value) {
        if ($type == 'rent') {
            $catalog = 'equipmentRentCatalog';
        } else if ($type == 'purchase') {
            $catalog = 'equipmentPurchaseCatalog';
        }

        $this->db->where('itemUuid', $itemId);

        return $this->db->update($catalog, array(
            'inStock' => $value
        ));
    }

    function add_item($type, $uuid, $name, $productNumber, $categoryId, $price, $inStock, $delivery, $urgentDelivery, $description, $active, $updateBy) {
        if ($type == 'rent') {
            $catalog = 'equipmentRentCatalog';
        } else if ($type == 'purchase') {
            $catalog = 'equipmentPurchaseCatalog';
        }

        $timestamp = date('Y-m-d H:i:s');

        return $this->db->insert($catalog, array(
            'itemUuid' => $uuid,
            'name' => $name,
            'productNumber' => $productNumber,
            'categoryId' => $categoryId,
            'price' => $price,
            'inStock' => $inStock,
            'delivery' => $delivery,
            'rushDelivery' => $urgentDelivery,
            'description' => $description,
            'active' => $active,
            'priority' => 0,
            'updateBy' => $updateBy,
            'createOn' => $timestamp,
            'updateOn' => $timestamp
        ));
    }

    function edit_item($type, $uuid, $name, $productNumber, $categoryId, $price, $inStock, $delivery, $urgentDelivery, $description, $active, $updateBy) {
        if ($type == 'rent') {
            $catalog = 'equipmentRentCatalog';
        } else if ($type == 'purchase') {
            $catalog = 'equipmentPurchaseCatalog';
        }

        $timestamp = date('Y-m-d H:i:s');

        $this->db->where('itemUuid', $uuid);

        return $this->db->update($catalog, array(
            'itemUuid' => $uuid,
            'name' => $name,
            'productNumber' => $productNumber,
            'categoryId' => $categoryId,
            'price' => $price,
            'inStock' => $inStock,
            'delivery' => $delivery,
            'rushDelivery' => $urgentDelivery,
            'description' => $description,
            'active' => $active,
            'priority' => 0,
            'updateBy' => $updateBy,
            'updateOn' => $timestamp
        ));
    }

    function get_equipment_rent_all()
    {
      return $this->db->query_one('SELECT count(*) AS count FROM equipmentRentCatalog');
    }

    function get_equipment_rent($limit_offset)
    {
        $sql = "SELECT eRc.*, eR.name as categoryName
            FROM equipmentRentCatalog eRc, equipmentRent eR
            WHERE eRc.categoryId = eR.categoryId
            ORDER BY eR.priority, eRc.priority
            LIMIT " . $limit_offset['offset'] . "," . $limit_offset['limit'] . "";
        $result = $this->db->query_all($sql);
        return $result;
    }

    function get_equipment_purchase_all()
    {
      return $this->db->query_one('SELECT count(*) AS count FROM equipmentPurchaseCatalog');
    }

    function get_equipment_purchase($limit_offset)
    {
        $sql = "SELECT ePc.*, eP.name as categoryName
            FROM equipmentPurchaseCatalog ePc, equipmentPurchase eP
            WHERE ePc.categoryId = eP.categoryId
            ORDER BY eP.priority, ePc.priority
            LIMIT " . $limit_offset['offset'] . "," . $limit_offset['limit'] . "";
        $result = $this->db->query_all($sql);
        return $result;
    }

    function get_equipment_rent_item($itemId)
    {
        return $this->db->query_one('SELECT equipmentRentCatalog.*, equipmentRent.name as categoryName, adminUsers.firstName, adminUsers.lastName
            FROM (equipmentRentCatalog, equipmentRent)
            LEFT JOIN adminUsers ON adminUsers.userId = equipmentRentCatalog.updateBy
            WHERE equipmentRentCatalog.categoryId = equipmentRent.categoryId 
            AND equipmentRentCatalog.itemUuid = ?', array($itemId));
    }

    function get_equipment_rent_options($itemId)
    {
        return $this->db->query_all('SELECT *
            FROM equipmentRentOptions
            WHERE itemUuid = ?
            ORDER BY priority', array($itemId));
    }

    function get_equipment_rent_sizes($itemId)
    {
        return $this->db->query_all('SELECT *
            FROM equipmentSizes
            WHERE itemUuid = ?
            ORDER BY priority', array($itemId));
    }

    function get_equipment_purchase_item($itemId)
    {
        return $this->db->query_one('SELECT equipmentPurchaseCatalog.*, equipmentPurchase.name as categoryName, adminUsers.firstName, adminUsers.lastName
            FROM (equipmentPurchaseCatalog, equipmentPurchase)
            LEFT JOIN adminUsers ON adminUsers.userId = equipmentPurchaseCatalog.updateBy
            WHERE equipmentPurchaseCatalog.categoryId = equipmentPurchase.categoryId 
            AND equipmentPurchaseCatalog.itemUuid = ?', array($itemId));
    }

    function get_equipment_categories()
    {
        return $this->db->query_all('SELECT categoryId, name
            FROM equipmentRent
            ORDER BY priority');
    }
}
