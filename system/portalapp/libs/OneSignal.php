<?php

require_once('CURL.php');

final class OneSignal
{
    private $curl;

    private $appId;
    private $restApiKey;
    private $authToken;

    public function __construct($data)
    {
        $this->appId = $data['appId'];
        $this->restApiKey = $data['restApiKey'];
        $this->authToken = $data['authToken'];

        $this->curl = CURL::getInstance();
    }

    public function viewNotifications($index = 0, $limit = 50)
    {
        $this->curl->setUrl("https://onesignal.com/api/v1/notifications?app_id={$this->appId}&limit={$limit}&offset={$index}");
        $this->curl->setHeader([
            'Authorization: Basic ' . $this->restApiKey
        ]);

        return $this->curl->execute([], false);
    }

    public function viewNotificationById($id)
    {
        $this->curl->setUrl("https://onesignal.com/api/v1/notifications/{$id}?app_id={$this->appId}");
        $this->curl->setHeader([
            'Authorization: Basic ' . $this->restApiKey
        ]);

        return $this->curl->execute([], false);
    }

    public function viewDeviceCsvExport()
    {
        $this->curl->setUrl("https://onesignal.com/api/v1/players/csv_export?app_id={$this->appId}");
        $this->curl->setHeader([
            'Content-Type: application/json',
            'Authorization: Basic ' . $this->restApiKey
        ]);

        $postFields = [
            'extra_fields' => [
                'location',
                'rooted'
            ]
        ];

        if (!empty($parameter))
            $postFields = array_merge($postFields, $parameter);

        $postFields = json_encode($postFields);


        return $this->curl->execute($postFields, true);
    }

    public function viewDevices($index = 0, $limit = 300)
    {
        $this->curl->setUrl("https://onesignal.com/api/v1/players?app_id={$this->appId}&limit={$limit}&offset={$index}");
        $this->curl->setHeader([
            'Authorization: Basic ' . $this->restApiKey
        ]);

        return $this->curl->execute([], false);
    }

    public function viewDevicesWithId($playerId)
    {
        $this->curl->setUrl("https://onesignal.com/api/v1/players/{$playerId}?app_id={$this->appId}");
        $this->curl->setHeader([
            'Authorization: Basic ' . $this->restApiKey
        ]);
        return $this->curl->execute([], false);
    }

    public function viewApps()
    {
        $this->curl->setUrl('https://onesignal.com/api/v1/apps');
        $this->curl->setHeader([
            'Authorization: Basic ' . $this->authToken
        ]);

        return $this->curl->execute([], false);
    }

    public function viewAppById($appId = null)
    {
        if (is_null($appId))
            throw  new  Exception('AppId is be required');


        $this->curl->setUrl('https://onesignal.com/api/v1/apps/' . $appId);
        $this->curl->setHeader([
            "Content-Type: application/json",
            'Authorization: Basic ' . $this->authToken
        ]);

        return $this->curl->execute([], false);
    }

    public function sendAllSegments($message)
    {
        $parameter = [
            'included_segments' => 'All'
        ];
        return $this->sendMessage($message, $parameter);
    }

    public function sendActiveSegments($message)
    {
        $parameter = [
            'included_segments' => 'Active Users'
        ];
        return $this->sendMessage($message, $parameter);
    }

    public function sendInActiveSegments($message)
    {
        $parameter = [
            'included_segments' => 'Inactive Users'
        ];
        return $this->sendMessage($message, $parameter);
    }

    public function sendEngadedSegments($message)
    {
        $parameter = [
            'included_segments' => 'Engaged Users'
        ];
        return $this->sendMessage($message, $parameter);
    }

    public function sendPlayerWithId($message, $player_Ids = [])
    {
        $parameter = [
            'include_player_ids' => $player_Ids
        ];
        return $this->sendMessage($message, $parameter);
    }

    public function sendMessage($message = 'default', array $parameter = [])
    {
        $this->curl->setUrl("https://onesignal.com/api/v1/notifications");
        $this->curl->setHeader([
            'Content-Type: application/json',
            'Authorization: Basic ' . $this->restApiKey
        ]);

        $postFields = [
            'app_id' => $this->appId,
            'contents' => [
                'en' => $message
            ]
        ];

        if (!empty($parameter))
            $postFields = array_merge($postFields, $parameter);

        $postFields = json_encode($postFields);


        return $this->curl->execute($postFields, true);
    }

    public function sendSilent(array $parameter = [])
    {
        $this->curl->setUrl("https://onesignal.com/api/v1/notifications");
        $this->curl->setHeader([
            'Content-Type: application/json',
            'Authorization: Basic ' . $this->restApiKey
        ]);

        $postFields = [
            'app_id' => $this->appId
        ];

        if (!empty($parameter))
            $postFields = array_merge($postFields, $parameter);

        $postFields = json_encode($postFields);


        return $this->curl->execute($postFields, true);
    }
}