<html>
<head>
<title> HOME </title>
</head>
<body>
<table border="1">
<tr>
<th><h>Village</th>
<th><h>Habitation</th>
<th><h>Percentage</th>
</tr>
<?php
$d=54;
$val=$_GET['a'];
$min=$_GET['b'];
$max=$_GET['c'];
$con=mysqli_connect("localhost","root","","mydata");

if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$blk=mysqli_query($con,"select distinct village,habitation,percentage from cdata where block='$val' and percentage>=$min and percentage<=$max");
while($blkr=mysqli_fetch_array($blk))
{
$hbv=$blkr['habitation'];

$vlg=$blkr['village'];

$pr=$blkr['percentage'];


?>
<tr>
<td> <?php echo $vlg; ?></td>
<td> <?php echo $hbv; ?></td>
<td> <?php echo $pr."%"; ?></td>


</tr>
<?php

$d=$d+1;
}
?>
</table>
</body>
</html>
