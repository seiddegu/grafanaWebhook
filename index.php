<?php
// Retrieve POST request data from Grafana alert notification
$requestData = file_get_contents('php://input');
$requestJson = json_decode($requestData);

// Extract relevant information from request data
$alertName = $requestJson->title;
$message = $requestJson->message;
$alertState = $requestJson->state;
$alertTimestamp = $requestJson->evalMatches[0]->value;

// Set up variables for SMS notification
$phoneNumber = "251911508778";
$messageText = "Alert: $alertName\nState: $alertState\nMessage: $message\nTimestamp: $alertTimestamp";
$kannel_srv_url = "10.180.52.103:13131";
$kannel_username = "sendmeatext";	
$kannel_passwd = "pass@2012ET";

// Send SMS notification using Kannel
$kannelUrl = "http://". $kannel_srv_url . "/cgi-bin/sendsms?username=$kannel_username&password=$kannel_passwd&text=" . urlencode($messageText) . "&to=$phoneNumber";
$kannelUrl .= "&smsc=smpp1&from=MonAlert&charset=utf-8";
// echo $kannelUrl."\n";
$kannelResponse = file_get_contents($kannelUrl);

// Echo the message and title for debugging purposes
echo $messageText;
