<?php

function form_correct($tag_array, $tag, $line, $index, $index1){
    echo <<< END
   <script type="text/javascript">
        $(document).ready(function() {
            document.getElementById("b-error").className = "bub-danger";
            var size = $('.col-md-6 .form-container').length;
            document.getElementById("b-error").innerHTML = size;
        });
    </script>
END;

    $identifier= $tag."".$line.$index;
    echo "<div class='$identifier form-container'>";
    echo "<div class='info-detail'>";
    echo "";
    $desc="";
    $info ="Without double quote";
    switch ($tag){
        case 'img':
            echo "<p> Fault in <a href='#' onclick='toLine(".$line.")'>line $line</a></p>";
            $desc = "Give alt value";
            echo "<p class='tag-info'>";
            echo substr($tag_array, 0, 80).'...';
            echo "</p>";
            break;

        case 'input':
            echo <<< END
            <p>Input tag needs aria-label properties | WCAG 2.0 level A Perceivable 
            <a href='#' id='open-button$line' class='btn btn-sm btn-info' onclick="revealInfo('open-button$line', '$tag')">
            More info <i class='glyphicon glyphicon-info-sign'></i></a>
            </p>
            <hr />
END;
            $desc = "Give aria-label value ";
            $word = "<code>".htmlspecialchars('aria-label="..."')."</code>";
            $a1 = array($tag_array[0], $word);
            array_splice($tag_array, 0,1,$a1);
            echo "<p class='tag-info'>";
            echo substr(join(' ', $tag_array), 0, 117);
            if (strlen(join(' ', $tag_array)) > 117){
                echo "... ";
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
        <div class='form-group'>
            <input type='text' class='form-control correct-text' id='correct_$identifier' placeholder='your text' required>
            <input type='hidden' id='position_$identifier' value='$line $index $index1 $tag'>
            <button class='btn btn-default' id='tiger' onclick='runAjax("$identifier")'>Edit</button>   
            <button class='btn btn-default' onclick='runIgnore("$identifier")'>Ignore</button>
        </div>
    </div>
END;
}

function docLang($all_text){
    $text = htmlspecialchars_decode($all_text);
    $find = '/<html (.*?)>/';
    preg_match_all($find, $text, $arr_lang);
    $a1 = count($arr_lang[1]);
    $message = 'HTML documents don\'t have specific language';
    if ($a1 == 0){
        display_alert($message, 'lang-info', 'langInfo');
    } else if ($a1 ==1){
        if (!(preg_match('/lang="(...?)"/', $arr_lang[1][0]))){
            display_alert($message, 'lang-info', 'langInfo');
        }else {
            $lang = 'Language = <strong> English</strong>';
            display_auto($lang, 'basic-list','lang-check', 'langInfoTrue');
        }
    } else {
    	$lang = 'Language = <strong> English</strong>';
        display_auto($lang, 'basic-list','lang-check', 'langInfoTrue');
    }
}
function fix_glyph_icon($all_text){
    $arr_icon=array();
    $class ='glyph-check';
    $text = htmlspecialchars_decode($all_text);
    $find = '/<(span|i) class="(glyph|fa|ico)(?!.*aria)(.+?)"> ?<\/(span|i)>/';
    $find1 ='/<(span|i) class="(glyph|fa)(.*)" (style=".+")> ?<\/(span|i)>/';
    preg_match_all($find, $text, $icon_arr);
    $item1 = preg_replace($find, '<$1 class="$2$3" aria-hidden="true"></$4>', $text);
    foreach ($icon_arr[0] as $items){
        $a1 = preg_replace($find1, '<$1 class="$2$3"></$5>', $items);
        $a2 = preg_replace($find, '<$1 class="$2$3" aria-hidden="true"></$4>', $a1);
        array_push($arr_icon, "<li>".htmlspecialchars($a2)."</li>");
    }
    if (count($icon_arr[0])==0){
        $message = "No icon found";
        display_auto($message, 'basic-list',$class, 'glyphInfoTrue');
    } else {
        $a = count($icon_arr[0]);
        $message = $a." icon/s have been added accessibility features";
        display_auto($message, 'auto-list', $class, 'glyphInfo');
        display_child_many(implode(' ',$arr_icon), 'auto-list', $class, 'panel-success', 'icon-list');
    }
    echo <<< END
    <script type="text/javascript">
        document.getElementById("info-intro").style.display = "none";
        document.getElementById("nav-tab").style.visibility = "visible";
    </script>
END;
    return $item1;
}
function get_heading($all_text){
    $heading = array();
    $text = htmlspecialchars_decode($all_text);
    preg_match_all('/<h[1-6](.*?)>(.*?)<\/h[1-6]>/s', $text, $pat_array);
    foreach ($pat_array[0] as $keys=>$item){
        $h = $item[2];
        $item1 = preg_replace('/<\/?[a-z]?(.*?)>/', '', $item);
        $item2 = $h.' '.$item1;
        array_push($heading, $item2);
    }
    echo ' <div role="tabpanel" class="tab-pane" id="outline">';
    echo '<p class="bg-info">This is the structure of the content\'s header that understand by screen reader</p>';
    for ($i=0; $i<count($heading); $i++){
        echo '<p class="p-head p-'.$heading[$i][0].'"><span class="btn btn-head btn-sm btn-'.$heading[$i][0].'">H'.$heading[$i][0].'</span>'.substr($heading[$i], 1).'</p>';
    }
    echo '</div>';
}


function display_auto($message, $id_type, $type, $detail_info){
    echo <<< END
    <script type="text/javascript">
        $(document).ready(function(){
            $("ul#$id_type").append("<li class='$type'>$message </li>");
            $("ul#$id_type li.$type").append($('<a/>', 
                {'text': "More info", 'class': 'btn btn-info btn-sm', 'id': '$type'}).on({'click': function() { revealInfo("$type", "$detail_info") }}));
        });
    </script>
END;
}
function display_alert($message, $type, $detail_info){
    echo <<< END
    <script type="text/javascript">
        $(document).ready(function(){
            $("ul#alert-list").append("<li class='$type'>$message</li>");
            $("ul#alert-list li.$type").append($('<a/>', 
                {'text': "More info", 'class': 'btn btn-info btn-sm', 'id': '$type'}).on({'click': function() { revealInfo("$type", "$detail_info") }}));
            var size = $("#alert-list >li").length;
            document.getElementById("b-alert").className = "bub-alert";
            document.getElementById("b-alert").innerHTML = size;
        });
    </script>
END;
}
function display_error($message, $type, $detail_info){
    echo <<< END
    <script type="text/javascript">
        $(document).ready(function(){
            $("ul#error-list").append("<li class='$type'>$message</li>");
            $("ul#error-list li.$type").append($('<a/>', 
                {'text': "More info", 'class': 'btn btn-info btn-sm', 'id': '$type'}).on({'click': function() { revealInfo("$type", "$detail_info") }}));
        });
    </script>
END;
}
function display_child_many($message, $id_container, $li_class, $level, $id_child){
    echo <<< END
    <script type="text/javascript">
        $(document).ready(function(){
            $("ul#$id_container li.$li_class").append("<a class='collapsed btn btn-success btn-sm' role='button' data-toggle='collapse' data-parent='#accordion' href='#collapseIco' aria-expanded='false' aria-controls='collapseThree'><i class=' glyphicon glyphicon-menu-down'></i></a> <br />");
            $("ul#$id_container li.$li_class").append("<div id='collapseIco' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingThree'><div class='panel-body $level'><ol id='$id_child'></ol></div></div>")
            $("ol#$id_child").append("$message");
        });
    </script>
END;
}
function display_child_few($message, $id_container, $li_class, $child_id){
    echo <<< END
    <script type="text/javascript">
        $(document).ready(function(){
            $("ul#$id_container li.$li_class").append("<div class='few-kids'><ol id='$child_id'></ul></div></div>")
            $("ol#$child_id").append("$message");
        });
    </script>
END;
}
function display_contrast($message, $type, $detail_info){
    echo <<< END
    <script type="text/javascript">
        $(document).ready(function(){
            $("ul#contrast-list").append("<li class='$type'>$message</li>");
            $("ul#contrast-list li.$type").append($('<a/>', 
                {'text': "More info", 'class': 'btn btn-info btn-sm', 'id': '$type'}).on({'click': function() { revealInfo("$type", "$detail_info") }}));
        });
    </script>
END;
}
function display_child_form($id_container, $li_class, $id_child, $line, $tag){
    $identifier= $tag.$line.'3';
    $languages = file_get_contents('class-check/language.txt');
    $languages_all = preg_split("/\\r\\n|\\r|\\n/", $languages);
    echo <<< END
    <script type="text/javascript">
        $(document).ready(function(){
            $("ul#$id_container li.$li_class").append("<a class='collapsed btn btn-success btn-sm' role='button' data-toggle='collapse' data-parent='#accordion' href='#collapseForm' aria-expanded='false' aria-controls='collapseThree'>Change Language</a> <br />");
            $("ul#$id_container li.$li_class").append("<div id='collapseForm' class='$identifier panel-collapse collapse' role='tabpanel' aria-labelledby='headingThree'><div class='panel-body'><ol id='$id_child'></ol></div></div>")
            $("ol#$id_child").append("<div>" +
             "<div class='form-group'>" +
             "<input type='hidden' id='position_$identifier' value='$line 3 3 $tag'>"+
             "<select class='form-control' id='correct_$identifier'>"+
END;
    foreach ($languages_all as $lang){
        $lang = substr($lang, 24);
        echo <<<END
        "<option>$lang</option>"+
END;
    }
    echo <<< END
             "</select>" +
             "<button class='btn btn-default' id='tiger' onclick=runAjax('$identifier')>Edit</button>" +
             "</div>" +
             "</div>");
        });
    </script>
END;
}

?>