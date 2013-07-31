<?php 
$con=mysqli_connect("localhost","root","","mydata");

if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  die();
  }
if($term  = $_REQUEST['term']) {
	if($term != '') {
	  $st=mysqli_query($con,"SELECT state
		FROM  `district_data1` 
		WHERE state LIKE  '".$term."%' 
		GROUP BY state ORDER BY state LIMIT 0,10 ");
	  $vst = array();
	  while($rst=mysqli_fetch_array($st))
	  {
		$_temp = new stdClass();
		$_temp->label = $rst['state'];
		$_temp->value = $rst['state'];
		$_temp->level = 'state';
		$vst[] = $_temp;
		}
		$st=mysqli_query($con,"SELECT state, district
		FROM  `district_data1` 
		WHERE district LIKE  '".$term."%' 
		GROUP BY district ORDER BY district LIMIT 0,10 ");
	  
	  while($rst=mysqli_fetch_array($st))
	  {
		$_temp = new stdClass();
		$_temp->label = $rst['district'].', '.$rst['state'] ;
		$_temp->value = $rst['district'];
		$_temp->level = 'district';
		$vst[] = $_temp;
		}
		
		$st=mysqli_query($con,"SELECT state, district, block
		FROM  `block_data2` 
		WHERE block LIKE  '".$term."%' 
		GROUP BY district ORDER BY district LIMIT 0,10 ");
		
	while($rst=mysqli_fetch_array($st))
	  {
		$_temp = new stdClass();
		$_temp->label = $rst['block'].', '.$rst['district'].', '.$rst['state'] ;
		$_temp->value = $rst['block'];
		$_temp->level = 'block';
		$vst[] = $_temp;
		}
	  
		print json_encode($vst);
	}	
}