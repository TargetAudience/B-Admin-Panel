<?php
class App_Model extends TinyMVC_Model
{
    function add_to_message_log($organizationId, $personFromId, $personToId, $messageType, $message, $extra)
    {
        $timestamp = date("Y-m-d H:i:s");

        return $this->db->insert('messageLogs', array(
            'organizationId' => $organizationId,
            'personFromId' => $personFromId,
            'personToId' => $personToId,
            'messageType' => $messageType,
            'message' => $message,
            'extra' => $extra,
            'dateTimeStamp' => $timestamp
        ));
    }

}