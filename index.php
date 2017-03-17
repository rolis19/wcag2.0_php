<?php
include 'display-message.php';
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
                <h2>4. Robust</h2>
                <p class="subtitle">4.1.1 Parsing</p>
                <p>
                    In content implemented using markup languages, elements have complete start and end tags, elements are nested
                    according to their specifications, elements do not contain duplicate attributes, and any IDs are unique,
                    except where the specifications allow these features.
                </p>
                <a href="https://www.w3.org/WAI/WCAG20/quickref/?showtechniques=411" target="_blank" class="pull-right">Source</a>
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
                    public $all_text;
                    public $all_array;
                    public $arr_newline;
                    public $line_with_tag = array();
                    public $checker_list = array('/&lt;img/', '/&lt;input/', '/^id=&quot;(.*?)&quot;/');

                    public function __construct($all_text){
                        $this->all_text = $all_text;
                        //test_par($all_text);
                        doc_lang($all_text);
                        get_heading($all_text);
                        check_onchange($all_text);
                        check_orderedlist($all_text);
                        $fix_icon = fix_glyph_icon($all_text);
                        //check_contrast($all_text);
                        get_italic($fix_icon);
                        $this->arr_newline = preg_split("/\\r\\n|\\r|\\n/", $fix_icon);
                        $my_file = fopen("newfile.html", "w") or die("Unable to open file!");
                        for ($i=0; $i<count($this->arr_newline); $i++){
                            $arrnewline_sterile = sterile_string($this->arr_newline[$i]);
                            $this->all_array[$i] = explode(" ", $arrnewline_sterile);
                            fwrite($my_file, htmlspecialchars_decode($arrnewline_sterile)."\r\n");
                        }
                        fclose($my_file);
                    }

                    //					Use this class every time we need to check the existence of certain word.
                    public function is_exist($word, $start, $end, $array_of){
                        $index = 0;
                        for ($i=$start; $i<$end; $i++){
                            if ($word == $array_of[$i]){
                                $index = $i;
                                //break;
                            }
                        }
                        if ($index==0){
                            return false;
                        } else {
                            return $index;
                        }
                    }
                    //					For slicing every element in array
                    public function subarr ($arrays_of, $start, $length ){
                        $new_sort = array();
                        foreach ($arrays_of as $items){
                            array_push($new_sort, substr($items, $start, $length));
                        }
                        return $new_sort;
                    }

                    //Ignore comments
                    public function get_ride_comment(){
                        $li=0; $po=0;
                        foreach ($this->all_array as $line=>$lines) {
                            foreach ($lines as $position=>$items){
                                if (preg_match('/^&lt;!--/', $items)){
                                    $li = $line;
                                    $po = $position;
                                }
                            }
                        }
                        $cls_comment = $this->next_open_tag($li, $po, '/--&gt;$/');
                        return $this->single_multiline_tag($li, $po, $cls_comment[0], $cls_comment[1]);

                    }
                    //Find tag, also their index
                    public function tag_check(){
                        $j=-1;
//                            $comment = $this->get_ride_comment();
                        foreach ($this->all_array as $line=>$lines) {
                            foreach ($lines as $position=>$items){
//                                    if (in_array($line, $comment)){
//                                        if (!in_array($position, $comment[1])){
//                                            echo $this->all_array[$line][$position];
//                                        }
//                                    } else {
//                                        echo $this->all_array[$line][$position];
//                                    }
                                for ($i = 0; $i < count($this->checker_list); $i++) {
                                    if (preg_match($this->checker_list[$i], $items)){
                                        //Forming array
                                        $j++;
                                        $this->line_with_tag[$j] = array(
                                                'line'=> $line,
                                            'position' => $position,
                                            'tagname' => $items
                                        );
                                    }
                                }
                            }
                        }
                        $this->alloc_work(); //work allocation
                        check_id($this->line_with_tag);

                    }
                    public function debug(){
                        $id_array = array();
                        foreach ($this->line_with_tag as $line){
                            if (preg_match('/id=&quot;(.*?)&quot;/', $line['tagname'])){
                                $a1 = preg_replace('/id=&quot;(.*?)&quot;&gt;/', 'id=&quot;$1&quot;', $line['tagname']);
                                array_push($id_array, $a1);
                            }
                        }
                        //Check duplicate value
                        foreach(array_count_values($id_array) as $key=>$items){
                            if ($items > 1){
                                echo "<code>".$key."</code> Was used for ".$items." times";
                            }
                        }
                    }
                    //Find end tag
                    public function find_close_tag($line, $position){
                        $nd_tag = 0; $line_end=0;
                        $single_tag_arr = array($this->all_array[$line][$position]);
                        for ($n=$line; $n < (count($this->all_array)); $n++){
                            if ($n == $line){$length = ($position+1);} else {$length = 0;}
                            for ($i = $length; $i < (count($this->all_array[$n])); $i++){
                                array_push($single_tag_arr, $this->all_array[$n][$i]);
                                if (preg_match('/&gt;$/', $this->all_array[$n][$i])) {
                                    $nd_tag = $i;
                                    $line_end = $n;
                                    break;
                                }
                            }
                            if ($nd_tag != 0){
                                break;
                            }

                        }
                        if (empty($this->next_open_tag($line, $position, '/&lt;$/'))){ //Suppose last line
                            return $single_tag_arr;
                        }else{
                            $next_open_tag = $this->next_open_tag($line, $position, '/&lt;$/');
                            $next_open_tag = ($next_open_tag[0]+1).$next_open_tag[1];
                            if ($next_open_tag > ($line_end+1).$nd_tag){
                                return $single_tag_arr;
                            } else {
                                return NULL;
                            }
                        }
                    }
                    //Check whether end tag is true, by checking open tag for next element
                    public function next_open_tag($line, $position, $search){
                        $nxt_opn_tag = 0; $line_nxt_open = 0;
                        for ($n=$line; $n < (count($this->all_array)); $n++){
                            if ($n == $line){$length = ($position+1);} else {$length = 0;}
                            for ($i = $length; $i < (count($this->all_array[$n])); $i++){
                                if (preg_match($search, $this->all_array[$n][$i])) {
                                    $nxt_opn_tag = $i;
                                    $line_nxt_open = $n;
                                    break;
                                }
                            }
                            if ($nxt_opn_tag != 0){
                                break;
                            }
                        }
                        if ($nxt_opn_tag == 0 && $line_nxt_open == 0){
                            return 0;
                        } else {
                            return array($line_nxt_open, $nxt_opn_tag);
                        }
                    }

                    public function single_multiline_tag($li1, $po1, $li2, $po2){
                        $single_tag_arr = array();
                        for ($n=$li1; $n < (count($this->all_array)); $n++){
                            array_push($single_tag_arr, $n);
                            $single_tag_arr[$n]= array();
                            for ($i = $po1; $i < (count($this->all_array[$n])); $i++){
                                array_push($single_tag_arr[$n], $i);
                                if ($i == $po2) {
                                    break;
                                }
                            }
//                                $single_tag_arr[$n] = array(1, 2, 3);
                            if ($n == $li2){
                                break;
                            }

                        }
                        return $single_tag_arr;
                    }
                    // After start and end tag found return new array accordingly Snew array equal one tag (open and close)
                    public function single_tag($line, $start_tag, $end_tag){
                        $single_tag_arr = array();
                        for ($n = $start_tag; $n < count($this->all_array[$line]); $n++) {
                            for ($i = $start_tag; $i <= $end_tag; $i++) {
                                array_push($single_tag_arr, $this->all_array[$line][$i]);
                            }
                            break;
                        }
                        return $single_tag_arr;
                    }
                    //======================= End of General function, custom library =======

                    //Work allocation here
                    public function alloc_work(){
                        $end_array = $this->line_with_tag[count($this->line_with_tag)-1]['line'];
                        echo '<div role="tabpanel" class="tab-pane" id="error">';
                        for ($i=0; $i<count($this->line_with_tag); $i++){
                            $line = $this->line_with_tag[$i]['line'];
                            $position = $this->line_with_tag[$i]['position'];
                            $tag_name = $this->line_with_tag[$i]['tagname'];
                            switch ($tag_name) {
                                case (preg_match('/&lt;img ?$/', $tag_name)? true : false): //Img tag
                                    $img_tag = ($this->find_close_tag($line, $position)); //Get end tag index
                                    if (!empty($img_tag)){
                                        $this->img_check($img_tag, $line, $position);
                                    }else {
                                        echo "Unclosed img tag on line ".$line."<br>";
                                    }
                                    break;
                                case (preg_match('/^\t?&lt;input/', $tag_name)? true : false): //Input tag
                                    $input_tag = ($this->find_close_tag($line, $position));
                                    if (!empty($input_tag)){
                                        $this->input_alloc($input_tag, $line, $position);
                                    } else {
                                        echo "Unclosed input tag on line ".$line."<br>";
                                    }
                                    break;
                            }
                            if ($line == $end_array){
                                show_code(); //Show download button and inserted code
                            }
                        }
                        echo '<div>';
                    }

                    public function correct_end_tag($tag_array){
                        echo "<hr />";
                        foreach ($tag_array as $key=>$item){
                            echo "<button id='$key' class='btn correct-close-tag'>".$item."</button> ";
                        }
                    }

                    public function img_check1(){
                        // Ambil indicate position dan line
                        // Form string baru dari indicate position sampe akhir
                        // Cari satu img tag, jika tidak ketemu maka return close tag tidak ketemu
                        // Jika ketemu do img check
                    }
                    //===================   Check img Tag Process    ==========================================
                    public function img_check($img_tag, $line, $start_tag){
                        $indicator = 0;
                        foreach ($img_tag as $img){
                            $img_sort = substr($img, 0, 3);
                            similar_text($img_sort,"alt",$percent);
                            if ($percent > 90){
                                $indicator++;
                            }
                        }
                        if ($indicator >= 1){
                            //alt found
                        } else{
                            if (count($img_tag) <= 2){
                                $words = preg_replace('/(\/?&gt;$)/', ' /&gt;', $img_tag[count($img_tag)-1]);
                                $a2 = explode(' ', $words);
                                array_splice($img_tag, 1, 1, $a2);
                                write_to_fref($line, $start_tag, $img_tag);
                            }
                            form_correct($img_tag, 'img', $line+1, $start_tag+1, '');
                        }
                    }
                    //===================   Check input Tag Process    ==========================================
                    public function input_alloc($input_tag, $line, $start_tag){
                        $label_type = '';
                        $check_arr = $this->subarr($input_tag, 0, 5);
                        foreach ($check_arr as $key=>$item){
                            if ($item == 'type='){
                                $label_type = explode("&quot;", $input_tag[$key]);
                                $label_type = $label_type[1];
                            }
                        }
                        if ($label_type != ''){
                            switch ($label_type){
                                case "text":
                                case "password":
                                case "radio":
                                case "checkbox":
                                    //Html5 new
                                case "color":
                                case "date":
                                case "datetime":
                                case "datetime-local":
                                case "email":
                                case "month":
                                case "number;":
                                case "range":
                                case "search":
                                case "tel":
                                case "time":
                                case "url":
                                case "week":
                                    $this->input_check($input_tag, $line, $start_tag);
                                    break;

                                //below no need any action
                                case "submit":
                                case "image":
                                case "reset":
                                case "button":
                                case "hidden":
                                    break;
                            }
                        } else {
                            echo '<p class="info-other">Undefinied input type in line '.($line+1).'</p>';
                        }
                    }

                    public function input_check($input_tag, $line, $start_tag){
                        $indicator = 0;
                        $input_tags = implode(" ", $input_tag);
                        //Create new array based on double quote
                        $input_tags = explode("&quot;", $input_tags);
                        foreach ($input_tags as $key=>$input){
                            //find aria-label for input tag
                            $arial_sort = substr($input, 0, 11);
                            similar_text($arial_sort," aria-label",$percent);
                            if ($percent > 90){
                                //arial-label found no need further execution
                                $indicator=1;
                                break;
                            }
                        }
                        if ($indicator == 0){
                            //						if arial-label not exist find id then
                            $new_sort = $this->subarr($input_tag, 0, 2);
                            $is_there = $this->is_exist('id', 0, sizeof($input_tag), $new_sort);
                            if (!$is_there){
                                //								if ID not there than just set ID value to empty
                                $this->check_labelid($input_tag, $line, $start_tag, '');
                            } else {
                                $this->check_labelid($input_tag, $line, $start_tag, $input_tag[$is_there].$is_there);
                            }
                        }
                    }

                    public function check_labelid($input_tag, $line, $start_tag, $id_input){
                        if ($id_input === ''){

                        } else {
                            $id_name = explode("&quot;", $id_input);
                            $id_namefor = 'for="'.$id_name[1].'"';
                            if ($line != 0){
                                for ($i= $line; $i>=0; $i--) {
                                    foreach ($this->all_array[$i] as $position=>$items){
                                        similar_text(substr($items, 0, 10+strlen($id_namefor)), htmlspecialchars($id_namefor), $percent);
                                        if ($percent >= 100) {
                                            $indicator = 1;
                                        }
                                    }
                                }
                            }

                        }
                        $indicator = 0;
                        if ($start_tag == 0){
                            $end_label = $start_tag;
                        } else {
                            $end_label = $start_tag-1;
                        }


                        if ($indicator != 1){ //Indicator -> is 'for' in label found and whether is match with 'id' in input
                            $line_label = $line;
                            $check_label = substr($this->all_array[$line][$end_label], strlen($this->all_array[$line][$end_label])-14, strlen($this->all_array[$line][$end_label]));
                            if ($check_label == htmlspecialchars('</label>')){
                                $indicator = 1; //if the previous is label then to the line 328
                            } else {
                                if ($line != 0){
                                    foreach ($this->all_array[$line-1] as $keys=>$items){
                                        if ($items == htmlspecialchars('</label>')){
                                            $indicator =1;
                                            $end_label = $keys;
                                            $line_label = $line-1;
                                        }
                                    }
                                }
                            }

                            if ($indicator != 1){ // Indicator -> Is label found?
                                //echo '<div role="tabpanel" class="tab-pane" id="messages">';
                                form_correct($input_tag, 'input', $line+1, $start_tag, ''); // Supposed label not found.
                                //echo '</div>';
                            } else {
                                $start_label = 0;
                                $label_tag = array();
                                // Find the first index of label
                                for ($i=$end_label; $i>=0; $i--){
                                    $new_label = substr($this->all_array[$line_label][$i], 0, 7);
                                    if ($new_label == htmlspecialchars('<lab')){ // sort version of <label>
                                        $start_label = $i;
                                        break;
                                    }
                                }
                                for ($j=$start_label; $j<=$end_label; $j++){
                                    array_push($label_tag, $this->all_array[$line_label][$j]);
                                }
                                $arr1 = $this->single_tag($line, $start_label, $start_tag);
                                array_splice($input_tag, 0, 1, $arr1); //New array join label and input tag together.
                                $new_sort = $this->subarr($this->all_array[$line_label], 0, 3);
                                $is_there = $this->is_exist('for', $start_label, $end_label, $new_sort); //check if for exist
                                echo $is_there;
                                if ($id_input==''){
                                    $id_index = $start_tag;
                                    if (!$is_there){ //When for doesn't exist but id exist
                                        form_correct($input_tag, 'label', $line+1, $start_label, $id_index);
                                    } else{
                                        echo "No ID but FOR there --- not yet to solve <br/>";
                                    }
                                } else {
                                    //When ID have value
                                    $id_index = $id_input[strlen($id_input)-1];
                                    $id_index = $id_index+$start_tag;
                                    if (!$is_there){ //When for doesn't exist but id exist
                                        form_correct($input_tag, 'label', $line+1, $start_label, $id_index);
                                        echo 'musib label there ID there but no for line'.($line+1);
                                    } else{
                                        echo "ID there and For there, but both not same --- not yet to solve <br/>";
                                    }
                                }
                            }

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
                                <div id="info-auto" style="display:none;">
                                    <p class="text-center info-other">
                                        <span class="bg-danger">Note:</span> <br>What listed here are not absolute correct,<br> therefore we encourage you to press "more info" button
                                    </p>
                                </div>
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
                                    $all_array = htmlspecialchars($_POST['cekode']);
                                    $myfile = fopen("temp-html-file.html", "w") or die("Unable to open file!");
                                    fwrite($myfile, $all_array." ");
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
    <script src="js/data-json.js"></script>
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