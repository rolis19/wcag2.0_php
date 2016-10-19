<?php
$tag = $_POST['tag'];
if (isset($_POST["name_$tag"])) {
    mysql_connect("localhost","root","");
    mysql_select_db("wcag_correct");
    error_reporting(E_ALL && ~E_NOTICE);
    $words = $_POST["name_$tag"];
    $position = $_POST["index_$tag"];
    $sql="INSERT INTO user_value(position, value) VALUES ('$position', '$words')";
    $result=mysql_query($sql);
    if($result){
        echo "data inserted.";
    } else {
        echo "gagal";
    }
}
?>