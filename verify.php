curl -X GET \
-H 'Authorization: Bearer 'Hh40CAVW1tOyKNlO+juusBcijIfpU30ZlMURJByXwJs2z5MvqL8WqXKEUihemQTmYwbIWyGh5sVPl1kRMWFaFbrLin0PE+1yX+xcaFmjpJZsirdEDsKKZ3iT/Gt5JRxCFvVnUtMZcQVBj31BZJXNKwdB04t89/1O/w1cDnyilFU=' \
https://api.line.me/v1/oauth/verify
{
  "channelId":1500475458,
  "mid":"U492e50bd36475a476cb4cc94325a9fd3"
}
<?php
$access_token = 'Hh40CAVW1tOyKNlO+juusBcijIfpU30ZlMURJByXwJs2z5MvqL8WqXKEUihemQTmYwbIWyGh5sVPl1kRMWFaFbrLin0PE+1yX+xcaFmjpJZsirdEDsKKZ3iT/Gt5JRxCFvVnUtMZcQVBj31BZJXNKwdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
