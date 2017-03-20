<?php
class HtmlParser{
    public $dom;
    public function __construct($html){
        /*** Ignore warning from php dom ***/
        libxml_use_internal_errors(true);
        $this->dom = new DOMDocument;
        libxml_clear_errors();
        /*** load the html into the object ***/
        $this->dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    }

}
?>