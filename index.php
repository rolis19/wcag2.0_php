<?php
include 'display-message.php';
include 'class-check/class.CheckImg.inc';
include 'class-check/class.DocLanguage.inc';
include 'class-check/class.OnChange.inc';
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
session_start();
ini_set('max_execution_time', 300);
?>
<!DOCTYPE html>
<html lang="en">
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
    <meta property="og:type" content="article"/>
	<title>Php Web Accessibility</title>
	<link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.smooth-scroll.js"></script>
    <script src="js/classie.js"></script>
</head>
<body>
	<header>
	</header>
    <!--        More info with fault-->
    <div class="menu-wrap">
        <a class="close-button btn btn-sm btn-warning pull-right" id="close-button">Close <i class="glyphicon glyphicon-remove"></i></a>
        <div class="info-container">
            <div id="explanation"></div>
            <div id="instruction"></div>
            <div id="technique"></div>
            <a href="#official" class="btn btn-info btn-tag" data-toggle="collapse">
                Read Official Guideline <i class="glyphicon glyphicon-chevron-down"></i>
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
                        <a href="http://localhost/learn" class="btn btn-success">New Check</a>
                        <div class="showcode-container">
                            <?php
                            function show_code(){
                                echo <<< END
                                    <script type="text/javascript">
                                        document.getElementById("showcode").style.display = "block";
                                        document.getElementById("allform").style.display ="none" ;
                                    </script>
END;
                                download_btn();
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
                        get_heading($this->html);
                        $this->onChangeCheck();
                        check_orderedlist($this->html);
                        $fix_icon = fix_glyph_icon($this->html);

                        get_italic($fix_icon);


                        $this->docLangCheck();
                        $this->errorGroup(); //work allocation

                    }

                    //Work allocation here
                    public function errorGroup(){
                        echo <<< END
                        <div role="tabpanel" class="tab-pane" id="error">
                        <ul id="error-list">
                        <li class="img-list-error">Img tag doesn't have 'alt' properties 
                        <a href='#' id='open-button' class='btn btn-sm btn-info' onclick="revealInfo('open-button', 'img')">
                        More info</a>
                        <a class="btn btn-success btn-sm " role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseImg">
                            <i class="glyphicon glyphicon-menu-down"></i>
                        </a></li>
            
                        <div id="collapseImg" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" style="height: 0px;" aria-expanded="false">
                        <div class="panel-body">
END;
                        $this->imgNoAlt();
                        echo <<< END
                        </div>
                        </div>
                        </ul>
                        </div>
END;
                    }

                    //===================   Check img Tag Process    ==========================================
                    /***
                     * For now showing code and download button only trigerred from img check
                     */
                    public function imgNoAlt(){
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

                    public function docLangCheck(){
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

                }
                ?>
                <div class="col-md-6 bottom">
                    <!-- Nav tabs -->
                    <ul id="nav-tab" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#auto" aria-controls="home" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-ok-circle"></i> Basic & Autocorrect</a></li>
                        <li role="presentation" id="li-error"><a href="#error" aria-controls="error" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-remove-circle"></i> Errors <span class="bubble" id="b-error"></span></a></li>
                        <li role="presentation" id="li-alert"><a href="#alert" aria-controls="alert" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-warning-sign"></i> Alert <span class="bubble" id="b-alert"></span></a></li>
                        <li role="presentation"><a href="#outline" aria-controls="outline" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-list-alt"></i> Outline</a></li>
                        <li role="presentation"><a href="#contrast" aria-controls="outline" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-eye-open"></i> Contrast</a></li>
<!--                        <li><a href="#" class="btn btn-download disabled"><i class="glyphicon glyphicon-file"></i> Download</a></li>-->
                    </ul>
                    <div class="content-correct">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="auto">
                                <ul id='basic-list'></ul>
                                <ul id='auto-list'>
                                    <h3 id="info-intro" class="text-center" style="padding: 18px 12px; width: 80%; margin: 120px auto 0;">Your check's result soon <br> <small>will be apeared here <br> <i class="glyphicon glyphicon-flash"></i> </small></h3>
                                </ul>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="alert">
                                <ul id='alert-list'>
                                </ul>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="contrast">
                                <ul id='contrast-list'>
                                </ul>
                            </div>
                            <?php
                                //Program start here for insert code
                                if (isset($_POST['stage']) && ('process' == $_POST['stage'])) {
                                    $all_array = $_POST['cekode'];
                                    $myfile = fopen("temp-html-file.html", "w") or die("Unable to open file!");
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
                                    $myfile = fopen("temp-html-file.html", "w") or die("Unable to open file!");
                                    if (empty($all_array)){
                                        fwrite($myfile, "Can't obtain page from URL");
                                    } else {
                                        fwrite($myfile, $all_array." ");
                                    }
                                    fclose($myfile);
                                    $main_array = new mainArray($all_array);
                                    $main_array->tag_check();
                                    display_code();
                                }
                                function display_code(){
                                    $str_get= file_get_contents('temp-html-file.html');
                                    $arr_line = preg_split("/\\r\\n|\\r|\\n/", $str_get);
                                    echo '<script type="text/javascript">';
                                    for ($i=0; $i<count($arr_line); $i++){
                                        echo '$(".showcode-container").append("<pre id=line'.($i+1).' class=line>'.($i+1).' '.$arr_line[$i].'</pre>");';
                                    }
                                    echo '</script>';
                                }
                                function download_btn(){ //to call download button only when code checked and displayed
                                    echo "<hr>";
                                    echo "<a id='selesai' class='btn btn-info'>";
                                    echo "<i class='glyphicon glyphicon-save-file'></i> Finish & Download";
                                    echo "</a>";
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
    <script>
//        $(document).ready(function(){
//            $(window).load(function(){
//                var size = $('.col-md-6 .form-container').length;
//                document.getElementById("b-alert").innerHTML = +size+;
//            })
//        });
    </script>
</body>
</html>