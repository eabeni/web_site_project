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

echo <<<_MAIN1
    <p style="color:blue;font-size:35px;">This is the table compounds page</p><span style="color:blue;font-size:20px;"> Choose a company to display all the compounds available for that supplier</span></p>
_MAIN1;



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






 echo '<div class=box><form action="p13_sort.php" method="post">';

  for($j = 0 ; $j < count($snm) ; ++$j){

  if($j == 0) {
printf('<input type="radio" id="%s" name="tgval" value="%s"><label for="%s" checked>%s</label>',$snm[$j],$snm[$j],$snm[$j],$snm[$j]);
}else {

printf('<input type="radio" id="%s" name="tgval" value="%s"><label for="%s"/>%s</label>',$snm[$j],$snm[$j],$snm[$j],$snm[$j]);}
echo "\n";
    }


echo <<<_TAIL1
 <input type="submit" value="OK" />
 <br>
 Limit the number of results to the first    <input type="text" name="tgval2" value="500"/> compounds
</form></div>

_TAIL1;






echo <<<_TAIL1
</body>
</html>
_TAIL1;

?>
