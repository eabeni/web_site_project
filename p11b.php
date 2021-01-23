<?php
session_start();
require_once 'login.php';
include 'redir.php';
echo<<<_HEAD1
<html>
<head>
<script type="text/javascript" src="jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="jquery.tablesorter.min.js"></script>
</head>
<body>
_HEAD1;
include 'menuf.php';
$dbfs = array("catn","natm","ncar","nnit","noxy","nsul","ncycl","nhdon","nhacc","nrotb","mw","TPSA","XLogP");
$nms = array("catid","n atoms","n carbons","n nitrogens","n oxygens","n sulphurs","n cycles","n H donors","n H acceptors","n rot bonds","mo
l wt","TPSA","XLogP");
$rowid = array(11,1,2,3,4,5,6,7,8,9,12,13,14);
$db_server = mysql_connect($db_hostname,$db_username,$db_password);
if(!$db_server) die("Unable to connect to database: " . mysql_error());
mysql_select_db($db_database,$db_server) or die ("Unable to select database: " . mysql_error());
$query = "select * from Manufacturers";
$result = mysql_query($query);
if(!$result) die("unable to process query: " . mysql_error());
$manrows = mysql_num_rows($result);
$manarray = array();
$manid = array();
$chosen = $_POST['tgval'];
for($j = 0 ; $j < $manrows ; ++$j)
  {
    $row = mysql_fetch_row($result);
    $manarray[$j] = $row[1];
    $manid[$j] = $j + 1;
  }
$query = "select * from Compounds where ManuID = ".$chosen;
$result = mysql_query($query);
if(!$result) die("unable to process query: " . mysql_error());
$resrows = mysql_num_rows($result);
//if($resrows > 500) $resrows = 500;
echo <<<_MAIN1
    <pre>
This is the Manufacturer display Page
_MAIN1;
    echo "<table id=\"myTable\" class=\"tablesorter\* width =\"70%\" border=\"2\" cellspacing=\"1\" align=\"center\"><thead><tr>";
    for($k = 0 ; $k < sizeof($dbfs) ; ++$k) {
      echo "<th>".$nms[$k]."</th>";
    }
    echo "</tr>\n</thead>\n<tbody>\n";
    for($j = 0 ; $j < $resrows ; ++$j)
      {
         $row = mysql_fetch_row($result);
         echo "<tr>";
         for($k = 0 ; $k < sizeof($dbfs) ; ++$k) {
           echo "<td>".$row[$rowid[$k]]."</td>";
         }
         echo "</tr>\n";
      }
      echo '</tbody>\n</table>\n';
echo <<<_TAIL1
<script type="text/javascript">
$(function() {
  $("#myTable").tablesorter();
});
</script>
</body>
</html>
_TAIL1;
?>
