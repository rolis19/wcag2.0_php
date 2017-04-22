<?php

class CheckFrame extends ParseHtml{
    public $nodeFrame;
    public $allFrame;
    public $frameShortTitle;

    public function __construct($html){
        parent::__construct($html);
    }

    public function getFrame(){
        $frame = $this->dom->getElementsByTagName('frame');
        $iframe = $this->dom->getElementsByTagName('iframe');
        $idx = $frame->length;
        foreach ($frame as $k=>$nf){
           if (!$nf->hasAttribute('title')){
               $this->allFrame[$k] = $nf;
           } else if(strlen($nf->getAttribute('title'))<=5){
               $this->frameShortTitle[$k] = $nf;
           }
        }
        foreach ($iframe as $ni){
            $idx++;
            if (!$ni->hasAttribute('title')){
                $this->allFrame[$idx] = $ni;
            } else if(strlen($ni->getAttribute('title'))<=5){
                $this->frameShortTitle[$idx] = $ni;
            }
        }
    }
}


/***
 * Find title in frame or iframe tag
 * frame no longer supported in HTML5
 * iFrme fallback add another text between open and close tag
 * frame fallback adding <noframe> between frameset open and close tag
 *
<div class="block_img">
<frameset rows="80,*" frameborder="no" framespacing="0" border="0">
<frame src="titlebar.html" title="Title">
<frameset cols="175,*" frameborder="no" framespacing="0" border="0">
<frame src="mainmenu.html" name="mainmenu">
<frame src="initialcontent.html" title="Page Content" name="content">
</frameset>
</frameset>
</div>
 *
<div class="block_img">
<iframe title="Survey Form Frame" src="https://spreadsheets.google.com/embeddedform?formkey=" width="760" height="820" frameborder="0" marginheight="0" marginwidth="0">Loading...
</iframe>
</div>
 */
?>
