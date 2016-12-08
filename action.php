<?php
if (isset($_POST["name"])) {
    $words = $_POST["name"];
    $tag_arr = explode(' ', $_POST["index"]);
    $line = $tag_arr[0];
    $position = $tag_arr[1];
    $position1 = $tag_arr[2];
    $tag = $tag_arr[3];
    $all_tag = file_get_contents('file-reference.txt');
    $insert = new insertValue($all_tag);
    $insert->give_tag_desc($words, $line, $position, $position1, $tag);
    //Debuging bro
    $myfile = fopen("debung.txt", "w") or die("Unable to open file!");
    fwrite($myfile, $line);
    fclose($myfile);
}
class insertValue {
    public $all_array;
    public $arr_newline;
    public function __construct($all_text){
        $this->arr_newline = preg_split("/\\r\\n|\\r|\\n/", $all_text);
        for ($i=0; $i<count($this->arr_newline); $i++){
            $this->all_array[$i] = explode(" ", $this->arr_newline[$i]);
        }
    }

    public function give_tag_desc($words, $line, $position, $position1='', $tag){
        switch ($tag){
            case 'img':
                $tag_desc = htmlspecialchars('alt="');
                $this->input_user_value($tag_desc, $words, $line, $position);
                break;
            case 'input':
                $tag_desc = htmlspecialchars('aria-labelledby="');
                //$this->input_user_value($tag_desc);
                break;
            case 'label':
                $tag_desc = htmlspecialchars('for="');
                $tag_desc1 = htmlspecialchars('id="');
                // $this->input_user_value_twice($tag_desc, $tag_desc1);
                break;

        }
    }

    public function input_user_value($tag_desc, $words, $line, $position){
        $words = $tag_desc.$words.htmlspecialchars('"');
        for ($i= (count($this->all_array[$line-1])); $i>$position+1; $i--){
            $this->all_array[$line-1][$i] = $this->all_array[$line-1][$i-1];
        }
        $this->all_array[$line-1][$position+1] = $words;
        $myfile_source = fopen("file-reference.txt", "w") or die("Unable to open file!");
        $myfile = fopen("newfile.html", "w") or die("Unable to open file!");
        foreach ($this->all_array as $lines){
            foreach ($lines as $items){
                fwrite($myfile_source, $items." ");
                fwrite($myfile, htmlspecialchars_decode($items)." ");
            }
            fwrite($myfile_source, "\r\n");
            fwrite($myfile, "\r\n");
        }
        fclose($myfile_source);
        fclose($myfile);
    }

//    public function input_user_value_twice($tag_desc, $tag_desc1){
//        $position = $this->position;
//        //Insert the first value to for in label
//        $words = str_replace(" ","*#+", $this->words);
//        $words_label = htmlspecialchars('<label*#+').$tag_desc.$words.htmlspecialchars('"').substr($this->all_array[$position], 9, strlen($this->all_array[$position]));
//        $a1 = array($words_label);
//        array_splice($this->all_array, $position,1,$a1);
//        //Insert the second value to id in input
//        $words_input = $tag_desc1.$words.htmlspecialchars('"');
//        $position1 = $this->position1;
//        // check whether id is in the last position or not if yes don't forget closed tag
//        $check_last= substr($this->all_array[$position1], strlen($this->all_array[$position1])-4, 4);
//        if (substr($this->all_array[$position1], 0, 2) == 'id'){
//            if ($check_last == '&gt;'){
//                $a2 = array($words_input.htmlspecialchars('>'));
//            } else {
//                $a2 = array($words_input);
//            }
//        } else {
//            $a2 = array($this->all_array[$position1].'*#+'.$words_input);
//        }
//        array_splice($this->all_array, $position1,1,$a2);
//        $myfile_source = fopen("file-reference.txt", "w") or die("Unable to open file!");
//        $myfile = fopen("newfile.html", "w") or die("Unable to open file!");
//        foreach ($this->all_array as $items){
//            fwrite($myfile_source, $items." ");
//            fwrite($myfile, htmlspecialchars_decode($items)." ");
//        }
//        fclose($myfile_source);
//        fclose($myfile);
//    }
}
?>