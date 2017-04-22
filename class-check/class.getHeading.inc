<?php

include ('class/class.ParseHtml.inc');

class getHeading extends ParseHtml{
    public $headingList;

    public function __construct($html){
        parent::__construct($html);
        $this->headingList = $this->dom->getElementsByTagName("h2");
    }

}

?>