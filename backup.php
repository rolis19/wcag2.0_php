<?php
///===================   Check input Tag Process    ==========================================
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
//							echo "<br>You don't have proper type of input set<br>";
    }
}
public function input_check($input_tag, $start_tag){
    $indicator = 0;
    $input_tags = implode(" ", $input_tag);
    //Create new array based on double quote
    $input_tags = explode("&quot;", $input_tags);
    foreach ($input_tags as $key=>$input){
//						find aria-label for input tag
        $arial_sort = substr($input, 0, 11);
        similar_text($arial_sort," aria-label",$percent);
        if ($percent > 90){
//								$this->correcting_arr($start_tag+1);
            $indicator=1;
            break;
        }
    }
    if ($indicator == 0){
//						if arial-label not exist find id then
        $new_sort = $this->subarr($input_tag, 0, 2);
        $is_there = $this->is_exist('id', $start_tag, sizeof($input_tag), $new_sort);
        echo $new_sort[2];
        if (!$is_there){
//								if ID not there than just set ID value to null
            $this->check_labelid($start_tag, " ");
        } else {
            $this->check_labelid($start_tag, $input_tags[$is_there+1]);
        }
    }
}


