<?php
$str_get= file_get_contents('temp-html-file.html');
$arr_one = preg_split("/\\r\\n|\\r|\\n/", htmlspecialchars($str_get));
$array_all = array();

for ($i=0; $i<count($arr_one); $i++){
    $array_all[$i] = explode(" ", $arr_one[$i]);
}
foreach ($array_all as $keys=>$items){
    foreach ($items as $spec){
        if ($spec == htmlspecialchars('id="nama"')){
            echo "Terletak pada baris= ".$keys;
        }
    }
    echo "<br>";
}
//print_r($array_all);
echo "<br>";
?>