<?php
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
        <nav class="menu">
        </nav>
        <a class="close-button btn btn-danger" id="close-button">Close Menu</a>
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
                                    <button class="btn btn-success" id="check" type="submit">CHECK >></button>
                                    <div class="form-group">
                                        <textarea class="form-control" name="cekode" id="cek" cols="80" rows="8"></textarea>
                                        <input type="hidden" name="stage" value="process">
                                    </div>

                                </form>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <form action="" method="post">
                                    <button class="btn btn-success" type="submit">CHECK >></button>
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
                            function show_code($line){
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
                <div class="col-md-6 bottom">
                    <div class="content-correct">
                    <?php
                        //Form for correcting input from user
                        function form_correct($tag_array, $tag, $line, $index, $index1){
                            echo <<< END
                           <script type="text/javascript">
                                $(document).ready(function() {
                                    $('a.line$line').click(function() {
                                        $.smoothScroll({
                                            offset: -200,
                                            scrollElement: $('div.showcode-container'),
                                            scrollTarget: '#line$line',
                                            beforeScroll: function(options) {
                                                $('.line').removeClass("active");
                                            },
                                            afterScroll: function(options) {
                                                $('#line$line').addClass("active");
                                            }
                                        });
                                        return false;
                                    });
                                });
                            </script>
END;

                            $identifier= $tag."".$line.$index;
                            echo "<div class='$identifier form-container'>";
                            echo "<div class='info-detail'>";
                            echo "<p> Error in <a href='#' class='line$line'>line ".$line."</a></p>";
                            $desc="";
                            $info ="Without double quote";
                            switch ($tag){
                                case 'img':
                                    echo <<< END
                                    <p>Img tag dosen't have 'alt' properties | WCAG 2.0 level A Percivable 
                                    <a href='#' id='open-button$line' class='btn btn-sm btn-info' onclick="revealInfo('open-button$line')">More info</a>
                                    </p>
                                    <hr />
END;
                                    $desc = "Input alt value";
                                    $word = "<code>".htmlspecialchars('alt="..."')."</code>";
                                    $a1 = array($tag_array[0], $word);
                                    array_splice($tag_array, 0,1,$a1);
                                    echo "<p class='tag-info'>";
                                    foreach ($tag_array as $items){
                                        echo $items." ";
                                    }
                                    echo "</p>";
                                    break;
                                case 'input':
                                    $desc = "Input aria-label value ";
                                    $word = "<code>".htmlspecialchars('aria-labelledby="..."')."</code>";
                                    $a1 = array($tag_array[0], $word);
                                    array_splice($tag_array, 0,1,$a1);
                                    echo "<p class='tag-info'>";
                                    foreach ($tag_array as $items){
                                        echo $items." ";
                                    }
                                    echo "</p>";
                                    break;
                                case 'label':
                                    $desc = "Give label's for and input's id value";
                                    $word = htmlspecialchars('<label')."<code>".htmlspecialchars('for="..."')."</code>".substr($tag_array[0], 9, strlen($tag_array[0]));
                                    $a1 = array($word);
                                    array_splice($tag_array, 0,1,$a1);
                                    $id_index = $index1-$index;
                                    if (substr($tag_array[$id_index], 0, 2) == 'id'){
                                        $tag_array[$id_index] = "<code>".$tag_array[$id_index]."</code>";
                                    } else {
                                        $word = "<code>".htmlspecialchars('id="..."')."</code>";
                                        $a2 = array($tag_array[$id_index], $word);
                                        array_splice($tag_array, $id_index,1,$a2);
                                    }
                                    echo "<p class='tag-info'>";
                                    foreach ($tag_array as $items){
                                        echo $items." ";
                                    }
                                    echo "</p>";

                            }
                            echo <<< END
                            </div>
                                <label for='correct'>$desc</label> <small>$info</small> 
                                <span id='identifier'>$identifier</span>
                                <div class='form-group'>
                                    <input type='text' class='form-control correct-text' id='correct_$identifier' placeholder='your text'>
                                    <input type='hidden' id='position_$identifier' value='$line $index $index1 $tag'>
                                    <button class='btn btn-default' id='tiger' onclick='runAjax()'>Edit</button>
                                    <button class='btn btn-default'>Ignore</button>
                                </div>
                            </div>
END;
                        }
                    ?>
                    <?php

                    class mainArray{
                        public $all_array;
                        public $arr_newline;
                        public $all_checked_line = array();
                        public $correct_arr = array();
                        public $array_ready = array();
                        public $array_indicator;
                        public $tag_name;
                        public $end_tag;
                        public $correct_words;
                        public $checker_list = array("&lt;img");

                        public function __construct($all_text){
                            $this->arr_newline = preg_split("/\\r\\n|\\r|\\n/", $all_text);
                            $my_file = fopen("file-reference.txt", "w") or die("Unable to open file!");
                            for ($i=0; $i<count($this->arr_newline); $i++){
                                $arrnewline_sterile = sterile_string($this->arr_newline[$i]);
                                $this->all_array[$i] = explode(" ", $arrnewline_sterile);
                                fwrite($my_file, $arrnewline_sterile."\r\n");
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
                                            $this->tag_name = $items;
                                            //$this->alloc_work($line, $position); //work allocation
                                            //Forming array
                                            $j++;
                                            $this->all_checked_line[$j] = array('line'=> $line,
                                                'position' => $position
                                                );
                                        }
                                    }
                                }
                            }
                            $this->alloc_work($this->all_checked_line); //work allocation
                        }
                        //Find end tag
                        public function find_close_tag($line, $position){
                            $nd_tag = 0;
                            for ($n = $position; $n < count($this->all_array[$line]); $n++) {
                                $new_line = substr($this->all_array[$line][$n], strlen($this->all_array[$line][$n]) - 4, strlen($this->all_array[$line][$n])); // take 4 string in every end string
                                similar_text('&gt;', $new_line, $percent);
                                if ($percent == 100) {
                                    $nd_tag = $n;
                                    break;
                                }
                            }
                            return $nd_tag;
                        }
                        //Check whether end tag is true, by checking open tag for next element
                        public function next_open_tag($line, $position){
                            $new_sort = array();
                            foreach ($this->all_array[$line] as $items){
                                array_push($new_sort, substr($items, 0, 4));
                            }
                            $next_tag = $this->is_exist(htmlspecialchars('<'), $position + 1, sizeof($new_sort), $new_sort);
                            if (!$next_tag) {
                                //In case this is end of file
                                return sizeof($this->all_array[$line]);
                            } else {
                                return $next_tag;
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
                        public function alloc_work($all_line){
                            for ($i=0; $i<count($all_line); $i++){
                                $line = $all_line[$i]['line'];
                                $position = $all_line[$i]['position'];
                                switch ($this->tag_name) {
                                    case "&lt;img": //Img tag
                                        $end_tag = $this->find_close_tag($line, $position); //Get end tag index
                                        $next_open_tag = $this->next_open_tag($line, $position);
                                        $is_end_true = $this->is_end_true($end_tag, $next_open_tag);
                                        if (!$is_end_true){
                                            echo "you are missing w3c tag validator checker";

                                        } else {
                                            $img_tag = $this->single_tag($line, $position, $end_tag);
                                            $this->img_check($img_tag, $line, $position);
                                        }
                                        break;

    //                                case "&lt;input": //Input tag
        //                                $end_tag = $this->find_close_tag($position);
        //                                $next_open_tag = $this->next_open_tag($position, $end_tag);
        //                                $is_end_true = $this->is_end_true($end_tag, $next_open_tag);
        //                                if (!$is_end_true){
        //                                    echo "end tag for input not found";
        //                                } else {
        //                                    $input_tag = $this->single_tag($position, $end_tag);
        //                                    $this->input_alloc($input_tag, $position);
        //                                }
                                        break;
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
                                form_correct($img_tag, 'img', $line+1, $start_tag, '');
                            }
                            $last_checked_line = $this->all_checked_line[count($this->all_checked_line)-1]['line'];
                            if ($line == $last_checked_line){
                                show_code($line);
                            }
                        }
    //===================   Check input Tag Process    ==========================================
                        public function input_alloc($input_tag, $start_tag){
                            $indicator = 0;
                            $new_input_arr = implode(" ", $input_tag);
                            // Create new array based on double quote
                            $new_input_arr = explode("&quot;", $new_input_arr);

                            foreach ($new_input_arr as $item) {
                                switch ($item){
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
                                        $indicator = 1;
                                        $this->input_check($input_tag, $start_tag);
                                        break;
                                    //below no need any action
                                    case "submit":
                                    case "image":
                                    case "reset":
                                    case "button":
                                        $indicator = 2;
                                        break;
                                }
                            }
                            if ($indicator==0){
                                //echo "You don't have proper type of input set<br>";
                            }
                        }

                        public function input_check($input_tag, $start_tag){
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
                                    $this->check_labelid($input_tag, $start_tag, '');
                                } else {
                                    $this->check_labelid($input_tag, $start_tag, $input_tag[$is_there].$is_there);
                                }
                            }
                        }

                        public function check_labelid($input_tag, $start_tag, $id_input){
                            $yes_label = 0;
                            if ($start_tag == 0){
                                $end_label = $start_tag;
                            } else {
                                $end_label = $start_tag-1;
                            }
                            // Check if end is truly label, if not then add aria-label to input
                            $check_label = substr($this->all_array[$end_label], strlen($this->all_array[$end_label])-14, strlen($this->all_array[$end_label]));
                            if ($check_label == htmlspecialchars('</label>')){
                                $yes_label = 1; //if the previous is label then to the line 328
                            } else {
                                form_correct($input_tag, 'input', $start_tag, '');
                            }
                            // When index end equal to label do following
                            if ($yes_label == 1){
                                $start_label = 0;
                                $indicator = 0;
                                $label_tag = array();
                                // Find the first index of label
                                for ($i=$end_label; $i>=0; $i--){
                                    $new_label = substr($this->all_array[$i], 0, 7);
                                    if ($new_label == htmlspecialchars('<lab')){ // sort version of <label>
                                        $start_label = $i;
                                        break;
                                    }
                                }
                                for ($j=$start_label; $j<=$end_label; $j++){
                                    array_push($label_tag, $this->all_array[$j]);
                                }
                                $arr1 = $this->single_tag($start_label, $start_tag);
                                array_splice($input_tag, 0, 1, $arr1); //New array join label and input tag together.
                                $new_sort = $this->subarr($this->all_array, 0, 3);
                                $is_there = $this->is_exist('for', $start_label, $end_label, $new_sort); //check if for exist
                                if ($id_input==''){
                                    $id_index = $start_tag;
                                    if (!$is_there){ //When for doesn't exist but id exist
                                        form_correct($input_tag, 'label', $start_label, $id_index);
                                    } else{
                                        echo "No ID but FOR there --- not yet to solve <br/>";
                                    }
                                } else {
                                    //When ID have value
                                    $label_tag = implode(" ", $label_tag);
                                    $label_tag = explode("&quot;", $label_tag);
                                    $id_name = explode("&quot;", $id_input);
                                    foreach ($label_tag as $item){
                                        if ($item == $id_name[1]){
                                            $indicator++; //for equal to id no need further execution
                                            break;
                                        }
                                    }
                                    $id_index = $id_input[strlen($id_input)-1];
                                    $id_index = $id_index+$start_tag;
                                    if ($indicator == 0){
                                        if (!$is_there){ //When for doesn't exist but id exist
                                            form_correct($input_tag, 'label', $start_label, $id_index);
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
                        echo "<div id='selesai' class='btn btn-danger' href='newfile.html'>";
                        echo "Finish & Download";
                        echo "</div>";
                    }
                    function sterile_string($line_string){
                        $i = 0; $k = 0; $m = 0;
                        if (strlen(trim($line_string)) != 0){
                            $new_decode = htmlspecialchars_decode($line_string);
                            do {
                                $i++;
                            } while ($new_decode[$i] == ' ');
                            $start_fill = $i;
                            for ($j = $start_fill + 1; $j < strlen($new_decode) - 1; $j++) {
                                if ($new_decode[$j] === '<') {
                                    $k = $j;
                                }
                                if ($new_decode[$j] === '>') {
                                    if ($new_decode[$j + 1] !== '<') {
                                        $m = $j;
                                    }
                                }
                            }
                            if ($m != 0) {
                                $fix_close = substr_replace($new_decode, "> ", $m, 1);
                            } else {
                                $fix_close = $new_decode;
                            }
                            if ($k != 0) {
                                $fix_open = substr_replace($fix_close, " <", $k, 1);
                            } else {
                                $fix_open = $fix_close;
                            }
                            return htmlspecialchars($fix_open);
                        } else {
                            return $line_string;
                        }
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

    <div class="container-fluid">
        <div class="row">
            <div class="container-fluid">
                <div class="row">
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
                </div>
            </div>
        </div>
    </div>

    <script src="js/main.js"></script>
    <script>
        $(document).ready(function(){
            $("#selesai").click(function(){
                var size = $('.col-md-6 .form-container').length;
                if (size == 0){
                    $.ajax({
                        type: "GET",
                        url: "replace.php"
                    });
                } else {
                    alert("There are still "+size+" faults to take care");
                }

            });
        });
    </script>
</body>
</html>