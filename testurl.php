<?php

	function datafeed($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $a = curl_exec($ch);
    curl_close($ch);
    return $a;
  }
  
  $url="www.sanook.com";
$dataraw=datafeed($url);//raw data tag code
echo gettype($dataraw);
?>