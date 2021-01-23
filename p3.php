<?php
session_start();
include 'redir.php';
require_once 'login.php';
echo<<<_HEAD1
<html>

<head>

<link rel="stylesheet" type="text/css" href="style.css">


</head>

<style>


</style>



<body>
_HEAD1;
include 'menuf.php';
$dbfs = array("natm","ncar","nnit","noxy","nsul","ncycl","nhdon","nhacc","nrotb","mw","TPSA","XLogP");
$nms = array("n atoms","n carbons","n nitrogens","n oxygens","n sulphurs","n cycles","n H donors","n H acceptors","n rot bonds","mol wt","TPSA","XLogP");
echo <<<_MAIN1
    <p style="color:blue;font-size:35px;">This is the specific property statistics page</p><span style="color:blue;font-size:20px;"> Choose a compound property to see basic statistics (AVG, ST DEV, MIN and MAX) and histogram of the currently selected Suppliers</span></p>
_MAIN1;



echo '<form action="p3b.php" method="post">';
echo '<br><i style="color:black;font-size:25px">Show Histogram <input type="radio" name="tgval_2" value="yes"/></i>';
echo '<div class=box>';
echo '<pre>';
for($j = 0 ; $j <sizeof($dbfs) ; ++$j) {
  if($j == 0) {
     printf('<i style="color:black;font-size:25px"> %15s <input type="radio" name="tgval" value="%s" checked></i>',$nms[$j],$dbfs[$j]);
  } else {
     printf('<i style="color:black;font-size:25px"> %15s <input type="radio" name="tgval" value="%s"></i>',$nms[$j],$dbfs[$j]);
  }
  echo "\n";
}
echo '<input type="submit" value="OK" />';
echo '</pre></div></form>';




$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$query = "select * from Manufacturers";

$result = $conn->query($query);
if(!$result) die("unable to process query: " . mysqli_error());



$rows = mysqli_num_rows($result);
#until here the code is the same to complib.php;
$smask = $_SESSION['supmask'];
for($j = 0 ; $j < $rows ; ++$j)
  {
    $row = mysqli_fetch_row($result);#
    $sid[$j] = $row[0];
    #echo "sid is now $row <br>";
    $snm[$j] = $row[1];
    #echo "snm is now $row[1]<br>";
    $sact[$j] = 0;
    #echo "sact is now $sact[$j]<br>";
    $tvl = 1 << ($sid[$j] - 1);
    #echo "tv1 is now $tv1 <br>";
    if($tvl == ($tvl & $smask)) {
	$sact[$j] = 1;
  #echo "sact is now $sact[$j]<br>";
      }
  }
#isset checks if the variable is empty
if(isset($_POST['supplier']))
   {
     $supplier = $_POST['supplier'];
     $nele = sizeof($supplier);
      for($k = 0; $k <$rows; ++$k) {
       $sact[$k] = 0;
       for($j = 0 ; $j < $nele ; ++$j) {
	 if(strcmp($supplier[$j],$snm[$k]) == 0) $sact[$k] = 1;
       }
     }
     $smask = 0;
     for($j = 0 ; $j < $rows ; ++$j)
       {
	 if($sact[$j] == 1) {
	   $smask = $smask + (1 << ($sid[$j] - 1));
	 }
       }
     $_SESSION['supmask'] = $smask;
   }
   #this part is for the first line of text;

   echo '<div class=box>';
   echo '<span style=color:black;font-size:20px>Currently selected Suppliers: </span>';
   for($j = 0 ; $j < $rows ; ++$j)
      {
    	if($sact[$j] == 1) {
    echo "<span style=color:black;font-size:20px>&#8226; $snm[$j]   </span>";
    $supplier[]=$snm[$j]; #to retrieve the supplier to use in the query for page2
	}
      }
    echo '<br><br><span style=color:black;font-size:20px>Select Suppliers: </span>';
    echo  '<pre style=color:black;font-size:20px> <form action="p3.php" method="post">';
    for($j = 0 ; $j < $rows ; ++$j)
      {
    	echo $snm[$j];
	echo' <input type="checkbox" name="supplier[]" value="';
	echo $snm[$j];
        echo'"/>';
	echo" ";
      }
echo <<<_TAIL1
 <input type="submit" value="OK" />
</pre></form></div>

_TAIL1;






echo <<<_TAIL1
</body>
</html>
_TAIL1;

?>
