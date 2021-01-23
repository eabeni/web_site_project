<?php
session_start();
require_once 'login.php';
include 'redir.php';
echo<<<_HEAD1
<html>
<head>
<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="jquery.tablesorter.min.js"></script>





<link rel="stylesheet" type="text/css" href="style.css">




<style>

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  font-weight:bold;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: white;
}





</style>



</head>
<body>
_HEAD1;
include 'menuf.php';
$dbfs = array("id","catn","natm","ncar","nnit","noxy","nsul","ncycl","nhdon","nhacc","nrotb","mw","TPSA","XLogP");
$nms = array("ID number","catid","n atoms","n carbons","n nitrogens","n oxygens","n sulphurs","n cycles","n H donors","n H acceptors","n rot bonds","mol wt","TPSA","XLogP");
$rowid = array(0,11,1,2,3,4,5,6,7,8,9,12,13,14);


$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




#
#
#
$chosen = $_POST['tgval'];
$limit =$_POST['tgval2'];
#
#
#
if(isset($_POST['tgval'])){
$query = "select * from Compounds JOIN Manufacturers ON Compounds.ManuID = Manufacturers.id where name='".$chosen."' limit ".$limit;

$result = $conn->query($query);
if(!$result) die("unable to process query: " . mysqli_error());


$resrows = mysqli_num_rows($result);
//if($resrows > 500) $resrows = 500;
echo <<<_MAIN1
    <pre>
<stan style='font-size:50;font-weight=bold;font-family:calibri'> This is the Manufacturer display Page</stan>
_MAIN1;
    echo "<table id=\"myTable\" class=\"tablesorter\* width =\"70%\" border=\"2\" cellspacing=\"1\" align=\"center\"><thead><tr>";
    for($k = 0 ; $k < sizeof($dbfs) ; ++$k) {
      echo "<th>".$nms[$k]."</th>";
    }
    echo "</tr></thead><tbody>";
    for($j = 0 ; $j < $resrows ; ++$j)
      {
         $row = mysqli_fetch_row($result);
         echo "<tr>";
         for($k = 0 ; $k < sizeof($dbfs) ; ++$k) {

           if($k == 1) {echo "<td><a href='".$domain."Bioinformatics/p7_get_methods.php?ID=".$row[$rowid[0]]."'>".$row[$rowid[$k]]."</a></td>";}

                  else {echo "<td>".$row[$rowid[$k]]."</td>";}
         }
         echo "</tr>";
      }
      echo '</tbody></table>';
echo <<<_TAIL1
<script type="text/javascript">
$(function() {
  $("#myTable").tablesorter();
});
</script>
_TAIL1;


}

else
{
echo "No Query Given\n";

}


echo <<<_TAIL1
</body>
</html>
_TAIL1;
?>
