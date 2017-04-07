<?php
include 'class/class.ContrastRatio.inc';
include 'class/class.ParseHtmlSelector.inc';


//var_dump($cssBgColor->cssColor);

$html= file_get_contents('temp2.html');
$css = file_get_contents('css/2.css');

$contrast = new ContrastMerge($html, $css);
$contrast->csstoSelectorHtml();

class ContrastMerge{
    public $nodeWithValue;
    public $foregroundProp;
    public $backgroundProp;

    public function __construct($html, $css){
        $htmlParse = new SelectorParser($html);
        $foregound = new CssParser($css);
        $background = new CssParser($css);
        $this->nodeWithValue = $htmlParse->nodeWithValue;
        $this->foregroundProp = $foregound->cssColor;
        $this->backgroundProp = $background->cssBackground;
    }
    public function csstoSelectorHtml(){
        foreach ($this->foregroundProp as $key=>$item){
            switch ($item['selectorDecType']){
                case 'basic':
                    $this->basicSelector($key);
                    break;
                case 'non basic':
                   // echo "This is non basic not ready to be procecced<br>";
                    break;
            }
        }
    }
    public function basicSelector($index){
        //Get selector name
        $selectorType = $this->foregroundProp[$index]['selectorType'];
        $selectorName = $this->foregroundProp[$index]['selector'];
        if ($selectorType == 'class'){
            $this->applyColor2Html($selectorName);
        }
        //Find selector name in the path
        //Mark the path
        //Basic only process the last selector in the path
    }
//Basic Selector
//Group Selector
//Decendent Selector
//Child Combinator
//Adjacent Sibling Combinator
//General Sibling Combinator

    public function applyColor2Html($selector){
        $selector = substr($selector, 1);
        foreach ($this->nodeWithValue as $item){
            echo $item['class'].' == '.$selector.'<br>';
            if ($item['class'] == $selector){
                echo 'line ini sma';
            }
        }
    }
}


?>