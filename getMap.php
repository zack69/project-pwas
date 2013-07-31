<?php
$con=mysqli_connect("localhost","root","","mydata");

if (mysqli_connect_errno($con))
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	die();
}

$term = $_REQUEST['term'];
$min_per = $_REQUEST['min_per'];
$max_per = $_REQUEST['max_per'];
$level = $_REQUEST['level'];

if($term != '') {
	if($level == 'state') {
		/**$sql = "SELECT *
			FROM  `district_data1` 
			WHERE state = '".$term."' and percentage >= ".$min_per." and percentage <= ".$max_per."";*/
		$sql="SELECT m.district, d.longitude, d.latitude
FROM `cdata` m
INNER JOIN district_data1 d ON d.district = m.district
WHERE m.state = '".$term."'
AND m.percentage >= ".$min_per." and m.percentage <= ".$max_per."
GROUP BY m.district";
		$st=mysqli_query($con, $sql);
		$vst = array();
		
		while($rst=mysqli_fetch_array($st))
		{
			$_temp = new stdClass();
			$_temp->lat = $rst['latitude'];
			$_temp->lng = $rst['longitude'];
			$_temp->title = $rst['district']; //forhovermessage
			$_temp->calln = 1; //for next level onclick
			$_temp->pop=""; //for popup message
			$vst[] = $_temp;
		}
	
		print json_encode($vst);
	}
	if($level == 'district') {
		/**$sql = "SELECT *
			FROM  `district_data1` 
			WHERE district = '".$term."' and percentage >= ".$min_per." and percentage <= ".$max_per."";*/
		$sql="SELECT m.block, d.longitude, d.latitude
FROM `cdata` m
INNER JOIN block_data2 d ON d.block = m.block
WHERE m.district = '".$term."'
AND m.percentage >= ".$min_per." and m.percentage <= ".$max_per."
GROUP BY m.block";
		
		$st=mysqli_query($con, $sql);
		$vst = array();
		
		while($rst=mysqli_fetch_array($st))
		{
			$_temp = new stdClass();
			$_temp->lat = $rst['latitude'];
			$_temp->lng = $rst['longitude'];
			$_temp->title = $rst['block'];
			$_temp->pop="<a class='fancybox fancybox.iframe' href='./homes.php?a=".$rst['block']."&b=".$min_per."&c=".$max_per."'>Get Habitation Level Data</a>"; //for popup message
			$vst[] = $_temp;
		}
	
		print json_encode($vst);
	}
	
		if($level == 'block') {
		/**$sql = "SELECT *
			FROM  `block_data2` 
			WHERE block = '".$term."' and percentage >= ".$min_per." and percentage <= ".$max_per."";*/
		
		$sql="SELECT m.block, d.longitude, d.latitude
FROM `cdata` m
INNER JOIN block_data2 d ON d.block = m.block
WHERE m.block = '".$term."'
AND m.percentage >= ".$min_per." and m.percentage <= ".$max_per."
GROUP BY m.block";
		
		$st=mysqli_query($con, $sql);
		$vst = array();
		
		while($rst=mysqli_fetch_array($st))
		{
			$_temp = new stdClass();
			$_temp->lat = $rst['latitude'];
			$_temp->lng = $rst['longitude'];
			$_temp->title = $rst['block'];
			$_temp->pop="<a class='fancybox fancybox.iframe' href='./homes.php?a=".$rst['block']."&b=".$min_per."&c=".$max_per."'>Get Habitation Level Data</a>"; //for popup message
			$vst[] = $_temp;
		}
	
		print json_encode($vst);
	}
}
