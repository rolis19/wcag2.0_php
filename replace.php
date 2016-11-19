<?php
$str_get= file_get_contents('newfile.html');
$str_fix = desentralize_string($str_get);
$array_from_file = explode(" ", $str_fix);
$final_file = fopen("newfile.html", "w") or die("Unable to open file!");
foreach ($array_from_file as $items){
    $string_final = str_replace("*#+"," ", $items);
    fwrite($final_file, $string_final." ");
}
fclose($final_file);

function desentralize_string($strings){
    $string1 = str_replace(" *#newline#* ", "\n", $strings); //return the new line as before
    $string2 = str_replace("*#newline#* ", "\n", $string1); //return the new line as before
    $final_string = str_replace("*#newline#*", "\n", $string2); //return the new line as before
    return $final_string;
}
?>