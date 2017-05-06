<?php
//include ('class/class.ParseHtml.inc');

class CheckLink extends ParseHtml{
    public $nodeLink;
    public $blankLink;
    public $blankLinkTxt;
    public $sortLinktxt;

    public function __construct($html){
        parent::__construct($html);
        // $this->dom is variable from HtmlParser
    }

    public function setLink(){
        $lk = $this->dom->getElementsByTagName('a');
        foreach ($lk as $k=>$node){
            if (strlen($node->getAttribute('href')) == 1 || strlen($node->getAttribute('href')) == 0){
                $this->blankLink[$k] = $node;
            }
            if (!$node->hasChildNodes()){ // Has no child means also has no value
                $this->blankLinkTxt[$k] = $node;
            }else{
                if (str_word_count($node->nodeValue) > 0 && str_word_count($node->nodeValue) < 2){
                    $this->sortLinktxt[$k] = $node;
                }
            }
        }
    }

}

?>