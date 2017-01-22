<?php
	$challenge = @$_REQUEST['hub_challenge'];
	$verify_token = @$_REQUEST['hub_verify_token'];

	if ($verify_token === 'botchatdml') {
	  echo $challenge;
	} else {
		echo 'Wrong token';
	}

	$input = json_decode(file_get_contents('php://input'), true);

	$sender = @$input['entry'][0]['messaging'][0]['sender']['id'];
	$message = @$input['entry'][0]['messaging'][0]['message']['text'];
	$token = '';
	//API Url
	$url = "https://graph.facebook.com/v2.6/me/messages?access_token=$token";
	
	$jsonData = array(
		'recipient' => array('id' => $sender),
		'message' => array('text' => sendReply($message)),		
	);
	
	//Initiate cURL.
	$ch = curl_init($url);	

	//Encode the array into JSON.
	$jsonDataEncoded = json_encode($jsonData);

	//Tell cURL that we want to send a POST request.
	curl_setopt($ch, CURLOPT_POST, 1);

	//Attach our encoded JSON string to the POST fields.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

	//Set the content type to application/json
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

	//Execute the request
	if(!empty($input['entry'][0]['messaging'][0]['message'])){
		$result = curl_exec($ch);
	}

	function sendReply($message = '') {
		$reply = "Hi, I'm a Bot";
		
		if($message == 'name') {
			$reply = "My name is Ahihi";
		}
		
		return $reply;
	}
	
	
	