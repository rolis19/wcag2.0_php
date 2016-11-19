<?php
$tag = $_POST['tag'];
if (isset($_POST["name"])) {
    $words = $_POST["name"];
    $position = $_POST["index"];
    $position1 = $_POST["indexLain"];
    $other_index = $_POST['otherIndex'];
    $myfile = fopen("debug.txt", "w") or die("Unable to open file!");
    fwrite($myfile, $other_index." ");
    fclose($myfile);
    $all_tag = file_get_contents('file-reference.txt');
    $insert = new insertValue($all_tag, $tag, $position, $other_index, $words);
    $insert->give_tag_desc();
}
class insertValue {
    public $all_array;
    public $tag;
    public $position;
    public $position1;
    public $words;
    public function __construct($all_text, $tag, $position, $position1='', $words){
        $this->all_array = explode(" ", $all_text);
        $this->tag = $tag;
        $this->position = $position;
        $this->position1 = $position1;
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
            case 'label':
                $tag_desc = htmlspecialchars('for="');
                $tag_desc1 = htmlspecialchars('id="');
                $this->input_user_value_twice($tag_desc, $tag_desc1);
                break;

        }
    }

    public function input_user_value($tag_desc){
        $position = $this->position;
        $words = str_replace(" ","*#+", $this->words);
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

    public function input_user_value_twice($tag_desc, $tag_desc1){
        $position = $this->position;
        //Insert the first value to for in label
        $words = str_replace(" ","*#+", $this->words);
        $words_label = htmlspecialchars('<label*#+').$tag_desc.$words.htmlspecialchars('"').substr($this->all_array[$position], 9, strlen($this->all_array[$position]));
        $a1 = array($words_label);
        array_splice($this->all_array, $position,1,$a1);
        //Insert the second value to id in input
        $words_input = $tag_desc1.$words.htmlspecialchars('"');
        $position1 = $this->position1;
        // check whether id is in the last position or not if yes don't forget closed tag
        $check_last= substr($this->all_array[$position1], strlen($this->all_array[$position1])-4, 4);
        if (substr($this->all_array[$position1], 0, 2) == 'id'){
            if ($check_last == '&gt;'){
                $a2 = array($words_input.htmlspecialchars('>'));
            } else {
                $a2 = array($words_input);
            }
        } else {
            $a2 = array($this->all_array[$position1].'*#+'.$words_input);
        }
        array_splice($this->all_array, $position1,1,$a2);
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