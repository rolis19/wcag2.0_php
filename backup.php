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
        $yes_label = 1;
    } else {
        if (empty($id_name)){
            $myfile = fopen("tempindex.txt", "w") or die("Unable to open file!");
            fwrite($myfile, $start_tag." ");
            foreach ($input_tag as $items){
                fwrite($myfile, htmlspecialchars_decode($items)." ");
            }
            fclose($myfile);
        } else {
//                                $this->correcting_arr($start_tag+1, "aria-labelledby=&quot;".$id_name."&quot;");
        }
        echo "<p class='bg-warning'>'aria-labelledby' added to the input tag</p>";
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
//                                    $this->correcting_arr($start_tag+1); //Label already equal to ID
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
//									$this->correcting_arr($start_tag+1);
            }
        }
    }
}

