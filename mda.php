<?php
$userinfo = "
<h5 class=\"media-heading\">
	<a class=\"media-left\" href=\"https://www.kku.ac.th/news/v.php?q=0013538&l=th\">
		มูลนิธิโตโยต้าฯ มอบทุนการศึกษากว่า 3.9 ล้าน แก่ นร.นศ. ภาคอีสาน ปี2559</a>	
</h5>
";
preg_match_all ("|<h[1-6]>(.*)</h[1-6]>|U", $userinfo, $pat_array);

foreach ($pat_array as $keys=>$line){
    echo "<br>".$keys." ";
    foreach ($line as $key=>$position){
        echo htmlspecialchars($position);
    }
}
?>