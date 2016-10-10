<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Php file handling</title>
	<link rel="stylesheet" href="css/bootstrap.css">
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
				<form action="" method="post">
                    <label for="cek">cek kode</label>
					<textarea name="cekode" id="cek" cols="80" rows="8"></textarea>
					<input type="hidden" name="stage" value="process">
					<button class="btn btn-success btn-lg" type="submit">CHECK</button>
				</form>
			</div>
			<div class="col-md-6">
				<h4>Your error code will be displayed here</h4>
				<?php

                class mainArray{
					public $all_array;
					public $correct_arr = array();
					public $tag_name;
					public $start_tag;
					public $end_tag;
					protected $stack;
					protected $limit;
					public $checker_list = array("&lt;img", "&lt;input");

					public function __construct($all_text, $limit = 10){
						$this->all_array = explode(" ", $all_text);
						// initialize the stack
						$this->stack = array();
						// stack can only contain this many items
						$this->limit = $limit;
					}

//=================== Stack use for checking open and closed tag =========================
					public function push($item) {
						// trap for stack overflow
						if (count($this->stack) < $this->limit) {
							// prepend item to the start of the array
							array_unshift($this->stack, $item);
						} else {
							throw new RunTimeException('Stack is full!');
						}
					}
					public function printStack(){
						foreach ($this->stack as $item) {
							echo $item.") (";
						}
					}
//========================================================================================

					//Find tag, also their index
					public function tag_check(){
						foreach ($this->all_array as $key => $items) {
							for ($i = 0; $i < count($this->checker_list); $i++) {
								similar_text($items, $this->checker_list[$i], $percent);
								if ($percent == 100) {
									$this->tag_name = $items;
									$this->start_tag = $key;
									$this->alloc_work($this->start_tag);
									$this->push($items);
								}
							}
							array_push($this->correct_arr, $items);
						}
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
						$short_arr = array();
						foreach ($this->all_array as $items){
							array_push($short_arr, substr($items, 0 ,3));
						}
						$is_there = $this->is_exist('&alt;', $start_tag, $end_tag, $short_arr);
						if (!$is_there){
							return $end_tag;
						} else {
							return $is_there;
						}
					}
					//If open tag for next element less than close tag for current element then false, else true
					public function is_end_true($nd_tag, $st_tag){
						if ($nd_tag>$st_tag){
							return false;
						} else {
							return $nd_tag;
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

//					Use this class every time we need to check the existence of certain word.
                    public function is_exist($word, $start, $end, $array_of){
                        $index = 0;
                        $indicator = 0;
                        for ($i=$start; $i<$end; $i++){
                            if ($word == $array_of[$i]){
                                $indicator++;
                                $index = $i;
                                break;
                            }
                        }
                        if ($indicator == 0){
                            return false;
                        } else{
                            return $index;
                        }
                    }
					//Work allocation here
					public function alloc_work($start_tag){
						switch ($this->tag_name) {
							case "&lt;img":
								$endt = $this->find_end_tag($start_tag);
								if (!$this->is_end_true($endt, $this->is_end_tag($start_tag, $endt))) {
									echo "End tag for Img not found";
								} else {
									if (!img_check($this->single_tag($start_tag, $this->find_end_tag($start_tag)), $start_tag)){
									}else{
										$this->correcting_arr($start_tag+1, img_check($this->single_tag($start_tag, $this->find_end_tag($start_tag)), $start_tag));
									}
								}
								break;
							case "&lt;input":
								$endt = $this->find_end_tag($start_tag); // End tag return value
								if (!$this->is_end_true($endt, $this->is_end_tag($start_tag, $endt))) {
									echo "End tag for input not found";
								} else {
									$this->input_alloc($this->single_tag($start_tag, $endt), $start_tag);
								}
								break;
							default:
								echo "Make sure u are input Html code";
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
									input_check($input_tag, $start_tag);
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
					public function check_labelid($start_tag, $id_name){
					    $yes_label = 0;
						if ($start_tag == 0){
							$end_label = $start_tag;
						} else {
							$end_label = $start_tag-1;
						}
						// Check if end is truly label, if not then add aria-label to input
						$check_label = substr($this->all_array[$end_label], strlen($this->all_array[$end_label])-14, strlen($this->all_array[$end_label]));
						if ($check_label == htmlspecialchars('</label>')){
							$yes_label = 1;
						} else {
							if ($id_name == " "){
                                $this->correcting_arr($start_tag+1, "aria-labelledby=&quot;Add label info&quot;");
                            } else {
                                $this->correcting_arr($start_tag+1, "aria-labelledby=&quot;".$id_name."&quot;");
                            }
							echo "<p class='bg-warning'>'aria-labelledby' added to the input tag</p>";
						}
						if ($yes_label == 1){
                            $start_label = 0;
                            $indicator = 0;
                            $label_tag = array();
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
                            // Create new array based on double quote, check it one by one if equal to ID
                            $label_tag = explode("&quot;", $label_tag);
                            foreach ($label_tag as $item){
//                                echo $item." ";
                                if ($item == $id_name){
                                    $indicator++;
                                    $this->correcting_arr($start_tag+1);
                                    break;
                                }
                            }
                            if ($indicator == 0){
                                if ($id_name == " "){
                                    echo "Id have no value";
                                } else {
                                    echo "Id have value";
                                }
                            }
                        }
					}
					
//===================   Process final array correcting and saving   ========================
					public function correcting_arr($index, $word=""){
						$a1 = array($this->all_array[$index], $word);
						array_splice($this->all_array, $index,1,$a1);
						$this->print_true($this->all_array);

					}
					public function print_true($true_arr){
						$myfile = fopen("newfile.html", "w") or die("Unable to open file!");
						foreach ($true_arr as $items){
							fwrite($myfile, html_entity_decode($items)." ");
						}
						fclose($myfile);
					}
				}
//=============== End of class here  =======================================================

                //Run Code start here
                if (isset($_POST['stage']) && ('process' == $_POST['stage'])) {
                    $main_array = new mainArray(htmlspecialchars($_POST['cekode']));
					$main_array->tag_check();
                }


				function img_check($img_tag, $index){
					$indicator = 0;
					foreach ($img_tag as $img){
						$img_sort = substr($img, 0, 3);
						similar_text($img_sort,"alt",$percent);
						if ($percent > 90){
							$indicator++;
						}
					}
					if ($indicator >= 1){
						return false;
					} else{
						$word = "alt=&quot;"."Smileeee"."&quot;";
						return $word;
					}
				}
				function input_check($input_tag, $start_tag){
					$indicator = 0;
                    $indi_id = 0;
                    $check_labelid = new mainArray(htmlspecialchars($_POST['cekode']));
					$input_tag = implode(" ", $input_tag);
					$input_tag = explode("&quot;", $input_tag);
					foreach ($input_tag as $key=>$input){
//						find aria-label for input tag
						$arial_sort = substr($input, 0, 11);
						similar_text($arial_sort," aria-label",$percent);
						if ($percent > 90){
							$indicator=1;
							break;
						}
					}
					if ($indicator == 1){

					}else{
//						if arial-label not exist find id then
						foreach ($input_tag as $key=>$input){
							$id_sort = substr($input, 0, 3);
							similar_text($id_sort," id",$percent_id);
							if ($percent_id > 90){
								$check_labelid->check_labelid($start_tag, $input_tag[$key+1]);
                                $indi_id++;
								break;
							}
						}
					}
					if ($indi_id == 0){
//                      if ID not there than just set ID value to null
                        $check_labelid->check_labelid($start_tag, " ");
                    }
				}
				?>
				
			</div>
		</div>
	</div>
	<div class="container">
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
	<script src="js/jquery.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script type='text/javascript' src='js/bootstrap.js'></script>
</body>
</html>