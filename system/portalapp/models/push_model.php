<?php

// error_log(print_R($var,TRUE));

class Push_Model extends TinyMVC_Model
{
    function getMessage($pushNotificationId)
    {
        return $this->db->query_one('SELECT *
            FROM pushNotifications
            WHERE pushNotificationId = ?', array($pushNotificationId));
    }

    function getUser($userId)
    {
        return $this->db->query_one('SELECT *
            FROM users
            WHERE userId = ?', array($userId));
    }

    function getPushNotifications()
    {
        return $this->db->query_all('SELECT * FROM pushNotifications');
    }

    function getPushUsersCount()
    {
        return $this->db->query_one("SELECT count(*) AS count FROM users WHERE role = 'patient' AND pushToken != '' AND pushNotifications = 1");
    }

    function getNotificationDetails($pushNotificationId)
    {
        return $this->db->query_one('SELECT pushNotifications.*, adminUsers.firstName, adminUsers.lastName
            FROM pushNotifications
            LEFT JOIN adminUsers ON adminUsers.userId = pushNotifications.updatedBy
            AND pushNotifications.pushNotificationId = ?', array($pushNotificationId));
    }

    function addNotification($internalName, $messageTitle, $messageBody, $updatedBy)
    {
        $timestamp = date('Y-m-d H:i:s');

        return $this->db->insert('pushNotifications', array(
            'internalName' => $internalName,
            'messageTitle' => $messageTitle,
            'messageBody' => $messageBody,
            'updatedBy' => $updatedBy,
            'updatedOn' => $timestamp,
            'createdOn' => $timestamp
        ));
    }

    function editNotification($notificationsId, $internalName, $messageTitle, $messageBody, $updatedBy)
    {
        $timestamp = date('Y-m-d H:i:s');

        $this->db->where('pushNotificationId', $notificationsId);

        return $this->db->update('pushNotifications', array(
            'internalName' => $internalName,
            'messageTitle' => $messageTitle,
            'messageBody' => $messageBody,
            'updatedBy' => $updatedBy,
            'updatedOn' => $timestamp,
        ));
    }

    function addUserNotification($userId, $notificationMessageId, $pushNotification, $smsNotification)
    {
        return $this->db->insert('notifications', array(
            'userId' => $userId,
            'notificationMessageId' => $notificationMessageId,
            'sentPush' => $pushNotification,
        ));
    }
}
