<?php
include 'form-correct.php';
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
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
            <h3>Explanation</h3>
            <div id="explanation">

            </div>
            <h3>Instruction</h3>
            <div id="instruction">

            </div>
            <h3>WCAG 2.0 Technique</h3>
            <div id="technique">

            </div>
        </div>
    </div>
    <div class="content-wrap">
        <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 top">
                    <div class="all-form" id="allform">
                        <ul class="nav nav-pills pull-left" style="width: 160px">
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
                <div class="col-md-6 bottom">
                    <div class="content-correct">
                    <?php
                    function sterile_string($line_string){
                        if (strlen(trim($line_string)) != 0 && strlen($line_string) > 1){
                            $new_decode = explode(' ', htmlspecialchars_decode($line_string));
                            for ($n = 0; $n < count($new_decode); $n++){
                                if (preg_match('/[^S]</', $new_decode[$n])){
                                    $new_decode[$n] = preg_replace('/</', ' <', $new_decode[$n]);
                                }
                                if (preg_match('/>[^S\r\n]/', $new_decode[$n])){
                                    $new_decode[$n] = preg_replace('/>/', '> ', $new_decode[$n]);
                                }
                            }
                            return htmlspecialchars(implode(' ', $new_decode));
                        } else {
                            return $line_string;
                        }
                    }

                    class mainArray{
                        public $all_array;
                        public $arr_newline;
                        public $line_with_tag = array();
                        public $checker_list = array("&lt;img", "&lt;input");

                        public function __construct($all_text){
                            $this->arr_newline = preg_split("/\\r\\n|\\r|\\n/", $all_text);
                            $my_file = fopen("file-reference.txt", "w") or die("Unable to open file!");
                            for ($i=0; $i<count($this->arr_newline); $i++){
                                $arrnewline_sterile = sterile_string($this->arr_newline[$i]);
                                $this->all_array[$i] = explode(" ", $arrnewline_sterile);
                                fwrite($my_file, htmlspecialchars_decode($arrnewline_sterile)."\r\n");
                            }
                            fclose($my_file);
                        }

    //======================= General function, custom library
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

                        //Find tag, also their index
                        public function tag_check(){
                            $j=-1;
                            foreach ($this->all_array as $line=>$lines) {
                                foreach ($lines as $position=>$items){
                                    for ($i = 0; $i < count($this->checker_list); $i++) {
                                        similar_text($items, $this->checker_list[$i], $percent);
                                        if ($percent == 100) {
                                            //Forming array
                                            $j++;
                                            $this->line_with_tag[$j] = array('line'=> $line,
                                                'position' => $position,
                                                'tagname' => $items
                                                );
                                        }
                                    }
                                }
                            }
                            $this->alloc_work(); //work allocation
                            //$this->debug_arr();
                        }
                        public function debug_arr(){
                            foreach ($this->line_with_tag as $items){
                               echo $items['tagname'];
                            }
                        }
                        //Find end tag
                        public function find_close_tag($line, $position){
                            $nd_tag = 0; $line_end=0;
                            $next_open_tag = $this->next_open_tag($line, $position);
                            $single_tag_arr = array($this->all_array[$line][$position]);
                            for ($n=$line; $n < (count($this->all_array)); $n++){
                                if ($n == $line){$length = ($position+1);} else {$length = 0;}
                                for ($i = $length; $i < (count($this->all_array[$n])); $i++){
                                    array_push($single_tag_arr, $this->all_array[$line][$position], $this->all_array[$n][$i]);
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
                            if ($nd_tag != 0){
                                if ($next_open_tag != 0){
                                    if ($next_open_tag > ($line_end+1).$nd_tag){
                                        return $single_tag_arr;
                                    } else {
                                        return NULL;
                                    }
                                }else{
                                    return $single_tag_arr;
                                }
                            }else {
                                return NULL;
                            }
                        }
                        //Check whether end tag is true, by checking open tag for next element
                        public function next_open_tag($line, $position){
                            $nxt_opn_tag = 0; $line_nxt_open = 0;
                            for ($n=$line; $n < (count($this->all_array)); $n++){
                                if ($n == $line){$length = ($position+1);} else {$length = 0;}
                                for ($i = $length; $i < (count($this->all_array[$n])); $i++){
                                    if (preg_match('/&lt;/', $this->all_array[$n][$i])) {
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
                                return ($line_nxt_open+1).$nxt_opn_tag;
                            }
                        }
                        //If open tag for next element less than close tag for current element then false, else true
                        public function is_end_true($end_tag, $next_open_tag){
                            if ($next_open_tag < $end_tag){
                                return false;
                            } else {
                                return $end_tag;
                            }
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
                            for ($i=0; $i<count($this->line_with_tag); $i++){
                                $line = $this->line_with_tag[$i]['line'];
                                $position = $this->line_with_tag[$i]['position'];
                                $tag_name = $this->line_with_tag[$i]['tagname'];
                                switch ($tag_name) {
                                    case "&lt;img": //Img tag
                                        $img_tag = ($this->find_close_tag($line, $position)); //Get end tag index
                                        if (!empty($img_tag)){
                                            $this->img_check($img_tag, $line, $position);
                                        }else {
                                            echo "you are missing w3c tag validator checker ".$line."<br>";
                                        }
                                        break;

                                    case "&lt;input": //Input tag
//                                        $end_tag = $this->find_close_tag($line, $position);
//                                        $next_open_tag = $this->next_open_tag($line, $position);
//                                        $is_end_true = $this->is_end_true($end_tag, $next_open_tag);
//                                        if (!$is_end_true){
//                                            echo "you are missing w3c tag validator checker";
//                                        } else {
//                                            $input_tag = $this->single_tag($line, $position, $end_tag);
//                                            $this->input_alloc($input_tag, $line, $position);
//                                        }
                                        break;
                                }
                                if ($line == $end_array){
                                    show_code(); //Show download button and inserted code
                                }
                            }
                        }

                        public function correct_end_tag($tag_array){
                            echo "<hr />";
                            foreach ($tag_array as $key=>$item){
                                echo "<button id='$key' class='btn correct-close-tag'>".$item."</button> ";
                            }
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
                                    $decode_html = htmlspecialchars_decode($img_tag[1]);
                                    $words = '';
                                    if (preg_match('/[^\/]>$/', $decode_html)) {
                                        $words = preg_replace('/>$/', htmlspecialchars(' />'), $decode_html);
                                    } else if (preg_match('/\/>$/', $decode_html)){
                                        $words = preg_replace('/\/>$/', htmlspecialchars(' />'), $decode_html);
                                    }
                                    write_to_fref($line, $start_tag+1, $words);
                                    $a2 = explode(' ', $words);
                                    array_splice($img_tag, 1, 1, $a2);
                                    print_r($img_tag);
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
                                    form_correct($input_tag, 'input', $line+1, $start_tag, ''); // Supposed label not found.
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
    //=============== End of class here  =======================================================

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
        $(document).ready(function(){
            $("#selesai").click(function(e){
                var size = $('.col-md-6 .form-container').length;
                if (size != 0){
                    alert("There are still "+size+" faults to take care");
                } else {
                    $('a#selesai').attr({download: 'newfile.html',
                        href  : 'http://localhost/learn/newfile.html'});
                }
            });
        });
    </script>
</body>
</html>