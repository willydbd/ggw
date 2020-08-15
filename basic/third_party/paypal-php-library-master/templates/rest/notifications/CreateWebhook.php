<?php
// Include required library files.
require_once('../../../autoload.php');
require_once('../../../includes/config.php');

$configArray = array(
    'ClientID' => $rest_client_id,
    'ClientSecret' => $rest_client_secret,
    'LogResults' => $log_results, 
    'LogPath' => $log_path,
    'LogLevel' => $log_level  
);

$PayPal = new \angelleye\PayPal\rest\notifications\NotificationsAPI($configArray);

$event_types = array();

$event_type_1 = array(
    'Name' => '',           // The unique event name. You can fine list of webhooks name in PayPal_Webhooks.txt
);

array_push($event_types, $event_type_1);

$event_type_2 = array(
    'Name' => '',           // The unique event name. You can fine list of webhooks name in PayPal_Webhooks.txt
);

array_push($event_types, $event_type_2);

$url = "";          // The URL that is configured to listen on localhost for incoming POST notification messages that contain event information.


$requestData = array(
    'Url' => $url,
    'EventTypes' => $event_types
);

$returnArray = $PayPal->CreateWebhook($requestData);
echo "<pre>";
print_r($returnArray);