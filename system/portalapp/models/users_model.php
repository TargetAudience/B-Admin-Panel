<?php
class Users_Model extends TinyMVC_Model
{
    public function get_user($userId)
    {
        return $this->db->query_one('SELECT * from users WHERE userId=?', array(
          $userId
        ));
    }

    public function get_admin_user($userId)
    {
        $adminUser = $this->db->query_one('SELECT * from adminUsers WHERE userId=?', array(
          $userId
        ));

        //  Retrieving comma separated role names
        $roles = $this->db->query_one("SELECT GROUP_CONCAT(' ', ar.`name`) AS `roles` FROM adminroles ar
        INNER JOIN adminusersroles aur ON ar.id = aur.roleId
        WHERE aur.userId = ?", array($userId));
        $adminUser['role'] = $roles['roles'];
        return $adminUser;
    }

    public function get_user_posts($userId)
    {
        return $this->db->query_all("
          SELECT *
          FROM
          feeds
          WHERE userId=?
          ORDER BY added_on DESC
          ", array($userId));
    }

    function update_admin_password($userId, $newPassword)
    {
        $this->db->where('userId', $userId);

        return $this->db->update('adminUsers', array(
            'passwordHash'  => $newPassword
        ));
    }

    function get_user_token($token)
    {
        return $this->db->query_one('SELECT * FROM adminUsers WHERE passwordResetToken = ?', array($token));
    }
}
