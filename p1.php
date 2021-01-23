<?php
#--session start():a way to store information (in variables) to be used across multiple pages.;
session_start();
#--include: The require() function is identical to include(), except that it handles errors differently. If an error occurs, the include() function generates a warning, ;
#but the script will continue execution.;
#The require() generates a fatal error, and the script will stop.;
#--require_once() statement is identical to require() except PHP will check if the file has already been included, and if so, not include (require) it again.;
require_once 'login.php';
include 'redir.php';
echo<<<_HEAD1
<html>
<body>
_HEAD1;
include 'menuf.php';
$db_server = mysql_connect($db_hostname,$db_username,$db_password);
if(!$db_server) die("Unable to connect to database: " . mysql_error());
mysql_select_db($db_database,$db_server) or die ("Unable to select database: " . mysql_error());
$query = "select * from Manufacturers";
$result = mysql_query($query);
#echo "$result  <br>";
if(!$result) die("unable to process query: " . mysql_error());
$rows = mysql_num_rows($result);
#until here the code is the same to complib.php;
$smask = $_SESSION['supmask'];
for($j = 0 ; $j < $rows ; ++$j)
  {
    $row = mysql_fetch_row($result);#
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
   echo 'Currently selected Suppliers: ';
   for($j = 0 ; $j < $rows ; ++$j)
      {
    	if($sact[$j] == 1) {
	  echo $snm[$j] ;
	  echo "<br> ";
	}
      }
    echo  '<br><pre> <form action="p1.php" method="post">';
    for($j = 0 ; $j < $rows ; ++$j)
      {
    	echo $snm[$j];
	echo' <input type="checkbox" name="supplier[]" value="';
	echo $snm[$j];
        echo'"/>';
	echo"\n";
      }
echo <<<_TAIL1
 <input type="submit" value="OK" />
</pre></form>
</body>
</html>
_TAIL1;
?>
