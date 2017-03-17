<?php
class SelectorParser{
    public $DOMNodelist;
    public $nodeWithValue;
    public function __construct($html){
        libxml_use_internal_errors(true);
        $dom = new DOMDocument;
        libxml_clear_errors();
        /*** load the html into the object ***/
        $dom->loadHTML($html);
        $this->DOMNodelist = $dom->getElementsByTagName('*');
        $this->nodeWithValue = $this->nodeValue();
    }

    public function parse_html(){
        $allnodeprop = array();
        foreach ( $this->DOMNodelist as $i=>$node) {
            if (preg_match('/(head|script|style)/', $node->getNodePath()) == 0)// Remove head or script and style
                if (!empty($node->nodeValue)){
                    $allnodeprop[$i] = array(
                        'path' => $node->getNodePath(),
                        'value' => $node->nodeValue,
                    );
                }
        }
        return $allnodeprop;
    }

    public function nodeValue(){
        $nodeWithVal = array();
        $indexWithValue = $this->parse_value($this->parse_html());
        foreach ( $this->DOMNodelist as $i=>$node) {
            foreach ($indexWithValue as $k=>$value){
                if ($i==$k){
                    $nodeWithVal[$k] = array(
                        'path' => $node->getNodePath(),
                        'value' => $node->nodeValue,
                        'line' => $node->getLineNo(),
                        'selector' => $node->nodeName,
                        'class' => $node->getAttribute('class'),
                        'id' => $node->getAttribute('id'),
                        'style' => $node->getAttribute('style'),
                    );
                }
            }
        }
        return $nodeWithVal;
    }
    //Path numberic every of them contain all properties
    //which will be used for color checking
    public function real_path($allvalue, $index){
        $pathr = array();
        $p = explode("/", $allvalue[$index]['path']);
        for($n=count($p)-1; $n>0; $n--){
            $path_partial = implode("/", array_slice($p, 1, $n));
            foreach ($allvalue as $key=>$pth){
                if ($path_partial == substr($pth['path'], 1)){
                    array_push($pathr, $key);
                }
            }

        }
        return $pathr;
    }

    //Gather all node which had value only
    public function parse_value($allvalue){
        $value = array();
        $a2 = array(); //every individual value
        $indexWithValue = array();
        $a1 = preg_split("/\\r\\n|\\r|\\n/", trim( $allvalue[0]['value'])); //Gether individual value
        $a1 = preg_grep('/^\s*\z/', $a1, PREG_GREP_INVERT); //Remove empty array
        foreach ($a1 as $itm){array_push($a2, trim($itm));}

        foreach ( $allvalue as $key=>$itm){
            $value[$key] = trim( $itm['value']); //trim value so it will be comparable to eachother
        }
        krsort($value); // Reverse the array for array_unique() to kept the last value instead of the first
        $value = array_unique($value, SORT_REGULAR);
        ksort($value); // Revert back  just to make it readible
        foreach ($value as $key=>$item){
            foreach ($a2 as $item2){
                if ($item == $item2){
                    $indexWithValue[$key] = $item;
                }
            }
        }
        return $indexWithValue;
    }
}
?>