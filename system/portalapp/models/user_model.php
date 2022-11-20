<?php
class User_Model extends TinyMVC_Model
{
    function get_user_login($emailAddress)
    {
        return $this->db->query_all('SELECT * FROM adminUsers WHERE emailAddress=?', array($emailAddress));
    }

    function get_user_email($emailAddress)
    {
        return $this->db->query_one('SELECT userId, firstName, lastName, emailAddress, role
            FROM adminUsers
            WHERE emailAddress = ?
            ', array($emailAddress));
    }

    function get_users_email($emailAddress)
    {
        return $this->db->query_all('SELECT userId, firstName, lastName, emailAddress, role
            FROM adminUsers
            WHERE emailAddress = ?
            ', array($emailAddress));
    }

    function get_user_token($token)
    {
        return $this->db->query_one('SELECT userId, firstName, lastName, emailAddress, role, passwordResetToken
            FROM adminUsers
            WHERE passwordResetToken = ?
            ', array($token));
    }

    function sendForgotPasswordLink($userId, $emailAddress)
    {

        $length = 128;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $body = "<p>Click the link below to reset your password</p>";
        /*$body .= "<form method='post' action='https://admin.boom.health/user/resetPassword'>";
        $body .= "<input type='hidden' name='token' value='" . $randomString . "'>";
        $body .= "<input type='button' name='submit' value='Reset Password' />";
        $body .= "</form>";*/
        $body .= "<a href='https://admin.boom.health/user/resetPassword?token=" . $randomString . "'>Reset Password</a>";


        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.sparkpostmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'SMTP_Injection';
        $mail->Password = '8b1b663a156d7206a7d1051e5121fd9db7da5b47';
        $mail->SMTPSecure = 'starttls';
        $mail->Port = 587;

        $mail->setFrom("info@boom.health", "Boom Health");
        $mail->addAddress($emailAddress);

        $mail->isHTML(true);
        $mail->Subject = "Reset Your Boom Health Password";

        $mail->Body = $body;
        $mail->send();

        $this->db->where('userId', $userId);

        return $this->db->update('adminUsers', array(
            'passwordResetToken'  => $randomString
        ));
    }

    function update_admin_password($userId, $newPassword)
    {
        $this->db->where('userId', $userId);

        return $this->db->update('adminUsers', array(
            'passwordHash'  => $newPassword
        ));
    }

    function get_user($emailAddress, $password)
    {
        return $this->db->query_all('SELECT u.userId, u.firstName, u.lastName, u.emailAddress FROM adminUsers u WHERE emailAddress=? AND password = ? LIMIT 1', array($emailAddress, $password));
    }

    function update_login_data($userId) {
        $timestamp = date("Y-m-d H:i:s");

        $user = $this->db->query_one('SELECT * from adminUsers WHERE userId=?', array(
            $userId
        ));
        $logins  = $user['loginCount'] + 1;

        $this->db->where('userId', $userId);

        return $this->db->update('adminUsers', array(
            'loginCount' => $logins,
            'lastLogin' => $timestamp
        ));
    }




    function get_roles()
    {
        return $this->db->query_all('SELECT roleId, roleKey, role, description FROM roles WHERE visible = 1');
    }

    function get_permissions()
    {
        return $this->db->query_all('SELECT permissionId, permission, description FROM permissions ORDER BY ordering');
    }

    function get_role_permissions($roleId, $organizationId)
    {
        return $this->db->query_all('SELECT p.permissionId, p.permission
            FROM permissions p, rolePermissions rP
            WHERE p.permissionId = rP.permissionId
            AND rP.roleId = ? AND rP.organizationId = ?', array($roleId, $organizationId));
    }
}