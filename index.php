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
	<title>Php file handling</title>
	<link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
	<style>
		header{height: 120px}
	</style>
</head>
<body>
	<header>
	</header>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="pill" href="#home">Html tag</a></li>
                    <li><a data-toggle="pill" href="#menu1">URL</a></li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <form action="" method="post">
                            <label for="cek">Insert your code below.</label>
                            <textarea name="cekode" id="cek" cols="80" rows="8"></textarea>
                            <input type="hidden" name="stage" value="process">
                            <button class="btn btn-success btn-lg" id="check" type="submit">CHECK</button>
                        </form>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="exampl">Input your URL</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="url">
                            </div>
                            <button class="btn btn-success btn-lg" type="submit">CHECK</button>
                        </form>
                    </div>
                </div>
			</div>
			<div class="col-md-6">
				<h4>Your error code will be displayed here</h4>
				<?php
                //Form for correcting input from user
                function form_correct($tag_array, $tag, $index){
                    $identifier= $tag."".$index;
                    echo "<div class='$identifier nano'>";
                    $desc="";
                    switch ($tag){
                        case 'img':
                            $desc = "Give alt value";
                            $word = "<code>".htmlspecialchars('alt="..."')."</code>";
                            $a1 = array($tag_array[0], $word);
                            array_splice($tag_array, 0,1,$a1);
                            echo "<p>";
                            foreach ($tag_array as $items){
                                echo $items." ";
                            }
                            echo "</p>";
                            break;
                        case 'input':
                            $desc = "Give arial-label value ";
                            $word = "<code>".htmlspecialchars('aria-labelledby="..."')."</code>";
                            $a1 = array($tag_array[0], $word);
                            array_splice($tag_array, 0,1,$a1);
                            echo "<p>";
                            foreach ($tag_array as $items){
                                echo $items." ";
                            }
                            echo "</p>";
                            break;
                    }
                    echo "<div class='form-group' style='width: 50%'>";
                    echo "<label for='correct'>$desc <span id='identifier'>$identifier</span></label>";
                    echo "<input type='text' class='form-control' id='correct_$identifier' placeholder='your text'>";
                    echo "<input type='hidden' id='position_$identifier' value='$index'>";
                    echo "<input type='hidden' id='value' value='$tag'>";
                    echo "<button class='btn btn-success btn-sm' id='tiger' onclick='runAjax()'>Correct</button>";
                    echo "</div>";
                    echo "</div>";
                }


                class mainArray{
					public $all_array;
					public $correct_arr = array();
                    public $array_ready = array();
                    public $array_indicator;
					public $tag_name;
					public $end_tag;
                    public $correct_words;
					public $checker_list = array("&lt;img", "&lt;input");

					public function __construct($all_text=""){
						$this->all_array = explode(" ", $all_text);
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
					    $indicator =0;
						foreach ($this->all_array as $key => $items) {
							for ($i = 0; $i < count($this->checker_list); $i++) {
								similar_text($items, $this->checker_list[$i], $percent);
								if ($percent == 100) {
									$this->tag_name = $items;
									$start_tag = $key;
                                    $indicator++;
                                    //echo $this->tag_name;
									$this->alloc_work($start_tag);
								}
							}
						}
                        $this->array_indicator = $indicator;
					}
					//Find end tag
					public function find_end_tag($start_tag){
						$nd_tag = 0;
						for ($n = $start_tag; $n < count($this->all_array); $n++) {
							$new_line = substr($this->all_array[$n], strlen($this->all_array[$n]) - 4, strlen($this->all_array[$n]));
							similar_text('&gt;', $new_line, $percent);
							if ($percent == 100) {
								$nd_tag = $n;
								break;
							}
						}
						return $nd_tag;
					}
					//Check whether end tag is true, by checking open tag for next element
					public function is_end_tag($start_tag, $end_tag){
					    $new_sort = array();
                        foreach ($this->all_array as $items){
                            array_push($new_sort, substr($items, 0, 4));
                        }
                        $next_tag = $this->is_exist(htmlspecialchars('<'), $start_tag + 1, sizeof($new_sort), $new_sort);
                        if (!$next_tag) {
                            //In case this is end of file
                            return sizeof($this->all_array);
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
					public function single_tag($start_tag, $end_tag){
						$single_tag_arr = array();
						for ($n = $start_tag; $n < count($this->all_array); $n++) {
							for ($i = $start_tag; $i <= $end_tag; $i++) {
								array_push($single_tag_arr, $this->all_array[$i]);
							}
							break;
						}
						return $single_tag_arr;
					}
//======================= End of General function, custom library =======

					//Work allocation here
					public function alloc_work($start_tag){
						switch ($this->tag_name) {
							case "&lt;img":
								$end_tag = $this->find_end_tag($start_tag);
                                $next_open_tag = $this->is_end_tag($start_tag, $end_tag);
                                $is_end_true = $this->is_end_true($end_tag, $next_open_tag);
                                if (!$is_end_true){
                                    //When img doesn't have end tag
                                    $img_tag = $this->single_tag($start_tag, $next_open_tag-1);
                                    $this->img_check($img_tag, $start_tag);
                                } else {
                                    $img_tag = $this->single_tag($start_tag, $end_tag);
                                    $this->img_check($img_tag, $start_tag);
                                }
								break;
							case "&lt;input":
                                $end_tag = $this->find_end_tag($start_tag);
                                $next_open_tag = $this->is_end_tag($start_tag, $end_tag);
                                $is_end_true = $this->is_end_true($end_tag, $next_open_tag);
                                if (!$is_end_true){
                                    echo "end tag not found";
                                } else {
                                    $input_tag = $this->single_tag($start_tag, $end_tag);
                                    $this->input_alloc($input_tag, $start_tag);
                                }
								break;
							default:
								echo "Make sure u are input Html code";
						}
					}

//===================   Check img Tag Process    ==========================================
                    public function img_check($img_tag, $start_tag){
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
                            //no need further execution
                        } else{
                            form_correct($img_tag, 'img', $start_tag);
                        }
                    }
//===================   Check input Tag Process    ==========================================
                    public function input_alloc($input_tag, $start_tag){
                        $indicator = 0;
                        foreach ($input_tag as $item) {
                            switch ($item){
                                case "type=&quot;text&quot;":
                                case "type=&quot;password&quot;":
                                case "type=&quot;radio&quot;":
                                case "type=&quot;checkbox&quot;":
                                    //Html5 new
                                case "type=&quot;color&quot;":
                                case "type=&quot;date&quot;":
                                case "type=&quot;datetime&quot;":
                                case "type=&quot;datetime-local&quot;":
                                case "type=&quot;email&quot;":
                                case "type=&quot;month&quot;":
                                case "type=&quot;number&quot;":
                                case "type=&quot;range&quot;":
                                case "type=&quot;search&quot;":
                                case "type=&quot;tel&quot;":
                                case "type=&quot;time&quot;":
                                case "type=&quot;url&quot;":
                                case "type=&quot;week&quot;":
                                    $indicator = 1;
                                    $this->input_check($input_tag, $start_tag);
                                    break;
                                //below no need any action
                                case "type=&quot;submit&quot;":
                                case "type=&quot;image&quot;":
                                case "type=&quot;reset&quot;":
                                case "type=&quot;button&quot;":
                                    $indicator = 2;
                                    break;
                            }
                        }
                        if ($indicator==0){
							echo "<br>You don't have proper type of input set<br>";
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
                            $is_there = $this->is_exist('id', $start_tag, sizeof($input_tag), $new_sort);
                            if (!$is_there){
//								if ID not there than just set ID value to empty
                                $this->check_labelid($input_tag, $start_tag, "");
                            } else {
                                $this->check_labelid($input_tag, $start_tag, $input_tags[$is_there+1]);
                            }
                        }
                    }

                    public function check_labelid($input_tag, $start_tag, $id_name){
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
                            form_correct($input_tag, 'input', $start_tag);
                        }
                        // When end equal to label do following
                        if ($yes_label == 1){
                            $start_label = 0;
                            $indicator = 0;
                            $label_tag = array();
                            // Find the first index of label
                            for ($i=$end_label-2; $i>=0; $i--){
                                $new_label = substr($this->all_array[$i], 0, 4);
                                if ($new_label == htmlspecialchars('<')){
                                    $start_label = $i;
                                    break;
                                }
                            }
                            for ($j=$start_label; $j<=$end_label; $j++){
                                array_push($label_tag, $this->all_array[$j]);
                            }
                            $label_tag = implode(" ", $label_tag);
                            // Create new array based on double quote, check it one by one if it equal to ID
                            $label_tag = explode("&quot;", $label_tag);
                            foreach ($label_tag as $item){
                                if ($item == $id_name){
                                    $indicator++;
//                                  //Label already equal to ID no need further excution
                                    break;
                                }
                            }
                            if ($indicator == 0){
                                $new_sort = $this->subarr($this->all_array, 0, 3);
                                $is_there = $this->is_exist('for', $start_label, $end_label, $new_sort);
                                // When ID don't have value do
                                if ($id_name == " "){
                                    echo "disinyalir tak punya id";
//									if (!$is_there){
//										//When label don't have for
//									} else {
//										//When label have for
//
//									}
                                }
                                //When ID have value do
                                else {
                                    echo sizeof($label_tag);
                                    if (!$is_there){ //When for doesn't exist
                                        $this->all_array[0] = htmlspecialchars('<label for="').$id_name.htmlspecialchars('">');
                                    } else{ //When for do exist
                                        if (sizeof($label_tag)<=3){ // Check whether
                                            echo "";
                                            $this->all_array[$is_there] = htmlspecialchars('for="').$id_name.htmlspecialchars('">');
                                        } elseif (sizeof($label_tag)>=4){
                                            echo "2";
                                            $this->all_array[$is_there] = htmlspecialchars('for="').$id_name.htmlspecialchars('"');
                                        }
                                    }
                                    echo "<p class='bg-primary'>We have corrected your label</p>";
                                }
                            }
                        }
                    }

				}
//=============== End of class here  =======================================================

                //Run Code start here
                if (isset($_POST['stage']) && ('process' == $_POST['stage'])) {
                    $all_array = htmlspecialchars($_POST['cekode']);
                    $main_array = new mainArray($all_array);
					$main_array->tag_check();
                    $myfile = fopen("file-reference.txt", "w") or die("Unable to open file!");
                    fwrite($myfile, $all_array." ");
                    fclose($myfile);
                }

                ?>
                <button class="btn btn-danger" id="selesai">Finish & Download</button>
			</div>
		</div>
	</div>
	<div class="container" style="height: 280px">
		<div class="row">
			<div class="col-md-12">

			</div>
		</div>
	</div>
	<footer style="color: #FFFFFF; padding: 40px; text-align: center; background-color: #262626; position: fixed; bottom: 0; width: 100%">
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
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/ajax.js"></script>
    <script>
        $(document).ready(function(){
            $("#selesai").click(function(){
                var size = $('.col-md-6 .nano').length;
                if (size == 0){
                    $.ajax({
                        type: "GET",
                        url: "replace.php"
                    });
                } else {
                    alert("Not done");
                }

            });
        });
    </script>
</body>
</html>