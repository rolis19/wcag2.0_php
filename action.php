<?php
$tag = $_POST['tag'];
if (isset($_POST["name"])) {
    $words = $_POST["name"];
    $position = $_POST["index"];
    $one_tag = file_get_contents('file-reference.txt');
    $insert = new insertValue($one_tag, $tag, $position, $words);
    $insert->input_user_value();
}

class insertValue {
    public $all_array;
    public $tag;
    public $position;
    public $words;
    public function __construct($all_text, $tag, $position, $words){
        $this->all_array = explode(" ", $all_text);
        $this->tag = $tag;
        $this->position = $position;
        $this->words = $words;
    }

    public function debuging(){
//        $test = fopen("debug.txt", "w") or die("Unable to open file!");
//        fwrite($test, $items);
//        fclose($test);
    }
    public function size_original_arr(){
        $position_dynamic = file_get_contents('file-indicator.txt');
        $dynamic_arr = explode(" ", $position_dynamic);
        $items = sizeof($dynamic_arr);
        return $items;
    }
    public function input_user_value(){
        $position = $this->position;
        $words = htmlspecialchars_decode('alt="').$this->words.htmlspecialchars_decode('"');
        $a1 = array($this->all_array[$position].'*#+'.$words);
        array_splice($this->all_array, $position,1,$a1);
        $myfile_source = fopen("file-reference.txt", "w") or die("Unable to open file!");
        $myfile = fopen("newfile.html", "w") or die("Unable to open file!");
        foreach ($this->all_array as $items){
            fwrite($myfile_source, $items." ");
            fwrite($myfile, htmlspecialchars_decode($items)." ");
        }
        fclose($myfile_source);
        fclose($myfile);
        $this->size_original_arr();
    }
}
?>
