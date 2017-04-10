<?php
include ('class/class.ParseHtml.inc');

class CheckingImg extends HtmlParser{
    public $nodeImg;
    public $imgnoAlt = array();
    public $imgBlankAlt = array();

    public function __construct($html){
        parent::__construct($html);
        // $this->dom is variable from HtmlParser
        $this->nodeImg = $this->dom->getElementsByTagName('img');
        $this->imgnoAlt = $this->setImgWithoutAlt();
        $this->imgBlankAlt = $this->setImgBlankAlt();
    }

    public function setImgWithoutAlt(){
        $imgnoAlt = array();
        foreach ($this->nodeImg as $key=>$node){
            if (!$node->hasAttribute('alt')){
//                $node->setAttribute('alt','Makan makan bro');
                $imgnoAlt[$key] = array(
                    'imgTag' => htmlspecialchars($this->dom->saveXML($node)),
                    'line' => $node->getLineNo(),
                );
            }
        }
        return $imgnoAlt;
    }
    public function setImgBlankAlt(){
        $imgBlankAlt = array();
        foreach ($this->nodeImg as $key=>$node){
            if (empty($node->getAttribute('alt')) && $node->hasAttribute('alt')){
//                $node->setAttribute('alt','Makan makan bro');
                $imgBlankAlt[$key] = array(
                    'imgTag' => htmlspecialchars($this->dom->saveXML($node)),
                    'line' => $node->getLineNo(),
                    'src' => $this->getfileName($node->getAttribute('src')),
                );
            }
        }
        return $imgBlankAlt;
    }

    public function getfileName($path){
        $filename = explode('/', $path);
        $filename = '/'.$filename[count($filename)-2].'/'.$filename[count($filename)-1];
        return $filename;
    }
}

?>