<?php
include ($_SERVER['DOCUMENT_ROOT'].'/learn/class/class.ParseHtml.inc');

class CheckingForm extends HtmlParser{
    public $nodeForm;
    public $formChild = array();

    public function __construct($html){
        parent::__construct($html);
        $this->nodeForm = $this->dom->getElementsByTagName('form')[0];
        //$this->formChild = $this->setImgWithoutAlt();
    }

    public function setImgWithoutAlt(){
        $imgnoAlt = array();
        //foreach ($this->nodeForm as $key=>$node){
//            $imgnoAlt[$key] = array(
//                'imgTag' => htmlspecialchars($this->dom->saveXML($node)),
//                'line' => $node->getLineNo(),
//            );
        //}
        var_dump($this->nodeForm->childNodes);
        foreach($this->nodeForm->childNodes as $node){
//                print $node->nodeName.' - '.$node->nodeValue;
            if ($node->nodeName == 'input' || $node->nodeName == 'textarea' || $node->nodeName == 'select' || $node->nodeName == 'button'){
                echo $node->nodeName.' = '.$node->getLineNo().'<br>';
            }
        }
        return $imgnoAlt;
    }

}

?>