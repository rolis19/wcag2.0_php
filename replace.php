<?php
$position_dynamic = file_get_contents('newfile.html');
$array_from_file = explode(" ", $position_dynamic);
$final_file = fopen("newfile.html", "w") or die("Unable to open file!");
foreach ($array_from_file as $items){
    $string_final = str_replace("*#+"," ", $items);
    fwrite($final_file, $string_final." ");
}

fclose($final_file);
?>