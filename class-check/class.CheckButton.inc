<?php

class CheckButton extends ParseHtml{
    public $button;
    public $buttonWithAria;
    public $btnWithEnt;
    public $btnWithLessInfo;
    public $buttonNoAria;
    public function __construct($html){
        parent::__construct($html);
        $this->button = $this->dom->getElementsByTagName('button');
    }

    public function getButton(){
        foreach ($this->button as $key=>$node){
            if (!$this->matchArial($node)){
                $value = htmlentities($node->nodeValue);
                if (preg_match('/.*?&.+;.*?/', $value)){
                    $this->btnWithEnt[$key] = $node;
                }else if (strlen($value) <= 5){
                    $this->btnWithLessInfo[$key] = $node;
                }
            }
        }
    }


    public function getBtnWithAria(){
        $btn = array();
        foreach ($this->button as $key=>$node){
            if ($node->hasAttribute('aria-label')){
                if (strlen($node->getAttribute) <= 5){
                    $btn[$key] = $node;
                }
            }
        }
        if (!empty($btn)){
            return $btn;
        } else {
            return '';
        }
    }

    public function matchArial($node){
        $a=0;
        if ($node->hasAttributes()) {
            foreach ($node->attributes as $attr) {
                $name = $attr->nodeName;
                if (preg_match('/aria-*/', $name))
                    $a++;

            }
        }
        if ($a == 0){
            return false;
        }else {
            return true;
        }

    }
}

?>