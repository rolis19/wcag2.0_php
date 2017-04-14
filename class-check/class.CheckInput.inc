<?php

class CheckingForm extends HtmlParser{
    public $input;
    public $inputWithFault;

    public function __construct($html){
        parent::__construct($html);
        $this->input = $this->dom->getElementsByTagName('input');
        $this->inputWithFault = $this->getAccessibility();
    }

//    public function setChildForm(){
//        $child = array();
//        foreach($this->nodeForm->childNodes as $key=>$node){
//            $tag = $node->nodeName;
//            switch ($tag){
//                case 'input':
//                    $node = $this->getChildInput($node);
//                case 'textarea':
//                case 'select':
//                    $child[$key] = $node;
//                    break;
//            }
//        }
//        return $child;
//    }
    public function  getInputAccess(){
        $inputAcc = array();
        foreach ($this->input as $key=>$node){
            $type = $node->getAttribute('type');
            switch ($type) {
                case "text":
                case "password":
                case "radio":
                case "checkbox":
                    //Html5 new
                case "color":
                case "date":
                case "datetime":
                case "datetime-local":
                case "email":
                case "month":
                case "number;":
                case "range":
                case "search":
                case "tel":
                case "time":
                case "url":
                case "week":
                    if (!$node->hasAttribute('aria-label'))
                        $inputAcc[$key] = $node;
                    break;
            }
        }
        return $inputAcc;
    }

    public function getAccessibility(){
        $newInput = array();
        if (empty($this->getLabel())){
            return $this->getInputAccess();
        }else {
            foreach ($this->getInputAccess() as $k=>$node){
                if (!$node->hasAttribute('id'))
                    $newInput[$k] = $node;
                else
                    foreach ($this->getLabel() as $nl){
                        if (!$nl->getAttribute('for') == $node->getAttribute('id'))
                            $newInput[$k] = $node;
                    }
            }
            return $newInput;
        }
    }

    public function getLabel(){
        $label = $this->dom->getElementsByTagName('label');
        $labelChek=array();
        foreach ($label as $k=>$node){
            $labelChek[$k]= $node->getLineNo();
        }
        if (!empty($labelChek)){
            return $label;
        }else {
            return '';
        }
    }

}

?>