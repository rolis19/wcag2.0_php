<?php
$c = curl_init('https://cs.kku.ac.th/index.php?lang=th');
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
//curl_setopt(... other options you want...)

$html = curl_exec($c);

if (curl_error($c))
    die(curl_error($c));

// Get the status code
$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
curl_close($c);
echo $status;
return $html;
?>