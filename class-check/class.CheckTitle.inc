<?php
//include ('class/class.ParseHtml.inc');

class CheckTitle extends ParseHtml{
    public $title;
    public $titleFault;

    public function __construct($html){
        parent::__construct($html);
        $this->title = $this->dom->getElementsByTagName('title')[0];
    }

    public function getTitle(){
        if ($this->title != null){
            if (str_word_count($this->title->nodeValue) <= 2){
                $this->titleFault = $this->title;
            }
        }
    }
}
?>