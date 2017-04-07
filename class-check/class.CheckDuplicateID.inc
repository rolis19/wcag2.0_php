<?php


class CheckingDupID extends HtmlParser{
    public $nodeAll;
    public $idList= array();
    public $duplicateId = array();

    public function __construct($html){
        parent::__construct($html);
        $this->nodeAll = $this->dom->getElementsByTagName('*');
        $this->idList = $this->setIdList();
        $this->duplicateId = $this->setDupId();
    }

    public function setIdList(){
        $idList = array();
        foreach ($this->nodeAll as $node){
            $key = $node->getLineNo();
            if (!empty($node->getAttribute('id'))){
                $idList[$key] = $node->getAttribute('id');
            }
        }
        return $idList;
    }

    public function setDupId(){
        $dups = array();
        $duplicate = array();
        $idList = $this->idList;
        foreach(array_count_values($idList) as $val => $c)
            if($c > 1) $dups[] = $val;

        //Create multidimensional array
        foreach ($dups as $itm){
            foreach ($this->idList as $k=>$dup){
                if ($itm == $dup){
                    $duplicate[$itm][] = $k;
                }
            }
        }
        return $duplicate;
    }

}

?>