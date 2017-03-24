<?php


class CheckingOnChange extends HtmlParser{
    public $nodeSelect;
    public $selectOnChange = array();

    public function __construct($html){
        parent::__construct($html);
        $this->nodeSelect = $this->dom->getElementsByTagName('select');
        $this->selectOnChange = $this->setOnChange();
    }

    public function setOnChange(){
        $onChange = array();
        foreach ($this->nodeSelect as $key=>$node){
            if ($node->hasAttribute('onchange')){
                $onChange[$key] = array(
                    'selectOnChange' => htmlspecialchars($this->dom->saveXML($node)),
                    'line' => $node->getLineNo(),
                );
            }
        }
        return $onChange;
    }

}

?>