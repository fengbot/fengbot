<?php
$access_token = 'Hh40CAVW1tOyKNlO+juusBcijIfpU30ZlMURJByXwJs2z5MvqL8WqXKEUihemQTmYwbIWyGh5sVPl1kRMWFaFbrLin0PE+1yX+xcaFmjpJZsirdEDsKKZ3iT/Gt5JRxCFvVnUtMZcQVBj31BZJXNKwdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
/*$myfile = fopen("/usr/share/nginx/html/json.log","a");
foreach (getallheaders() as $name => $value) {
    fwrite($myfile,"$name: $value\n");
}
$postdata = file_get_contents("php://input");
fwrite($myfile,$postdata);
fwrite($myfile,"\n +++++++++++++++++++++++++ \n");
foreach (getallheaders() as $name => $value) {
    echo "$name: $value\n";
        echo "<br>";
}
*/
// Validate parsed JSON data
if (!is_null($events['events'])) {
 // Loop through each event
 foreach ($events['events'] as $event) {
  // Make a Fetch user profile
  $uid = $event['source']['userId'];
  $url = 'https://api.line.me/v2/bot/profile/'.$uid;
  $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 0);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  $result = curl_exec($ch);
  curl_close($ch);
  $profileinfo = json_decode($result, true);
  // Retrieve image picture
  $urlprofile = $profileinfo['pictureUrl'].'/large';
  /*
  $chpic = curl_init($urlprofile);
  $saveuri = "/usr/share/nginx/html/profile/".$uid.".png";
  $temppic = fopen($saveuri,"wb");
  curl_setopt($chpic, CURLOPT_FILE, $temppic);
  curl_setopt($chpic, CURLOPT_HEADER, 0);
  curl_setopt($chpic, CURLOPT_FOLLOWLOCATION, true);
  $resultpic = curl_exec($chpic);
  curl_close($chpic);
  fclose($saveuri);
  */
  // Reply only when message sent is in 'text' format and match word Demo
  if ($event['type'] == 'message' && ($event['message']['type'] == 'text' && $event['message']['text'] == 'Demo') ) {
   // Get text sent
   $text = $event['message']['text'];
   // Get replyToken
   $replyToken = $event['replyToken'];
   // Build message to reply back
   $message1 = [
    'type' => 'text',
    'text' => 'hello '.$profileinfo['displayName'].' '.$profileinfo['statusMessage']
   ];
   
   /*
   $message4 = [
    'type' => 'image',
    'originalContentUrl' => $urlprofile,
    'previewImageUrl' => $urlprofile
   ];*/
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
    'type' => 'template',
    'altText' => 'This is a carousel template',
    'template' => array(
      'type' => 'carousel',
      'columns' => array(
       array(
        'thumbnailImageUrl' => 'https://sdl-stickershop.line.naver.jp/stickershop/v1/product/5512/IOS/main_animation@2x.png',
        'title' => 'Brown & Conys Lonely Hearts Date',
        'text' => '60THB',
        'actions' => array(
         array(
          'type' => 'uri',
          'label' => 'Purchase',
          'uri' => 'https://store.line.me/stickershop/product/5512/en'
         ),
         array(
          'type' => 'uri',
          'label' => 'Go to sticker shop',
          'uri' => 'https://store.line.me'
         )
        )
       ),
       array(
        'thumbnailImageUrl' => 'https://iservices.me/imgBC/2.png',
        'title' => 'this is menu',
        'text' => 'text description',
        'actions' => array(
         array(
          'type' => 'uri',
          'label' => 'View in LINE',
          'uri' => 'https://line.me'
         ),
         array(
          'type' => 'message',
          'label' => 'Say Hello',
          'text' => 'Hello'
         )
        )
       )
      )
    )
   ];
   // Make a POST Request to Messaging API to reply to sender
   $url = 'https://api.line.me/v2/bot/message/reply';
   $data = [
    'replyToken' => $replyToken,
    'messages' => array($message1,$message2,$message3),
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
   //fwrite($myfile,$result);
   //fwrite($myfile,"\n +++++++++++++++++++++++++ \n");
   //echo $result . "\r\n";
  }
 }
}
echo "OK";
?>
