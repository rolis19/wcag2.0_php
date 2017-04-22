<?php

class CheckOl extends ParseHtml{
    public $nodeOl;
    public $ordList = array();

    public function __construct($html){
        parent::__construct($html);
        $this->nodeOl = $this->dom->getElementsByTagName('ol');
        $this->ordList = $this->setOrdList();
    }

    public function setOrdList(){
        $ordered = array();
        foreach ($this->nodeOl as $key=>$node){
            $ordered[$key] = array(
                'olTag' => htmlspecialchars($this->dom->saveXML($node)),
                'line' => $node->getLineNo(),
            );
        }
        return $ordered;
    }

}

?>