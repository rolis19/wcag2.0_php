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
    echo "<p> Fault in <a href='#' class='line$line'>line ".$line."</a></p>";
    $desc="";
    $info ="Without double quote";
    switch ($tag){
        case 'img':
            echo <<< END
            <p>Img tag dosen't have 'alt' properties | WCAG 2.0 level A Percivable 
            <a href='#' id='open-button$line' class='btn btn-sm btn-info' onclick="revealInfo('open-button$line', '$tag')">
            More info <i class='glyphicon glyphicon-info-sign'></i></a>
            </p>
            <hr />
END;
            $desc = "Give alt value";
            $word = "<code>".htmlspecialchars('alt="..."')."</code>";
            $a1 = array($tag_array[0], $word);
            array_splice($tag_array, 0,1,$a1);
            echo "<p class='tag-info'>";
            echo substr(join(' ', $tag_array), 0, 117);
            if (strlen(join(' ', $tag_array)) > 117){
                echo "... ";
            }
            echo "</p>";
            break;

        case 'input':
            echo <<< END
            <p>Input tag needs aria-label properties | WCAG 2.0 level A Percivable 
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
?>