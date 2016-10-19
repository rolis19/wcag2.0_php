<?php
$tag = $_POST['tag'];
if (isset($_POST["name_$tag"])) {
    $words = $_POST["name_$tag"];
    $position = $_POST["index_$tag"];
    $one_tag = file_get_contents('cek-file.txt');
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

    public function input_user_value(){
        $words = htmlspecialchars_decode('alt="').$this->words.htmlspecialchars_decode('"');
        $a1 = array($this->all_array[$this->position], $words);
        array_splice($this->all_array, $this->position,1,$a1);
        $myfile = fopen("newfile.html", "w") or die("Unable to open file!");
        foreach ($this->all_array as $items){
            fwrite($myfile, htmlspecialchars_decode($items)." ");
        }
        fclose($myfile);
    }
}
?>
