<?php
$tag = $_POST['tag'];
if (isset($_POST["name"])) {
    $words = $_POST["name"];
    $position = $_POST["index"];
    $one_tag = file_get_contents('file-reference.txt');
    $insert = new insertValue($one_tag, $tag, $position, $words);
    $insert->give_tag_desc();
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

    public function give_tag_desc(){
        switch ($this->tag){
            case 'img':
                $tag_desc = htmlspecialchars('alt="');
                $this->input_user_value($tag_desc);
                break;
            case 'input':
                $tag_desc = htmlspecialchars('aria-labelledby="');
                $this->input_user_value($tag_desc);
                break;
        }
    }

    public function input_user_value($tag_desc){
        $position = $this->position;
        $words = $string_final = str_replace(" ","*#+", $this->words);
        $words = $tag_desc.$words.htmlspecialchars('"');
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
    }
}
?>