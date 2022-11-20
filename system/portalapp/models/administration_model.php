<?php
class Administration_Model extends TinyMVC_Model
{
    //error_log(print_R($validated,TRUE));

    function update_password($userId, $newPassword)
    {
        $this->db->where('userId', $userId);

        return $this->db->update('users', array(
            'passwordHash'  => $newPassword
        ));
    }

    function delete_user($itemUuid)
    {
        $this->db->query('DELETE FROM users WHERE userId = ?', array($itemUuid));
    }

    function delete_promoCodes($itemUuid)
    {
        $this->db->query('DELETE FROM promoCodes WHERE promoCodeId = ?', array($itemUuid));
    }

    function delete_adminUsers($itemUuid)
    {
        $this->db->query('DELETE FROM adminUsers WHERE userId = ?', array($itemUuid));
    }

    function delete_purchase($itemUuid)
    {
        $this->db->query('DELETE FROM purchases WHERE purchaseId = ?', array($itemUuid));
    }

    function get_users_registered($limit_offset)
    {
        $sql = "SELECT *
            FROM users
            WHERE role = 'patient'
            ORDER BY createOn
            LIMIT " . $limit_offset['offset'] . "," . $limit_offset['limit'] . "";
        $result = $this->db->query_all($sql);
        return $result;
    }

    function get_all_users()
    {
        $sql = "SELECT * FROM users";
        $results = $this->db->query_all($sql);
        return $results;
    }

    function get_all_users_autocomplete()
    {
        $sql = "SELECT userId, firstName, lastName FROM users WHERE role = 'patient'";
        $results = $this->db->query_all($sql);
        return $results;
    }

    function get_all_push_users_autocomplete()
    {
        $sql = "SELECT userId, firstName, lastName FROM users WHERE role = 'patient' AND pushToken != '' AND pushNotifications = 1";
        $results = $this->db->query_all($sql);
        return $results;
    }
  
    function get_all_verticals()
    {
        $sql = "SELECT DISTINCT verticalFriendly, vertical FROM purchases";
        $results = $this->db->query_all($sql);
        return $results;
    }
    
    function get_users_registered_caregivers($limit_offset)
    {
        $sql = "SELECT *
            FROM users
            WHERE role = 'caregivers'
            ORDER BY createOn
            LIMIT " . $limit_offset['offset'] . "," . $limit_offset['limit'] . "";
        $result = $this->db->query_all($sql);
        return $result;
    }

    function get_all_purchases($limit_offset)
    {
        $sql = "SELECT * FROM purchases
                LIMIT " . $limit_offset['offset'] . "," . $limit_offset['limit'] . "";
        $result = $this->db->query_all($sql);
        return $result;
    }

    function get_all_purchases_filtered($limit_offset, $vertical)
    {
        $sql = "SELECT * FROM purchases WHERE vertical = '" . $vertical . "'
                LIMIT " . $limit_offset['offset'] . "," . $limit_offset['limit'] . "";
        $result = $this->db->query_all($sql);
        return $result;
    }

    function get_all_user_purchases($id)
    {
        $sql = "SELECT * FROM purchases WHERE userId = " . $id;
        $result = $this->db->query_all($sql);
        return $result;
    }

    function get_all_purchases_details($id)
    {
        $sql = "SELECT *, CASE WHEN vertical = 'meals' THEN (SELECT name from mealsCarts WHERE purchaseId = "  . $id . ") ELSE CASE WHEN vertical = 'equipment' THEN (SELECT CONCAT(name, ' - ', CONCAT(UCASE(MID(type,1,1)),MID(type,2)), ' ', nickname) from equipmentCarts WHERE purchaseId = "  . $id . ") ELSE CASE WHEN vertical = 'caregivers' THEN (SELECT name from bookCaregiverCarts WHERE purchaseId = "  . $id . ") ELSE 'Transporation' END END END AS 'purchaseName' FROM purchases as p WHERE purchaseId = "  . $id;
        $result = $this->db->query_one($sql);
        return $result;
    }

    function get_all_promoCodes()
    {
        $sql = "SELECT * FROM promoCodes pc LEFT JOIN users u ON pc.specificUserId = u.userId";
        $result = $this->db->query_all($sql);
        return $result;
    }

    function get_users_registered_personal_care_workers($limit_offset)
    {
        $sql = "SELECT *
            FROM users
            WHERE role = 'provider'
            AND subRole = 'personalCare'
            ORDER BY createOn
            LIMIT " . $limit_offset['offset'] . "," . $limit_offset['limit'] . "";
        $result = $this->db->query_all($sql);
        return $result;
    }

    function get_users_admin($limit_offset)
    {
        $sql = "SELECT au.userId, 
        au.emailAddress, 
        au.passwordHash, 
        au.firstName, 
        au.lastName, 
        GROUP_CONCAT(' ', ar.`name`) AS `role`, 
        au.loginCount, 
        au.lastLogin, 
        au.dateCreated, 
        au.passwordResetToken
        FROM adminusers au
        LEFT JOIN adminusersroles aur ON au.userId = aur.userId
        LEFT JOIN adminroles ar ON aur.roleId = ar.id
        GROUP BY au.userId
        ORDER BY dateCreated
        LIMIT " . $limit_offset['offset'] . "," . $limit_offset['limit'] . "";
        $result = $this->db->query_all($sql);
        return $result;
    }

    function get_users_visitors($limit_offset)
    {
        $sql = "SELECT *
            FROM users
            WHERE createOn IS NULL
            ORDER BY createOn
            LIMIT " . $limit_offset['offset'] . "," . $limit_offset['limit'] . "";
        $result = $this->db->query_all($sql);
        return $result;
    }

    function get_users_registered_all()
    {
      return $this->db->query_one("SELECT count(*) AS count FROM users WHERE role = 'patient'");
    }

    function get_users_registered_caregivers_all()
    {
      return $this->db->query_one("SELECT count(*) AS count FROM users WHERE role = 'caregivers'");
    }

    function get_all_purchases_all()
    {
      return $this->db->query_one("SELECT count(*) AS count FROM purchases");
    }

    function get_all_purchases_filtered_all($vertical)
    {
      return $this->db->query_one("SELECT count(*) AS count FROM purchases WHERE vertical = '" . $vertical . "'");
    }

    function get_users_registered_personal_care_workers_all()
    {
      return $this->db->query_one("SELECT count(*) AS count FROM users WHERE role = 'provider' AND subRole = 'personalCare'");
    }

    function get_users_admin_all()
    {
      return $this->db->query_one("SELECT count(*) AS count FROM adminUsers");
    }

    function get_users_visitors_all()
    {
      return $this->db->query_one('SELECT count(*) AS count FROM users WHERE createOn IS NULL');
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

    function get_personal_care_workers_detail($id)
    {
      return $this->db->query_one('SELECT * FROM purchases WHERE vertical = "personalcare" AND purchaseId = ' . $id);
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
        $sql = "SELECT eRc.*, eR.name as categoryName, eRO.*
            FROM equipmentRentCatalog eRc, equipmentRent eR
            LEFT JOIN equipmentRentOptions eRO on eRO.itemUuid = eRc.itemUuid
            WHERE eRc.categoryId = eR.categoryId
            AND eRc.itemUuid = '" . $itemId . "'";
        $result = $this->db->query_one($sql);
        return $result;
    }

    function get_equipment_purchase_item($itemId)
    {
        $sql = "SELECT ePc.*, eP.name as categoryName
            FROM equipmentPurchaseCatalog ePc, equipmentPurchase eP
            WHERE ePc.categoryId = eP.categoryId
            ORDER BY eP.priority, ePc.priority
            LIMIT " . $limit_offset['offset'] . "," . $limit_offset['limit'] . "";
        $result = $this->db->query_all($sql);
        return $result;
    }




    function update_call($call_id, $call_status)
    {
        $this->db->where('call_id', $call_id);

        return $this->db->update('calls', array(
            'call_status' => $call_status
        ));
    }

    function get_call_by_id($call_id)
    {
        return $this->db->query_one('SELECT * from calls WHERE call_id=?', array(
            $call_id
        ));
    }

    function get_review($reviewId)
    {
        return $this->db->query_one("
            SELECT r.*, (SELECT CONCAT(u2.first_name, ' ', u2.last_name) FROM users u2 WHERE r.user_id_buyer = u2.user_id) personName, (SELECT CONCAT(u3.first_name, ' ', u3.last_name) FROM users u3 WHERE r.user_id_seller = u3.user_id) sellerName
            FROM
            reviews r
            WHERE r.rating_id=?
            ", array($reviewId));
    }

    function get_user_reviews($userId)
    {
        return $this->db->query_all("
            SELECT r.*, (SELECT CONCAT(u2.first_name, ' ', u2.last_name) FROM users u2 WHERE r.user_id_buyer = u2.user_id) personName
            FROM
            users u, reviews r
            WHERE u.user_id=?
            AND r.user_id_seller = u.user_id
            ", array($userId));
    }

    function get_categories()
    {
        return $this->db->query_all('SELECT category_id, name FROM categories ORDER BY category_id');
    }


    function delete_call($callId)
    {
        $this->db->query('DELETE FROM calls WHERE call_id=?', array($callId));
    }

    function delete_review($reviewId)
    {
        $this->db->query('DELETE FROM reviews WHERE rating_id=?', array($reviewId));
    }

    function deleteUser($userId)
    {
        $this->db->query('DELETE FROM users WHERE user_id=?', array($userId));
    }

    function get_schedule($userId)
    {
        $sql = "SELECT schedule_id, day, start_time, end_time
            FROM schedule
            WHERE user_id = '" . $userId . "'
            ";
        $result = $this->db->query_all($sql);
        return $result;
    }

    function get_user($userId)
    {
        return $this->db->query_one('SELECT * from users WHERE userId = ' . $userId);
    }

    function get_user_profile($userId)
    {
        return $this->db->query_all('SELECT * from users WHERE userId = ' . $userId);
    }

    function getPurchaseVerticals()
    {
        return $this->db->query_all("SELECT DISTINCT vertical, verticalFriendly FROM purchases");
    }

    function create_user($uuid, $first_name, $last_name, $email, $primaryCarePerson, $street, $city, $province, $postalCode, $phoneNumber, $additionalPhoneNumber, $alternateContactName, $password) {

        $timestamp = date("Y-m-d H:i:s");

        return $this->db->insert('users', array(
            'firstName' => $first_name,
            'lastName' => $last_name,
            'emailAddress' => $email,
            'accountHolder' => $primaryCarePerson,
            'street' => $street,
            'city' => $city,
            'province' => $province,
            'postalCode' => $postalCode,
            'phoneNumber' => $phoneNumber,
            'additionalPhoneNumber' => $additionalPhoneNumber,
            'alternateContactName' => $alternateContactName,
            'password' => $password
        ));
    }

    function create_admin_user($first_name, $last_name, $email, $roles, $password) {

        $timestamp = date("Y-m-d H:i:s");

        $userId = $this->db->insert('adminUsers', array(
            'firstName' => $first_name,
            'lastName' => $last_name,
            'emailAddress' => $email,
            'passwordHash' => $password,
            'dateCreated' => $timestamp
        ));

        // Inserting new roles
        $sql = "INSERT IGNORE INTO adminusersroles (userId, roleId) VALUES ";
        $insertValues = [];
        foreach($roles as $role) {
            $insertValues[] = "($userId, $role)";
        }
        $sql .= implode(",", $insertValues);
        $this->db->query($sql);

        return $userId;
    }

    function create_caregiver($first_name, $last_name, $email, $primaryCarePerson, $street, $city, $province, $postalCode, $phoneNumber, $additionalPhoneNumber, $alternateContactName) {

        $timestamp = date("Y-m-d H:i:s");

        return $this->db->insert('users', array(
            'firstName' => $first_name,
            'lastName' => $last_name,
            'emailAddress' => $email,
            'accountHolder' => $primaryCarePerson,
            'street' => $street,
            'city' => $city,
            'province' => $province,
            'postalCode' => $postalCode,
            'phoneNumber' => $phoneNumber,
            'additionalPhoneNumber' => $additionalPhoneNumber,
            'alternateContactName' => $alternateContactName,
            'role' => 'caregivers',
            'createOn' => $timestamp
        ));
    }

    function create_personalCareWorker($first_name, $last_name, $email, $primaryCarePerson, $street, $city, $province, $postalCode, $phoneNumber, $additionalPhoneNumber, $alternateContactName) {

        $timestamp = date("Y-m-d H:i:s");

        return $this->db->insert('users', array(
            'firstName' => $first_name,
            'lastName' => $last_name,
            'emailAddress' => $email,
            'accountHolder' => $primaryCarePerson,
            'street' => $street,
            'city' => $city,
            'province' => $province,
            'postalCode' => $postalCode,
            'phoneNumber' => $phoneNumber,
            'additionalPhoneNumber' => $additionalPhoneNumber,
            'alternateContactName' => $alternateContactName,
            'role' => 'provider',
            'subRole' => 'personalCare',
            'createOn' => $timestamp
        ));
    }

    function update_user($uuid, $userId, $first_name, $last_name, $email, $primaryCarePerson, $street, $city, $province, $postalCode, $phoneNumber, $additionalPhoneNumber, $alternateContactName) {

        $timestamp = date("Y-m-d H:i:s");
        $this->db->where('userId', $userId);
        return $this->db->update('users', array(
            'userId' => $userId,
            'firstName' => $first_name,
            'lastName' => $last_name,
            'emailAddress' => $email,
            'accountHolder' => $primaryCarePerson,
            'street' => $street,
            'city' => $city,
            'province' => $province,
            'postalCode' => $postalCode,
            'phoneNumber' => $phoneNumber,
            'additionalPhoneNumber' => $additionalPhoneNumber,
            'alternateContactName' => $alternateContactName,
            'updatedOn' => $timestamp
        ));
    }

    function update_user_profile($uuid, $userId, $first_name, $last_name, $email) {

        $timestamp = date("Y-m-d H:i:s");
        $this->db->where('userId', $userId);
        return $this->db->update('users', array(
            'userId' => $userId,
            'firstName' => $first_name,
            'lastName' => $last_name,
            'emailAddress' => $email,
        ));
    }

    function update_admin_user($userId, $first_name, $last_name, $email, $roles) {

        $timestamp = date("Y-m-d H:i:s");
        // Deleting existing roles from table
        $this->db->where('userId', $userId);
        $this->db->delete('adminusersroles');

        // Inserting new roles
        $sql = "INSERT INTO adminusersroles (userId, roleId) VALUES ";
        $insertValues = [];

        // Modifying role in session variable as well.
        $_SESSION['role'] = [];
        foreach($roles as $role) {
            $insertValues[] = "($userId, $role)";
            $_SESSION['role'][$role] = 1;
        }
        $sql .= implode(",", $insertValues);
        $this->db->query($sql);

        // Updating user
        $this->db->where('userId', $userId);
        return $this->db->update('adminUsers', array(
            'userId' => $userId,
            'firstName' => $first_name,
            'lastName' => $last_name,
            'emailAddress' => $email,
            'lastUpdate' => $timestamp
        ));
    }

    function get_admin_users($organizationId)
    {
        return $this->db->query_all('SELECT * FROM users WHERE organizationId=? AND (roleId = 2 OR roleId = 3) ORDER BY lastName', array($organizationId));
    }

    function get_promo_code_details($id)
    {
        return $this->db->query_one('SELECT * FROM promoCodes pc LEFT JOIN users u ON pc.specificUserId = u.userId WHERE pc.promoCodeId = ' . $id);
    }


    function get_documents_data($organizationId)
    {
        return $this->db->query_one('SELECT * FROM documents WHERE organizationId=?', array($organizationId));
    }

    function create_document($organizationId)
    {
        $exists = $this->db->query_one('SELECT * FROM documents WHERE organizationId=?', array($organizationId));
        if ($exists == '') {
            $this->db->insert('documents', array(
                'organizationId' => $organizationId
            ));
        }
    }

    function add_item($promoCode, $discount, $minimumPurchase, $specificUserId, $specificVertical, $expiresOn) {
        $timestamp = date('Y-m-d H:i:s');
        return $this->db->insert('promoCodes', array(
            'promoCode' => $promoCode,
            'discount' => $discount,
            'minimumPurchase' => $minimumPurchase,
            'specificUserId' => $specificUserId,
            'specificVertical' => $specificVertical,
            'expiresOn' => date('Y-m-d', strtotime($expiresOn)),
            'createdOn' => $timestamp
        ));
    }

    function update_item($uuid, $userId, $promoCode, $discount, $minimumPurchase, $specificUserId, $specificVertical, $expiresOn) {
   
        $this->db->where('promoCodeId', $userId);

        return $this->db->update('promoCodes', array(
            'promoCode' => $promoCode,
            'discount' => $discount,
            'minimumPurchase' => $minimumPurchase,
            'specificUserId' => $specificUserId,
            'specificVertical' => $specificVertical,
            'expiresOn' => date('Y-m-d', strtotime($expiresOn))
        ));
    }

    function get_admin_roles() {
        return $this->db->query_all('SELECT id, name, controllerName FROM adminroles WHERE visible = 1 ORDER BY priority');
    }

    function get_admin_user_roles($userId) {
        return $this->db->query_all('SELECT roleId FROM adminusersroles WHERE userId=?', array($userId));
    }

}
