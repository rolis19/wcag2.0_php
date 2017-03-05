<?php
$css = file_get_contents('temp.css');
//css_beautify($css);
split_css($css);
function split_css($css){
    $find = '/(\S.*?) ?{(.*?)}/s';
    preg_match_all($find, $css, $found);
    $bg_color = find_bgcolor($found);
    $color = find_color($found);
    foreach ($bg_color as $key=>$itm){
        echo $found[1][$key].'==>'.$itm."<br>";
    }
}
function find_bgcolor($found){
    $with_bg = array();
    foreach ($found[2] as $key=>$item){
        $item_arr = preg_split("/;/", $item);
        foreach ($item_arr as $items){
            if (preg_match('/background(.+?)/s', $items)){
                $with_bg[$key] = $items;
            }
        }
    }
    return $with_bg;
}
function find_color($found){
    $with_color = array();
    foreach ($found[2] as $key=>$item){
        $item_arr = preg_split("/;/", $item);
        foreach ($item_arr as $items){
            if (preg_match('/[^-]color/s', $items)){
                $with_color[$key] = $items;
            }
        }
    }
    return $with_color;
}

function css_beautify($css){
    $string = trim(preg_replace('/\s+/', ' ', $css));
    $find = '/(\S.*?) ?{(.*?)}/s';
    preg_match_all($find, $string, $found);
    $my_file = fopen("temp.css", "w") or die("Unable to open file!");
    foreach ($found[0] as $key=>$itm){
        $b_selector = preg_replace('/; ?/', ";\r\n", $found[1][$key]);
        fwrite($my_file, $b_selector."{\r\n");
        if(strpos($found[2][$key], ';') !== false) {
            $a1 = explode(";", $found[2][$key]);
        } else {
            $a1[0] = $found[2][$key];
        }
        $i=0;
        foreach ($a1 as $k=>$item) {
            $item = "\t".$item.";\r\n";
            if(++$i === count($a1)){
                $item = "}\r\n";
            }
            fwrite($my_file, $item);
        }
    }
    fclose($my_file);
}

// Remove all comment
// Support media query
// Support keyframe animations

?>


<!--<footer>-->
<!--    --><?php
    $time = microtime();
//    $time = explode(' ', $time);
//    $time = $time[1] + $time[0];
//    $start = $time;
//    session_start();
////    =======================
//    function convert($size){
//        $unit=array('b','kb','mb','gb','tb','pb');
//        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
//    }
//    $time = microtime();
//    $time = explode(' ', $time);
//    $time = $time[1] + $time[0];
//    $finish = $time;
//    $total_time = round(($finish - $start), 4);
//    echo 'Page generated in '.$total_time.' seconds.<br>';
//    echo "Memory: ".convert(memory_get_usage());
//    echo " Peak Memory: ".convert(memory_get_peak_usage());
//    ?>
<!--</footer>-->
