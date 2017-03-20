<?php
include ($_SERVER['DOCUMENT_ROOT'].'/learn/class/class.ParseHtml.inc');

class CheckingImg extends HtmlParser{
    public $nodeImg;
    public $imgnoAlt = array();

    public function __construct($html){
        parent::__construct($html);
        $this->nodeImg = $this->dom->getElementsByTagName('img');
        $this->imgnoAlt = $this->setImgWithoutAlt();
    }

    public function setImgWithoutAlt(){
        $imgnoAlt = array();
        foreach ($this->nodeImg as $key=>$node){
            if (!$node->getAttribute('alt')){
//                $node->setAttribute('alt','Makan makan bro');
                $imgnoAlt[$key] = array(
                    'imgTag' => htmlspecialchars($this->dom->saveXML($node)),
                    'line' => $node->getLineNo(),
                );
            }
        }
        return $imgnoAlt;
    }

}

?>