<?php
session_start();
require_once 'login.php';
include 'redir.php';
echo<<<_HEAD1
<html>

<head>

<link rel="stylesheet" type="text/css" href="style.css">


</head>

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



<body>
_HEAD1;
include 'menuf.php';



function get_post($var)
{
  return mysqli_real_escape_string($_POST[$var]);
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
$setpar = isset($_POST['natmax']);




if($setpar) {
  $firstsl = False;
  $compsel = "select catn,id from Compounds where (";
  if (($_POST['natmax'] != "") && ($_POST['natmin']!="")) {
    $compsel = $compsel."(natm > ".$_POST['natmin']." and  natm < ".$_POST['natmax'].")";
    $firstsl = True;
  }
  if (($_POST['ncrmax']!="") && ($_POST['ncrmin']!="")) {
    if($firstsl) $compsel = $compsel." and ";
    $compsel = $compsel."(ncar > ".$_POST['ncrmin']." and  ncar < ".$_POST['ncrmax'].")";
    $firstsl = True;
  }
  if (($_POST['nntmax']!="") && ($_POST['nntmin']!="")) {
    if($firstsl) $compsel = $compsel." and ";
    $compsel = $compsel."(nnit > ".$_POST['nntmin']." and  nnit < ".$_POST['nntmax'].")";
    $firstsl = True;
  }
  if (($_POST['noxmax']!="") && ($_POST['noxmin']!="")) {
    if($firstsl) $compsel = $compsel." and ";
    $compsel = $compsel."(noxy > ".$_POST['noxmin']." and  noxy < ".$_POST['noxmax'].")";
    $firstsl = True;
  }
  echo "<pre>";

  if($firstsl) {
    $compsel = $compsel.") and ".$mansel;

     $result = $conn->query($compsel);
     if(!result) die("unable to process query: " . mysqli_error());
     $rows = mysqli_num_rows($result);
     if($rows > 100) {
       echo "Too many results ",$rows," Max is 100\n";
     } else  {
     for($j = 0 ; $j < $rows ; ++$j)
       {
	 $row = mysqli_fetch_row($result);
   if(isset($_POST['tgval'])){
   $compsel_2= "select smiles from Smiles where cid= $row[1]";
   $result_2=$conn->query($compsel_2);
   if(!result_2) die("unable to process query: " . mysqli_error());
   $row_2 = mysqli_fetch_row($result_2);
	 echo "<table><tr><th><a href='".$domain."Bioinformatics/p7_get_methods.php?ID=".$row[1]."'>".$row[0]."</a></td></th><th>".$row_2[0]."</th>";
   $convurl = "https://cactus.nci.nih.gov/chemical/structure/".urlencode($row_2[0])."/image";
   $convstr = base64_encode(file_get_contents($convurl));
   echo "</tr><tr><th><br><img  src='data:image/gif;base64,$convstr'><br><br><br></tr></table>";} else {echo "<table><tr><th><a href='".$domain."Bioinformatics/p7_get_methods.php?ID=".$row[1]."'>".$row[0]."</a></td></th></table>","\n";}
       }
     }

  }




  else {
    echo "No Query Given\n";
  }
  echo "</pre>";
}







echo <<<_TAIL1



</div>
</body>
</html>

_TAIL1;



?>
