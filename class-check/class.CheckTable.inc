<?php
//include ('class/class.ParseHtml.inc');
/**
 * Created by PhpStorm.
 * User: Rolies
 * Date: 4/23/2017
 * Time: 1:03 AM
 */
class CheckTable extends ParseHtml{
    public $tableDecor;
    public $thNoScope;
    public $tableNoTh;

    public function __construct($html){
        parent::__construct($html);
        // $this->dom is variable from HtmlParser

    }

    public function setChildTbl(){
        $tbl = $this->dom->getElementsByTagName('table');
        foreach ($tbl as $k=>$item){
            if ($item->getElementsByTagName('div')->length != 0 || $item->getElementsByTagName('form')->length != 0){
                $this->tableDecor[$k] = $item;
            }else if($item->getElementsByTagName('th')->length == 0){
                $this->tableNoTh[$k] = $item;
            }
        }
    }

    public function setTh(){
        $th = $this->dom->getElementsByTagName('th');
        foreach ($th as $k=>$node){
            if (!$node->hasAttribute('scope') || $node->getAttribute('scope') != null){
                $this->thNoScope[$k] = $node;
            }
        }
    }

}


/**
 * If Table child contain one of the following tag, then table might used for decorative purpose
 * <div>, <form>
 */