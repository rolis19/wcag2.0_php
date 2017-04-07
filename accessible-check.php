<?php
/***
 * For now showing code and download button only trigerred from img check
 */
function imgNoAlt(){
    $img = new CheckingImg($this->html);
    $all = count($img->imgnoAlt);
    $count = 0;
    foreach ($img->imgnoAlt as $key=>$img){
        $count++;
        $img_tag = $img['imgTag'];
        $line = $img['line'];
        form_correct($img_tag, 'img', $line, $key, '');
        if ($count == $all){
            show_code(); //Show download button and inserted code
        }
    }
}

function docLangCheck(){
    $lang = new CheckingLangDoc($this->html);
    /*** Suppose will always be only one HTML tag */
    $docType = $lang->nodeLang['docType'];
    $docLang = $lang->nodeLang['langVal'];
    if ($docType == 'html'){
        if (empty($docLang)){
            $message = 'HTML documents don\'t have specific language';
            echo "Masuk error bro";
        } else {
            $lang = 'Language defined as '.$docLang;
            display_auto($lang, 'basic-list','lang-check', 'langInfo');
        }
    }else {
        $message = "Document language is not defined ";
        $xmlLang = $lang->nodeLang['xmlLangVal'];
        if (empty($docLang) || empty($xmlLang)){
            display_error($message, 'id-check-empty', 'idInfo');
        } else {
            echo 'Masuk Basic info bro';
        }
    }
}

function onChangeCheck(){
    $onChange = new CheckingOnChange($this->html);
    if (!empty($onChange->selectOnChange)) {
        $class = 'onchange-check';
        $message = '<code>select</code> element may cause extreme change due to <samp>onchange()</samp>';
        display_alert($message, $class, 'onchangeInfo');
        $number=0;
        $onchange_txt = array();
        foreach ($onChange->selectOnChange as $item) {
            $number++;
            array_push($onchange_txt, "<li><samp>".$number.".Line <a href='#' onclick='toLine(".$item['line'].")'>".$item['line']."</a></samp></li>");
        }
        display_child_few(implode('', $onchange_txt), 'alert-list', $class, 'onchange-list');
    }

}


?>