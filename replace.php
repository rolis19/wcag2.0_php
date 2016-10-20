<?php
$position_dynamic = file_get_contents('newfile.html');
$dynamic_arr = explode(" ", $position_dynamic);
//str_replace("*#+"," ", $position_dynamic);
$final_file = fopen("newfile.html", "w") or die("Unable to open file!");
foreach ($dynamic_arr as $items){
    $string_final = str_replace("*#+"," ", $items);
    fwrite($final_file, $string_final." ");
}

fclose($final_file);
?>