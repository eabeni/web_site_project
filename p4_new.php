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
echo<<<_MAIN1
    <pre style="font-family: Calibri;color:blue;font-size:35px;">Correlation page: results
</pre>
_MAIN1;




if(isset($_POST['tgval']) && isset($_POST['tgvalb']))
   {
     $chosen = 0;
     $tgval = $_POST['tgval'];
     $tgvalb = $_POST['tgvalb'];
     for($j = 0 ; $j <sizeof($dbfs) ; ++$j) {
       if(strcmp($dbfs[$j],$tgval) == 0) $chosen = $j;
     }
     for($j = 0 ; $j <sizeof($dbfs) ; ++$j) {
       if(strcmp($dbfs[$j],$tgvalb) == 0) $chosenb = $j;
     }
     $conn = new mysqli($servername, $username, $password, $dbname);
     // Check connection
     if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
     }


     $query = "select * from Manufacturers";


     $result = $conn->query($query);
     if(!$result) die("unable to process query: " . mysqli_error());
     $rows = mysqli_num_rows($result);
     $smask = $_SESSION['supmask'];
     $firstmn = False;
     $mansel = "(";
     for($j = 0 ; $j < $rows ; ++$j)
    {
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
    $comtodo = "./correlate_bis_3.py ".$dbfs[$chosen]." ".$dbfs[$chosenb]." \"".$mansel."\"";
    printf("<div class='box'> Correlation for %s (%s) vs %s (%s) <br />\n",$dbfs[$chosen],$nms[$chosen],$dbfs[$chosenb],$nms[$chosenb]);
    $rescor = system($comtodo);
    printf("\n </div>");

    if(isset($_POST['tgval_2'])){
    $comtodo = "./correlate3.py ".$dbfs[$chosen]." ".$dbfs[$chosenb]." \"".$mansel."\"";
    $output = base64_encode(shell_exec($comtodo));
    echo "<br><br><br>";
    echo <<<_imgput
     <pre>
     <img  src="data:image/png;base64,$output" />
     </pre>
_imgput;

   }



   }

else {
    echo "No Query Given\n";
  }
echo <<<_TAIL1
</body>
</html>
_TAIL1;

?>
