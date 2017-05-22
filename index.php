<?php
include 'display-message.php';
include 'class-check/class.CheckImg.inc';
include 'class-check/class.DocLanguage.inc';
include 'class-check/class.OnChange.inc';
include 'class-check/class.CheckItalic.inc';
include 'class-check/class.CheckOl.inc';
include 'class-check/class.CheckDuplicateID.inc';
include 'class-check/class.CheckInput.inc';
include 'class-check/class.CheckButton.inc';
include 'class-check/class.CheckFrame.inc';
include 'class-check/class.CheckTitle.inc';
include 'class-check/class.CheckLink.inc';
include 'class-check/class.CheckTable.inc';
include 'class-check/class.CheckIcon.inc';

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
session_start();
ini_set('max_execution_time', 300);
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="utf-8"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes"/>
    <meta property="og:image" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:title" content=""/>
    <meta property="og:description" content=""/>
    <meta name="description" content=""/>
    <link rel="canonical" href=""/>
    <link rel="shortcut icon" href="favicon.png">
    <meta property="og:type" content="article"/>
	<title>Web Accessibility</title>
	<link rel="stylesheet" href="css/bootstrap.css">
    <link href="http://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.smooth-scroll.js"></script>
    <script src="js/classie.js"></script>
    <script src="http://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/shortcuts/inview.min.js"></script>
</head>
<body onload="showNotif()">
	<header>
	</header>
    <!--        More info with fault-->
    <div class="menu-wrap">
        <a class="close-button btn btn-sm btn-warning pull-right" id="close-button">Close <i class="glyphicon glyphicon-remove"></i></a>
        <div class="info-container">
            <div id="explanation"></div>
            <div id="instruction"></div>
            <div id="technique"></div>
            <a href="#official" class="btn btn-info btn-tag" data-toggle="collapse" style="display: none">
                Read the Algorithm <i class="glyphicon glyphicon-chevron-down"></i>
            </a>
            <div id="official" class="collapse">

            </div>
        </div>
    </div>
    <div class="content-wrap">
        <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 top">
                    <div class="all-form" id="allform">
                        <ul class="nav nav-pills pull-left" style="width: 170px">
                            <li class="active"><a data-toggle="pill" href="#home">HTML TAG</a></li>
                            <li><a data-toggle="pill" href="#menu1">URL</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <form action="" method="post">
                                    <button class="btn btn-success" id="check" type="submit"><strong>CHECK</strong> <i class=" glyphicon glyphicon-check"></i></button>
                                    <div class="form-group">
                                        <textarea class="form-control" name="cekode" id="cek" cols="80" rows="8"></textarea>
                                        <input type="hidden" name="stage" value="process">
                                    </div>

                                </form>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <form action="" method="post">
                                    <button class="btn btn-success" id="check" type="submit"><strong>CHECK</strong> <i class=" glyphicon glyphicon-check"></i></button>
                                    <div class="form-group">
                                        <textarea class="form-control url" id="url" name="cekodeurl"></textarea>
                                        <input type="hidden" name="stageurl" value="process">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="show-code" id="showcode">
                        <a href="http://rolies.me/wcag/" class="btn btn-success">New Check</a>
                        <div class="showcode-container">
                            <?php
                            function show_code(){
                                echo <<< END
                                    <script type="text/javascript">
                                        document.getElementById("showcode").style.display = "block";
                                        document.getElementById("allform").style.display ="none" ;
                                    </script>
END;
                            }
                            ?>
                        </div>
                    </div>
                </div>
<!-- =============================================== Start Class-->
                <?php
                class mainArray{
                    public $html;
                    public $all_text;
                    public $error = array();
                    public $warn = array();
                    public $testCount= array();

                    public function __construct($all_text){
                        /***
                         * Saving to newfile.html,
                         * will be used for correcting
                         */
                        $my_file = fopen("newfile.html", "w") or die("Unable to open file!");
                        fwrite($my_file, htmlspecialchars_decode($all_text));
                        fclose($my_file);
                        $this->html= htmlspecialchars_decode($all_text);
                    }

                    //Find tag, also their index
                    public function tag_check(){
                        if(filesize("newfile.html") != 0){
                            $this->docLangCheck();
                            $this->imgBlankAlt();
                            $this->imgNoAlt();
                            $this->checkInput();
                            $this->checkLink();
                            $this->checkTitle();
                            get_heading($this->html);
                            $this->onChangeCheck();
                            $this->italicCheck();
                            $this->olCheck();
                            $this->checkIcon();
                            $this->checkId();
                            $this->checkButton();
                            $this->checkFrame();
                            $this->checkTable();
                            show_code();

                            pieCode(strlen($this->html), array_sum($this->error), array_sum($this->warn));
                            testGraph($this->testCount);

                        } else {
                            // Jika gagal parsing html
                        }
                    }

                    //===================   Check img Tag Process    ==========================================
                    /***
                     * For now showing code only trigerred from img check
                     */
                    public function imgNoAlt(){
                        $img = new CheckImg($this->html);
                        // REPORT
                        array_push($this->error, $img->imgError);
                        array_push($this->testCount, count($img->imgnoAlt));
                        // END REPORT
                        $message = 'Img tag doesn\'t have \'alt\' properties';
                        $class = 'img-list-error';
                        $id_panel = 'panel_imgerror';
                        if (!empty($img->imgnoAlt)){
                            display_error($message, $class, 'img', $id_panel, "<i class='glyphicon glyphicon-menu-down'></i>");
                            foreach ($img->imgnoAlt as $key=>$img){
                                $tag_full = $img['imgTag'];
                                $ln = $img['line'];
                                displayChildError($id_panel, $tag_full, $ln, $key,'img');
                            }
                        }
                        //Freed memory
                        $img = null;
                    }

                    public function imgBlankAlt(){
                        $img = new CheckImg($this->html);
                        $class = 'blank-img-info';
                        array_push($this->testCount, count($img->imgBlankAlt));
                        array_push($this->warn, $img->imgWarn);
                        if (!empty($img->imgBlankAlt)){
                            $msgChild="";
                            $message = "Image with blank alt properties";
                            $id_panel = 'panel_imgalert';
                            display_alert($message, $class, 'img', $id_panel, 'collapse', "<i class='glyphicon glyphicon-menu-down'></i>");
                            foreach ($img->imgBlankAlt as $key=>$img){
                                $line = $img['line'];
                                $src = $img['src'];
                                $msgChild .= "<li><samp>Line <a href='#' onclick='toLine(".$line.")'>".$line."</a> $src</samp></li>";
                            }
                            displayChildAlert($msgChild, $id_panel);
                        }
                        $img = null;
                    }

                    public function checkInput(){
                        $input = new CheckInput($this->html);
                        $inputWithFault=array();
                        $inputWithFaultLabel=array();
                        if (!empty($input->getLabel())){
                            //Check if label present in the code
                            $k=0; $l=0;
                            foreach ($input->getLabel() as $nl){
                                foreach ($input->inputWithFault as $key=>$ni){
                                    if ($ni->getLineNo()-1 == $nl->getLineNo()) {
                                        $l++;
                                        $inputWithFaultLabel[$l] = $ni;
                                    }else {
                                        $k++;
                                        $inputWithFault[$k] = $ni;
                                    }
                                }
                            }
                        } else {
                            if (count($input->inputWithFault) != 0) {
                                $class = 'input-error';
                                $id_panel = 'panel_input';
                                $message = 'Input with no label should add aria-label';
                                $countError =0;
                                display_error($message, $class, 'input', $id_panel, "<i class='glyphicon glyphicon-menu-down'></i>");
                                foreach ($input->inputWithFault as $key => $ni) {
                                    $countError += strlen($input->dom->saveXML($ni));
                                    $tag_full = htmlspecialchars($input->dom->saveXML($ni));
                                    $ln = $ni->getLineNo();
                                    displayChildError($id_panel, $tag_full, $ln, $key, 'input');
                                }
                                array_push($this->testCount, count($input->inputWithFault));
                                array_push($this->error, $countError);
                            }

                        }

                        if (count($inputWithFault) != 0){
                            $class = 'input-error';
                            $id_panel = 'panel_input';
                            $message = 'Input with no label should add aria-label';
                            display_error($message, $class, 'idInfo', $id_panel, "<i class='glyphicon glyphicon-menu-down'></i>");
                            $countError =0;
                            foreach ($inputWithFault as $key=>$ni) {
                                $countError += strlen($input->dom->saveXML($ni));
                                $tag_full = htmlspecialchars($input->dom->saveXML($ni));
                                $ln = $ni->getLineNo();
                                displayChildError($id_panel, $tag_full, $ln, $key, 'input');
                            }
                            array_push($this->error, $countError);
                        }
                        if (count($inputWithFaultLabel) != 0){
                            $message = 'Input to be processed with label';
                            $class = 'input-label-error';
                            $id_panel = 'panel_input-label';
                            display_error($message, $class, 'idInfo', $id_panel, "<i class='glyphicon glyphicon-menu-down'></i>");
                            $countError =0;
                            foreach ($inputWithFaultLabel as $key=>$ni) {
                                $countError += strlen($input->dom->saveXML($ni));
                                $tag_full = htmlspecialchars($input->dom->saveXML($ni));
                                $ln = $ni->getLineNo();
                                displayChildError($id_panel, $tag_full, $ln, $key, 'input');
                            }
                            array_push($this->error, $countError);
                        }
                        //is line before equal to label tag
                        //if yes work to make both sync
                        //if no work to make input accessible

                        //Freed memory
                        $input = null;
                    }

                    public function checkLink(){
                        $link = new checkLink($this->html);
                        $link->setLink();
                        array_push($this->testCount, count($link->blankLinkTxt), count($link->blankLink), count($link->sortLinktxt));
                        $countErr=0;
                        if (count($link->blankLinkTxt) != 0){
                            $message = 'Link contain no text description';
                            $class = 'linka-list-error';
                            $id_panel = 'panel_linkaerror';
                            display_error($message, $class, 'linkInfo', $id_panel, "<i class='glyphicon glyphicon-menu-down'></i>");
                            foreach ($link->blankLinkTxt as $key=>$node){
                                $countErr += strlen($link->dom->saveXML($node));
                                $tag_full = htmlspecialchars($link->dom->saveXML($node));
                                $ln = $node->getLineNo();
                                displayChildError($id_panel, $tag_full, $ln, $key,'img');
                            }
                        }
                        if (count($link->blankLink) != 0){
                            $message = 'Link contain no destination';
                            $class = 'linkb-list-error';
                            $id_panel = 'panel_linkberror';
                            display_error($message, $class, 'linkInfo', $id_panel, "<i class='glyphicon glyphicon-menu-down'></i>");
                            foreach ($link->blankLink as $k=>$node){
                                $countErr += strlen($link->dom->saveXML($node));
                                $tag_full = trim(preg_replace('/\s+/', ' ', htmlspecialchars($link->dom->saveXML($node))));
                                $ln = $node->getLineNo();
                                //form_correct($tag_full, 'img', $ln, $key, '');
                                displayChildError($id_panel, $tag_full, $ln, $k,'img');
                            }
                        }
                        array_push($this->error, $countErr);
                        if (count($link->sortLinktxt) != 0){
                            $msgChild="";
                            $class = 'short-link-info';
                            $message = "Link contain sort description";
                            $id_panel = 'panel_linkalert';
                            display_alert($message, $class, 'linkInfo', $id_panel, 'collapse', "<i class='glyphicon glyphicon-menu-down'></i>");
                            $countWarn=0;
                            foreach ($link->sortLinktxt as $node){
                                $countWarn += strlen($link->dom->saveXML($node));
                                $line = $node->getLineNo();
                                $tag = trim(preg_replace('/\s+/', ' ', $node->nodeValue));
                                $msgChild .= "<li><samp>Line <a href='#' onclick='toLine(".$line.")'>".$line."</a> $tag</samp></li>";
                            }
                            array_push($this->warn, $countWarn);
                            displayChildAlert($msgChild, $id_panel);
                        }
                        $link = null;
                    }

                    public function checkButton(){
                        $button = new CheckButton($this->html);
                        $button->getButton();
                        if (!empty($button->btnWithEnt)){
                            $message = 'Button infromation contain HTML entity';
                            $class = 'btn-list-error';
                            $id_panel = 'panel_btnerror';
                            display_error($message, $class, 'langInfo', $id_panel, "<i class='glyphicon glyphicon-menu-down'></i>");
                            $countError= 0;
                            foreach ($button->btnWithEnt as $key=>$node){
                                $countError += strlen($button->dom->saveXML($node));
                                $tag_full = htmlspecialchars($button->dom->saveXML($node));
                                $ln = $node->getLineNo();
                                displayChildError($id_panel, $tag_full, $ln, $key,'input');
                            }
                            array_push($this->testCount, count($button->btnWithEnt));
                            array_push($this->error, $countError);
                        }

                        if(!empty($button->btnWithLessInfo)){
                            $message = 'Button contain short infromation';
                            $class = 'btn-list-alert';
                            $id_panel = 'panel_btnalert';
                            $msgChild="";
                            if (count($button->btnWithLessInfo) <= 3){
                                display_alert($message, $class, 'langInfo', $id_panel, 'no-collapse', "");
                            } else {
                                display_alert($message, $class, 'langInfo', $id_panel, 'collapse', "<i class='glyphicon glyphicon-menu-down'></i>");
                            }
                            $countWarn =0;
                            foreach ($button->btnWithLessInfo as $key=>$node){
                                $countWarn += strlen($button->dom->saveXML($node));
                                $value = $node->nodeValue;
                                $tag_full = htmlspecialchars("<button> $value </button>");
                                $line = $node->getLineNo();
                                $msgChild .= "<li><samp>Line <a href='#' onclick='toLine(".$line.")'>".$line."</a> $tag_full</samp></li>";
                            }
                            array_push($this->testCount, count($button->btnWithLessInfo));
                            array_push($this->warn, $countWarn);
                            displayChildAlert($msgChild, $id_panel);
                        }
                        $button = null;
                    }

                    //Left pie graph for now
                    public function docLangCheck(){

                        $lang = new DocLanguage($this->html);
                        if ($lang->nodeHtml != null){
                            $lang->setLang();
                            $ln = $lang->nodeHtml->getLineNo();
                            if ($lang->doc == 'html'){
                                if ($lang->nodeHtml->hasAttribute('lang')){
                                    // If language is present to summary
                                    $docLang = trim(preg_replace('/(.*?)-(...?)/', '$1', $lang->nodeHtml->getAttribute('lang'))); // Remove any specific country for now
                                    $str = file_get_contents('class-check/language.txt');
                                    $find = '/Subtag: '.$docLang.' Description:(.+?)\n/';
                                    preg_match_all($find, $str, $matches);
                                    $langName = trim(preg_replace('/\s\s+/', ' ', $matches[1][0]));
                                    $lang = "<strong>Language</strong>: ".$langName;
                                    display_auto($lang, 'basic-list','lang-check', 'langInfoTrue');
                                    displayChangeLang('basic-list', 'lang-check','lang-form',$ln,'html');
                                }else {
                                    //If language is not present to summary and error
                                    $ttl = "<strong>Language</strong>: Not Declared";
                                    display_auto($ttl, 'basic-list','lang-check', 'langInfo');

                                    $message = 'HTML documents don\'t have specific language';
                                    display_error($message, 'id-check-empty', 'idInfo', 'panel_lang', "Change Language");
                                    displayChangeLang('error-list', 'lang-error','lang-form',$ln,'html');
                                }
                            }else {
                                // Language defined as xml
                                if (!$lang->nodeHtml->hasAttribute('lang')){
                                    $ttl = "<strong>Language</strong>: Not Declared";
                                    display_auto($ttl, 'basic-list','lang-check', 'langInfo');

                                    $message = 'HTML documents don\'t have specific language';
                                    display_error($message, 'id-check-empty', 'idInfo', 'panel_lang', "Change Language");
                                    displayChangeLang('error-list', 'lang-error','lang-form',$ln,'html');
                                }
                            }
                        }else {
                            //HTML tag not found
                            $message = 'HTML documents don\'t have specific language';
                            display_error($message, 'lang-error', 'langInfo', 'panel_lang', "Change Language");
                            $ttl = "<strong>Language</strong>: Not Declared";
                            display_auto($ttl, 'basic-list','lang-check', 'langInfo');
                        }
                        $lang = null;
//                        if ($docType == 'html'){
//                            if (empty($docLang)){
//                                $message = 'HTML documents don\'t have specific language';
//                                display_error($message, 'lang-error', 'idInfo', 'panel_lang', "Change Language");
//                                displayChangeLang('error-list', 'lang-error','lang-form',$ln,'html');
//                            } else {
//                                $str = file_get_contents('class-check/language.txt');
//                                $find = '/Subtag: '.$docLang.' Description:(.+?)\n/';
//                                preg_match_all($find, $str, $matches);
//                                $langName = trim(preg_replace('/\s\s+/', ' ', $matches[1][0]));
//                                $lang = "Language defined as ".$langName;
//                                display_auto($lang, 'basic-list','lang-check', 'langInfo');
//                                displayChangeLang('basic-list', 'lang-check','lang-form',$ln,'html');
//                            }
//                        }else {
//                            $message = "Document language is not defined ";
//                            $xmlLang = $lang->nodeLang['xmlLangVal'];
//                            if (empty($docLang) || empty($xmlLang)){
//                                display_error($message, 'id-check-empty', 'idInfo', 'panel_lang', "Change Language");
//                            } else {
//                                echo 'To be included inside basic group';
//                            }
//                        }
                    }

                    public function onChangeCheck(){
                        $onChange = new OnChange($this->html);
                        if (!empty($onChange->selectOnChange)) {
                            $class = 'onchange-check';
                            $id_panel = 'panel_onchgalert';
                            $message = '<code>select</code> tag may cause extreme modification due to <samp>onchange()</samp>';
                            display_alert($message, $class, 'onchangeInfo', $id_panel, 'no-collapse', '');
                            $onchange_txt="";
                            $onchange_txt .="<li><samp>Line</samp></li>";
                            foreach ($onChange->selectOnChange as $item) {
                                $onchange_txt .= "<li><samp><a href='#' onclick='toLine(".$item['line'].")'>".$item['line']."</a></samp></li>";
                            }
                            array_push($this->warn, $onChange->countWarn);
                            displayChildAlert($onchange_txt, $id_panel);
                        }
                        $onChange = null;

                    }

                    public function italicCheck(){
                        $italic_txt = new CheckItalic($this->html);
                        $class = 'italic-info';
                        $italic_line="";
                        if (!empty($italic_txt->nodeItalic->length)){
                            $id_panel = 'panel_italicalert';
                            $message = "Italic format known problem for some people with Dyslexia";
                            if ($italic_txt->nodeItalic->length >= 3){
                                display_alert($message, $class, 'italicInfo', $id_panel, 'collapse', "<i class='glyphicon glyphicon-menu-down'></i>");
                            } else {
                                display_alert($message, $class, 'italicInfo', $id_panel, 'no-collapse', '');
                            }
                            $countWarn =0;
                            foreach ($italic_txt->nodeItalic as $item) {
                                $countWarn += strlen($italic_txt->dom->saveXML($item));
                                $tag = htmlspecialchars(" <em>$item->nodeValue</em> ");
                                $ln = $item->getLineNo();
                                $italic_line .= "<li><samp>Line <a href='#' onclick='toLine(".$ln.")'>".$ln."</a> $tag</samp></li>";
                            }
                            array_push($this->warn, $countWarn);
                            displayChildAlert($italic_line, $id_panel);
                        }else {
                            $message = 'No italic style found';
                            display_auto($message, 'auto-list',$class, 'italicInfoTrue');
                        }
                        $italic_txt = null;
                    }

                    public function olCheck(){
                        $ordered = new CheckOl($this->html);
                        $orderedLine="";
                        $class = 'orderlist_check';
                        if (!empty($ordered->ordList)){
                            $message = 'Ordered list <code>&lt;ol&gt;</code> probably misused';
                            $id_panel = 'panel_ordlstalert';
                            display_alert($message, $class, 'olInfo', $id_panel,'no-collapse', '');
                            $orderedLine .= "<li><samp>Line</samp></li>";
                            foreach ($ordered->ordList as $item) {
                                $orderedLine .= "<li><samp><a href='#' onclick='toLine(".$item['line'].")'>".$item['line']."</a></samp></li>";
                            }
                            displayChildAlert($orderedLine, $id_panel);
                            array_push($this->warn, $ordered->countWarn);
                        }else {
                            $message = 'No ordered list found';
                            display_auto($message, 'auto-list', $class, 'olInfoTrue');
                        }
                        $ordered = null;
                    }

                    public function checkId(){
                        $id = new CheckDuplicateID($this->html);
                        $count = array();
                        if (!empty($id->duplicateId)){
                            $message = "";
                            $class= 'idalert';
                            $message1 = "Duplicate ID found";
                            $id_panel='panel_idalert';
                            display_alert($message1, $class, 'idInfo', $id_panel,'no-collapse', '');
                            $countWarn=0;
                            $allid=0;
                            foreach ($id->duplicateId as $item=>$key){
                                $message .= '<li><samp>'.$item.'</samp></li>';
                                $count[$item] = count($key);
                                $allid += count($key);
                                foreach ($key as $line){
                                    $countWarn += strlen($item);
                                    $message .= "<li><samp><a href='#' onclick='toLine(".$line.")'>".$line."</a></samp></li>";
                                }
                                $message .= '<br>';
                            }
                            array_push($this->warn, $countWarn);
                            displayChildAlert($message, $id_panel);
                            array_push($this->testCount, $allid);

                        } else {
                            $message_no =  "No duplicate ID found";
                            display_auto($message_no, 'auto-list','id-check', 'idInfoTrue');
                        }
                        $id = null;
                    }

                    public function checkFrame(){
                        $frame = new CheckFrame($this->html);
                        $frame->getFrame();
                        if (!empty($frame->allFrame)){
                            $class = 'frame-error';
                            $id_panel = 'panel_frameerror';
                            $message = 'Frame need title attribute';
                            display_error($message, $class, 'idInfo', $id_panel, "<i class='glyphicon glyphicon-menu-down'></i>");

                            $countErr =0;
                            foreach ($frame->allFrame as $key=>$nf){
                                $countErr += strlen($frame->dom->saveXML($nf));
                                $ln = $nf->getLineNo();
                                $tag_full = htmlspecialchars($frame->dom->saveXML($nf));
                                displayChildError($id_panel, $tag_full, $ln, $key, 'input');
                            }
                            array_push($this->error, $countErr);
                            array_push($this->testCount, count($frame->allFrame));
                        }

                        if (!empty($frame->frameShortTitle)){
                            $class = 'frame-alert';
                            $id_panel = 'panel_framealert';
                            $message = 'Frame contain short title';

                            display_alert($message, $class, 'idInfo', $id_panel, 'no-collapse', '');
                            $msgChild="";
                            $countWarn=0;
                            foreach ($frame->frameShortTitle as $key=>$nf){
                                $countWarn += strlen($frame->dom->saveXML($nf));
                                $ln = $nf->getLineNo();
                                $tag = htmlspecialchars($frame->dom->saveHTML($nf));
                                $msgChild .= "<li><samp>Line <a href='#' onclick='toLine(".$ln.")'>".$ln."</a> $tag</samp></li>";
                            }
                            displayChildAlert($msgChild, $id_panel);
                            array_push($this->warn, $countWarn);
                            array_push($this->testCount, count($frame->frameShortTitle));
                        }

                        $frame = null;
                    }

                    public function checkTitle(){
                        $title = new checkTitle($this->html);

                        if ($title->title != null){
                            $title->getTitle();
                            $ttl = "<strong>Title</strong><span>: ".trim(preg_replace('/\s+/', ' ', $title->title->nodeValue))."</span>";
                            display_auto($ttl, 'basic-list','ttl-check', 'titleInfoTrue');
                            if ($title->titleFault != null){
                                $class = 'title-alert';
                                $id_panel = 'panel_ttlalert';
                                $line = $title->titleFault->getLineNo();
                                $txt = $title->titleFault->nodeValue;
                                $message = 'Title contain sort information';
                                $msgChild = "<li><samp>Line <a href='#' onclick='toLine(".$line.")'>".$line."</a>: $txt</samp></li>";
                                display_alert($message, $class, 'titleInfo', $id_panel, 'no-collapse', "");
                                displayChildAlert($msgChild, $id_panel);
                                array_push($this->warn, strlen($title->dom->saveXML($title->title)));
                            }
                        }else {
                            //title tag not present error
                            $ttl = "<strong>Title</strong>: Not Declared";
                            display_auto($ttl, 'basic-list','ttl-check', 'titleInfoTrue');
                            array_push($this->error, 10);
                        }
                        $title = null;
                    }

                    public function checkTable(){
                        $tbl = new checkTable($this->html);
                        $tbl->setChildTbl();
                        $tbl->setTh();
                        array_push($this->testCount, count($tbl->tableDecor), count($tbl->tableNoTh), count($tbl->thNoScope));
                        $countErr =0;
                        if (count($tbl->tableDecor) != 0){
                            $message = "table used for decorative purpose";
                            $class = 'tbla-list-error';
                            $id_panel = 'panel_tblaerror';
                            display_error($message, $class, 'tableInfo', $id_panel, "<i class='glyphicon glyphicon-menu-down'></i>");
                            foreach ($tbl->tableDecor as $k=>$node){
                                $countErr += strlen($tbl->dom->saveXML($node));
                                $tag_full = "Table should only used for data tabular, fix manually";
                                $ln = $node->getLineNo();
                                displayChildErrorManual($id_panel, $tag_full, $ln, $k,'tabel');
                            }
                        }
                        if (count($tbl->tableNoTh) != 0){
                            $message = "Table with no header (th)";
                            $class = 'tblb-list-error';
                            $id_panel = 'panel_tblberror';
                            display_error($message, $class, 'tableInfo', $id_panel, "<i class='glyphicon glyphicon-menu-down'></i>");
                            foreach ($tbl->tableNoTh as $k=>$node){
                                $countErr += strlen($tbl->dom->saveXML($node));
                                $tag_full = "Table should have header, fix manually";
                                $ln = $node->getLineNo();
                                displayChildErrorManual($id_panel, $tag_full, $ln, $k,'tabel');
                            }
                        }
                        if (count($tbl->thNoScope) != 0){
                            $message = "Table header does not have scope information";
                            $class = 'tblc-list-error';
                            $id_panel = 'panel_tblcerror';
                            display_error($message, $class, 'tableInfo', $id_panel, "<i class='glyphicon glyphicon-menu-down'></i>");
                            foreach ($tbl->thNoScope as $k=>$node){
                                $countErr += strlen($tbl->dom->saveXML($node));
                                $tag_full = trim(preg_replace('/\s+/', ' ', htmlspecialchars($tbl->dom->saveXML($node))));
                                $ln = $node->getLineNo();
                                displayChildError($id_panel, $tag_full, $ln, $k,'tabel');
                            }
                        }
                        $tbl = null;
                        array_push($this->error, $countErr);
                    }

                    public function checkIcon(){
                        $ico = new checkIcon($this->html);
                        $class ='glyph-check';
                        $ico->getIcon();
                        $messageChild="";
                        if(count($ico->nodeIcon) != 0){
                            $countWarn=0;
                            foreach ($ico->nodeIcon as $node){
                                $countWarn += strlen($ico->dom->saveXML($node));
                                $node->removeAttribute('style');
                                $messageChild .= "<li>".trim(preg_replace('/\s\s+/', ' ',htmlspecialchars($ico->dom->saveHTML($node))))."</li>";
                            }
                            array_push($this->warn, $countWarn);
                            $message ="<strong>icon/s</strong>: ".count($ico->nodeIcon);
                            display_auto($message, 'basic-list', $class, 'glyphInfo');
                            display_child_many($messageChild, 'basic-list', $class, 'panel-success', 'icon-list');
                            array_push($this->testCount, count($ico->nodeIcon));
                        }else {
                            $message = "<strong>icon/s</strong>: 0";
                            display_auto($message, 'auto-list',$class, 'glyphInfoTrue');
                        }

                        $ico = null;
                    }

                }
                ?>
                <div class="col-md-6 bottom">
                    <!-- Nav tabs -->
                    <ul id="nav-tab" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#auto" aria-controls="home" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-ok-circle"></i> Summary</a></li>
                        <li role="presentation" id="li-error"><a href="#error" aria-controls="error" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-remove-circle"></i> Errors <span class="bubble" id="b-error"></span></a></li>
                        <li role="presentation" id="li-alert"><a href="#alert" aria-controls="alert" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-warning-sign"></i> Alert <span class="bubble" id="b-alert"></span></a></li>
                        <li role="presentation"><a href="#outline" aria-controls="outline" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-list-alt"></i> Outline</a></li>
<!--                        <li role="presentation"><a href="#contrast" aria-controls="outline" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> Contrast</a></li>-->
                        <li><a href="newfile.html" download id="download" class="btn btn-download disabled"><i class="glyphicon glyphicon-file"></i> Download</a></li>
                    </ul>
                    <div class="content-correct">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="auto">
                                <ul id='basic-list'></ul>
                                <ul id='auto-list'>
                                    <h3 id="info-intro" class="text-center" style="padding: 18px 12px; width: 80%; margin: 120px auto 0;">Your check's result soon <br> <small>will be apeared here <br> <i class="glyphicon glyphicon-flash"></i> </small></h3>
                                </ul>
                                <div class="summ-info" id="report">
                                    <h3 class="text-center">Report</h3>
                                    <div class="ct-chart" style="width: 100%; height: 300px"></div>
                                    <ul class="col-md-12" style="display:none;">
                                        <li><strong>Level A</strong>: <span id="a">70</span></li>
                                        <li><strong>Level AA</strong>: <span id="aa">32</span></li>
                                        <li><strong>Level AAA</strong>: <span id="aaa">22</span></li>
                                    </ul>

                                    <div class="ct-chart1" style="width: 100%; height: 300px"></div>
                                    <br>
                                    <hr>
                                    <div class="about-report">
                                        <ul>
                                            <li><h4><a href="http://rolies.me/wcag/doc/guide" target="_blank">Check out on what we cover!</a></h4></li>
                                        </ul>
                                        <ul style="display: none">
                                            <li><h3>WCAG 2.0 Guidelines</h3></li>
                                            <li>Percivable: 22</li>
                                            <li>Operable: 20</li>
                                            <li>Understandable: 17</li>
                                            <li>Robust: 2</li>
                                        </ul>
                                        <ul style="display: none">
                                            <li>Level A: 25 Guidelines</li>
                                            <li>Level AA: 13 Guidelines</li>
                                            <li>Level AAA: 23 Guidelines</li>
                                        </ul>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="alert">
                                <ul id='alert-list'>
                                </ul>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="contrast">
                                <ul id='contrast-list'>
                                </ul>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="error">
                                <ul id="error-list">
                                </ul>
                            </div>
                            <?php
                                //Program start here for insert code
                                if (isset($_POST['stage']) && ('process' == $_POST['stage'])) {
                                    $all_array = $_POST['cekode'];
                                    $myfile = fopen("temp2.html", "w") or die("Unable to open file!");
                                    fwrite($myfile, htmlspecialchars($all_array)." ");
                                    fclose($myfile);
                                    $main_array = new mainArray($all_array);
                                    $main_array->tag_check(); //First function to run in class
                                    display_code();
                                }
                                //Program start here for insert url
                                if (isset($_POST['stageurl']) && ('process' == $_POST['stageurl'])) {
                                    function datafeed($url){
                                        $text =  file_get_contents($url);
                                        return $text;
                                    }
                                    $dataraw = datafeed($_POST['cekodeurl']);//raw data tag code
                                    $all_array = htmlspecialchars($dataraw);
                                    $myfile = fopen("temp2.html", "w") or die("Unable to open file!");
                                    if (empty($all_array)){
                                        fwrite($myfile, "Can't exstract code from given URL");
                                    } else {
                                        fwrite($myfile, $all_array." ");
                                    }
                                    fclose($myfile);
                                    $main_array = new mainArray($all_array);
                                    $main_array->tag_check();
                                    display_code();
                                }
                                function display_code(){
                                    $str_get= file_get_contents('temp2.html');
                                    $arr_line = preg_split("/\\r\\n|\\r|\\n/", $str_get);
                                    echo '<script type="text/javascript">';
                                    for ($i=0; $i<count($arr_line); $i++){
                                        echo '$(".showcode-container").append("<pre id=line'.($i+1).' class=line>'.($i+1).' '.$arr_line[$i].'</pre>");';
                                    }
                                    echo '</script>';
                                }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style="height: 10px">
            <div class="row">
                <div class="col-md-12">

                </div>
            </div>
        </div>
    </div>
    </div>
    <footer>
        <?php
        function convert($size){
            $unit=array('b','kb','mb','gb','tb','pb');
            return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
        }
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $finish = $time;
        $total_time = round(($finish - $start), 4);
        echo 'Page generated in '.$total_time.' seconds.<br>';
        echo "Memory: ".convert(memory_get_usage());
        echo " Peak Memory: ".convert(memory_get_peak_usage());
        ?>
    </footer>
    <?php include 'include-accessible-data.php' ?>
    <script src="js/accessible-data-ctr.js"></script>
    <script src="js/main.js"></script>
</body>
<!--Track -->
<!--- Selesaikan Input-->
<!--- Bersihkan display message ketika slow, minimalizir script-->
</html>