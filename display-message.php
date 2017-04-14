<?php
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
    echo '<ul>';
    echo '<li>The structure of the page <a href="#" id="outline-info" class="btn btn-sm btn-info" onclick="revealInfo(\'outline-info\', \'outlineInfo\')">More info</a></li>';
    echo '</ul>';
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
        });
    </script>
END;
}
function display_error($message, $type, $detail_info, $id_panel, $panel_btn){
    echo <<< END
    <script type="text/javascript">
        $(document).ready(function(){
            $("ul#error-list").append("<li class='$type'>$message " +
             "<a id='$type' class='btn btn-info btn-sm' onclick='revealInfo(&quot;$type&quot;, &quot;$detail_info&quot;)'> Detail Info</a></li>" +
             "<div id='$id_panel' class='panel-collapse collapse' role='tabpanel'>" +
             "<div class='panel-body'></div>"+
             "</div>");
            $("ul#error-list li.$type").append(" <a class='collapsed btn btn-success btn-sm' data-toggle='collapse' href='#$id_panel'>$panel_btn</a><br />");
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
function displayChangeLang($id_container, $li_class, $id_child, $line, $tag){
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
function display_child_img($message, $id_container, $li_class, $child_id){
    echo <<< END
    <script type="text/javascript">
        $(document).ready(function(){
            $("ul#$id_container li.$li_class").append("<div class='few-kids'><ol id='$child_id'></ul></div></div>")
            $("ol#$child_id").append("$message");
        });
    </script>
END;
}
function displayInput($id_panel, $tag_full, $line1, $index, $tag){
    $identifier= $tag.$line1;
    echo <<< END
    <script type="text/javascript">
        $(document).ready(function(){
            $("div#$id_panel .panel-body").append("<div class='$identifier form-container'>" +
            "<div class='info-detail'><p>Fault in <a href='#' onclick='toLine(&quot;$line1&quot;)'>line $line1</a></p><p class='tag-info'>$tag_full</p></div>"+
            "<label for=correct_$identifier>Insert Value of Aria-label</label>"+
            "<div class='form-group'>" +
            "<input class='form-control correct-text' id='correct_$identifier' placeholder='your text' type='text'>"+
            "<input id='position_$identifier' value='$line1 $index 0 $tag' type='hidden'>"+
            "<button class='btn btn-default' onclick='runAjax(&quot;$identifier&quot;)'>Edit</button>"+
            "<button class='btn btn-default' onclick='runIgnore(&quot;$identifier&quot;)'>Ignore</button>"+
            "</div>"+
            "</div>");
        });
    </script>
END;
}

?>