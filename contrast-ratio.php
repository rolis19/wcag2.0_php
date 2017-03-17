<?php
include 'class/class.ContrastRatio.inc';
include 'class/class.ParseHtmlSelector.inc';

$css = file_get_contents('css/2.css');
$cssBgColor = new CssParser($css);
//var_dump($cssBgColor->cssColor);

$html= file_get_contents('temp-html-file.html');
$htmlParse = new SelectorParser($html);
//var_dump($htmlParse->nodeWithValue);

//Basic Selector
//Group Selector
//Decendent Selector
//Child Combinator
//Adjacent Sibling Combinator
//General Sibling Combinator

?>