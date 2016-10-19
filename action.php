<?php 
$tag = $_POST['tag'];
if (isset($_POST["name_$tag"])) {
    $words = $_POST["name_$tag"];
    $position = $_POST["index_$tag"];
    $myfile = fopen("tesfile.html", "w") or die("Unable to open file!");
    fwrite($myfile, $words);
    fclose($myfile);

//    $insert_val = new insertValue('asjbhavsjvb ashcbasb');
//    $insert_val->write_file();
}

class insertValue extends mainArray {

    public function write_file(){
        $myfile = fopen("tesfile.html", "w") or die("Unable to open file!");
        fwrite($myfile, $_POST["name"]." ");
        fclose($myfile);
    }

}

?>
