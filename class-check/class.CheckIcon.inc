<?php
//include ('class/class.ParseHtml.inc');

class CheckIcon extends ParseHtml{
    public $nodeIcon;

    public function __construct($html){
        parent::__construct($html);
        // $this->dom is variable from HtmlParser
    }
    public function getIcon(){
        $iIco = $this->dom->getElementsByTagName('i');
        $spanIco = $this->dom->getElementsByTagName('span');
        $k=0;
        if($iIco->length != 0){
            foreach ($iIco as $node){
                if (preg_match('/(glyph|fa|ico)(?!.*aria)(.+?)/', $node->getAttribute('class')) && !$node->hasAttribute('aria-hidden')){
                    $k++;
                    $node->setAttribute('aria-hidden', 'true');
                    $this->nodeIcon[$k] = $node;
                }
            }
        }
        if($spanIco->length != 0){
            foreach ($spanIco as $node){
                if (preg_match('/(glyph|fa|ico)(?!.*aria)(.+?)/', $node->getAttribute('class')) && !$node->hasAttribute('aria-hidden')){
                    $k++;
                    $this->nodeIcon[$k] = $node;
                }
            }
        }

    }

}

?>