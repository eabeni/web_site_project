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
    <p style="color:blue;font-size:35px;">This is the compound statistic page</p>
    <br>
_MAIN1;
if(isset($_POST['tgval']))
   {
     $chosen = 0;
     $tgval = $_POST['tgval'];
     for($j = 0 ; $j <sizeof($dbfs) ; ++$j) {
       if(strcmp($dbfs[$j],$tgval) == 0) $chosen = $j;
     }

     printf("<span style='color:black;font-size:30px;font-weight:bold'> Statistics for %s (%s)</span><br/>\n",$dbfs[$chosen],$nms[$chosen]);
     //Your mysql and statistics calculation goes here
     $conn = new mysqli($servername, $username, $password, $dbname);
     // Check connection
     if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
     }


     //old part
     $query = sprintf("select AVG(%s), STD(%s), MIN(%s), MAX(%s) from Compounds",$dbfs[$chosen],$dbfs[$chosen],$dbfs[$chosen],$dbfs[$chosen]);

     $result = $conn->query($query);
     if(!$result) die("unable to process query: " . mysqli_error());


     $row = mysqli_fetch_row($result);
     printf("<span style='color:black;font-size:30px;font-weight:bold'> Average %.3f <br>  Standard Dev  %.3f <br>Minimum  %.3f <br>Maximum %.3f <br />\n</span>",$row[0],$row[1],$row[2],$row[3]);



     // part to make the histogram
     if(isset($_POST['tgval_2'])){
     $query = "select * from Manufacturers";

     $result = $conn->query($query);
     if(!$result) die("unable to process query: " . mysqli_error());


     $rows = mysqli_num_rows($result);
     $smask = $_SESSION['supmask'];
     $firstmn = False;
     $mansel = "(";
     for($j = 0 ; $j < $rows ; ++$j) {
      $row = mysqli_fetch_row($result);
      $sid[$j] = $row[0];
      $snm[$j] = $row[1];
      $sact[$j] = 0;
      $tvl = 1 << ($sid[$j] - 1);
      if($tvl == ($tvl & $smask)) {
        $sact[$j] = 1;
        if($firstmn) $mansel = $mansel." or ";
        $firstmn = True;
        $mansel = $mansel." (ManuID = ".$sid[$j].")";
      }
     }
     $mansel = $mansel.")";
     $comtodo = "./histog.py ".$dbfs[$chosen]." \"".$nms[$chosen]."\" \"".$mansel."\"";
     $output = base64_encode(shell_exec($comtodo));
     echo <<<_imgput
     <pre>
     <img  src="data:image/png;base64,$output" />
     </pre>
_imgput;
   }}

else {
    echo "No Query Given\n";
  }


echo <<<_TAIL1
</body>
</html>
_TAIL1;

?>
