<?php


class CheckItalic extends ParseHtml{
    public $nodeItalic;
    public $italic = array();

    public function __construct($html){
        parent::__construct($html);
        $this->nodeItalic = $this->dom->getElementsByTagName('em');
    }

}

?>