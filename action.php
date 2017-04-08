<?php
include "class-check/class.CheckImg.inc";

if (isset($_POST["name"])) {
    $words = $_POST["name"];
    $tag_arr = explode(' ', $_POST["index"]);
    $line = $tag_arr[0];
    $index = $tag_arr[1];
    $position1 = $tag_arr[2];
    $tag = $tag_arr[3];
    $all_tag = file_get_contents('newfile.html');
    $insert = new insertValue($all_tag);
    $insert->give_tag_desc($words, $line, $index, $position1, $tag);
}
class insertValue {
    public $all_array;
    public function __construct($all_text){
        $this->all_array = preg_split("/\\r\\n|\\r|\\n/", $all_text);
        $this->html= $all_text;
    }

    public function give_tag_desc($words, $line, $index, $position1='', $tag){
        switch ($tag){
            case 'img':
                $this->input_img_value($words, $line, $index);
                break;
            case 'html':
                $this->langBasic_val($words, $line, $index);
                break;
        }
    }

    public function langBasic_val($words, $line, $index){
        $str = file_get_contents('class-check/language.txt');
        $find = '/Subtag: (.+?) Description: '.$words.'/';
        preg_match_all($find, $str, $matches);
        $subtag = $matches[1][0];
        $find = '/lang=(.+?)(">?)/';
        $this->all_array[$line-1] = preg_replace($find, 'lang="'.$subtag.'$2', $this->all_array[$line-1]);
        $myfile = fopen("newfile.html", "w") or die("Unable to open file!");
        for ($i=0; $i<count($this->all_array); $i++){
            fwrite($myfile, htmlspecialchars_decode($this->all_array[$i])."\r\n");
        }
        fclose($myfile);
    }
    public function input_img_value($words, $line, $index){
        if ($words == 'Ignore'){$word = "";} else {$word = $words;}
        $img = new CheckingImg($this->html);
        $oldTag = $img->dom->saveXML($img->nodeImg[$index]);
        $img->nodeImg[$index]->setAttribute('alt', $word);
        $newTag = $img->dom->saveXML($img->nodeImg[$index]);

        /*** Modify array to be matched with php DOM ***/
        $re = '/<img (.+?)(\/?>)/';
        //add backslash
        $this->all_array[$line-1] = preg_replace($re, '<img $1/>', $this->all_array[$line-1]);
        //Remove double space if occured
        $this->all_array[$line-1] = preg_replace('/\s+/', ' ', $this->all_array[$line-1]);
        $this->replaceNew($oldTag, $newTag, $line);
    }

    public function replaceNew($oldHtml, $newHtml, $line){
        $this->all_array[$line-1] = str_replace($oldHtml, $newHtml, $this->all_array[$line-1]);
        $myfile = fopen("newfile.html", "w") or die("Unable to open file!");
        for ($i=0; $i<count($this->all_array); $i++){
            fwrite($myfile, htmlspecialchars_decode($this->all_array[$i])."\r\n");
        }
        fclose($myfile);
    }

}
?>