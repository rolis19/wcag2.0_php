<?php
include ('class/class.ParseHtml.inc');

class CheckUl extends ParseHtml{
    public $nodeUl;
    public $imgnoAlt = array();
    public $imgBlankAlt = array();

    public function __construct($html){
        parent::__construct($html);
        // $this->dom is variable from HtmlParser
        $this->nodeUl = $this->dom->getElementsByTagName('ul');
    }


}

?>