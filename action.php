<?php 

if (isset($_POST['name'])) {
	mysql_connect("localhost","root","");
	mysql_select_db("wcag_correct");
	error_reporting(E_ALL && ~E_NOTICE);

	$words = $_POST['name'];
	$position = $_POST['position'];
	$sql="INSERT INTO user_value(position, value) VALUES ('$position', '$words')";
	$result=mysql_query($sql);
	if($result){
		echo "You have been successfully subscribed.";
	} else {
		echo "gagal";
	}
}

?>
