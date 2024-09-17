<?php
$API_KEY = "";

header('Content-Type: application/json');
$apikey = base64_encode($API_KEY);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.racehero.io/v1/events/3134/live/leaderboard");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, false);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Accept: application/json",
  "Authorization: Basic $apikey:"
));

$response = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo $response;