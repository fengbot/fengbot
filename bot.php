<?php
$access_token = 'Hh40CAVW1tOyKNlO+juusBcijIfpU30ZlMURJByXwJs2z5MvqL8WqXKEUihemQTmYwbIWyGh5sVPl1kRMWFaFbrLin0PE+1yX+xcaFmjpJZsirdEDsKKZ3iT/Gt5JRxCFvVnUtMZcQVBj31BZJXNKwdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];
			
			 $message2 = [
    				'type' => 'template',
   				 'altText' => 'This is a confirm Template',
   				 'template' => array(
					 'type' => 'confirm',
					 'text' => 'Are you sure?',
					 'actions' => array(
						  array(
						     'type' => 'message',
						     'label' => 'Yes',
							'text' => 'yes'
						  ),
						  array(
							'type' => 'message',
							'label' => 'No',
							'text' => 'no'
						  )
					      )
 				  )
			];
			 $message3 = [
				  "type": "imagemap",
				  "baseUrl": "fengbot/Imagemap",
				  "altText": "this is an imagemap",
				  "baseSize": {
				      "height": 1040,
				      "width": 545
				  },
				  "actions": [
				      {
					  "type": "uri",
					  "linkUri": "https://www.google.co.th/search?q=red&source=lnms&tbm=isch&sa=X&ved=0ahUKEwiO-e33663TAhVIVLwKHWEuCl4Q_AUIBigB&biw=1600&bih=821",
					  "area": {
					      "x": 0,
					      "y": 0,
					      "width": 520,
					      "height": 545
					  }
				      },
				      {
					  "type": "message",
					  "text": "Good choice, you are now entering the Matrix.",
					  "area": {
					      "x": 520,
					      "y": 0,
					      "width": 520,
					      "height": 545
					  }
				      }
				  ]
				]
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages,$message2,$message3],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
