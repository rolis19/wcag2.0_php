<?php

class CheckingItalic extends HtmlParser{
    public $nodeItalic;
    public $italic = array();

    public function __construct($html){
        parent::__construct($html);
        $this->nodeItalic = $this->dom->getElementsByTagName('em');
        $this->italic = $this->setItalic();
    }

    public function setItalic(){
        $italic = array();
        foreach ($this->nodeItalic as $key=>$node){
            $italic[$key] = array(
                'italicTag' => htmlspecialchars($this->dom->saveXML($node)),
                'line' => $node->getLineNo(),
            );
        }
        return $italic;
    }

}

?>