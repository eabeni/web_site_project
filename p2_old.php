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


</style>



<body>
_HEAD1;
include 'menuf.php';
$db_server = mysql_connect($db_hostname,$db_username,$db_password);
if(!$db_server) die("Unable to connect to database: " . mysql_error());
mysql_select_db($db_database,$db_server) or die ("Unable to select database: " . mysql_error());
$query = "select * from Manufacturers";
$result = mysql_query($query);
if(!$result) die("unable to process query: " . mysql_error());
$rows = mysql_num_rows($result);
$smask = $_SESSION['supmask'];
$firstmn = False;
$mansel = "(";
for($j = 0 ; $j < $rows ; ++$j)
  {
    $row = mysql_fetch_row($result);
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
echo <<<_MAIN1
    <p style="color:blue;font-size:35px;">
Catalogue retrieval Page: please fill the boxes to retrieve the CAT number of compounds
    </p>
_MAIN1;




if($setpar) {
  $firstsl = False;
  $compsel = "select catn,id from Compounds where (";
  if (($_POST['natmax'] != "") && ($_POST['natmin']!="")) {
    $compsel = $compsel."(natm > ".get_post('natmin')." and  natm < ".get_post('natmax').")";
    $firstsl = True;
  }
  if (($_POST['ncrmax']!="") && ($_POST['ncrmin']!="")) {
    if($firstsl) $compsel = $compsel." and ";
    $compsel = $compsel."(ncar > ".get_post('ncrmin')." and  ncar < ".get_post('ncrmax').")";
    $firstsl = True;
  }
  if (($_POST['nntmax']!="") && ($_POST['nntmin']!="")) {
    if($firstsl) $compsel = $compsel." and ";
    $compsel = $compsel."(nnit > ".get_post('nntmin')." and  nnit < ".get_post('nntmax').")";
    $firstsl = True;
  }
  if (($_POST['noxmax']!="") && ($_POST['noxmin']!="")) {
    if($firstsl) $compsel = $compsel." and ";
    $compsel = $compsel."(noxy > ".get_post('noxmin')." and  noxy < ".get_post('noxmax').")";
    $firstsl = True;
  }
  echo "<pre>";
  if($firstsl) {
    $compsel = $compsel.") and ".$mansel;
    echo $compsel;
    echo "\n";
     $result = mysql_query($compsel);
     if(!result) die("unable to process query: " . mysql_error());
     $rows = mysql_num_rows($result);
     if($rows > 100) {
       echo "Too many results ",$rows," Max is 100\n";
     } else  {
     for($j = 0 ; $j < $rows ; ++$j)
       {
	 $row = mysql_fetch_row($result);
   if(isset($_POST['tgval'])){
   $compsel_2= "select smiles from Smiles where id= $row[1]";
   $result_2=mysql_query($compsel_2);
   if(!result_2) die("unable to process query: " . mysql_error());
   $row_2 = mysql_fetch_row($result_2);
	 echo $row[0]," ",$row_2[0],"\n";
   $convurl = "https://cactus.nci.nih.gov/chemical/structure/".urlencode($row_2[0])."/image";
   $convstr = base64_encode(file_get_contents($convurl));
   echo "<img  src='data:image/gif;base64,$convstr'>";} else {echo $row[0],"\n";}
       }
     }
  }




  else {
    echo "No Query Given\n";
  }
  echo "</pre>";
}
echo <<<_TAIL1
   <div class=box>
   <form action="p2.php" method="post"><pre>
       Min Atoms    <input type="text" name="natmin"/>      Max Atoms      <input type="text" name="natmax"/>
       Min Carbons  <input type="text" name="ncrmin"/>      Max Carbons    <input type="text" name="ncrmax"/>
       Min Nitrogens<input type="text" name="nntmin"/>      Max Nitrogens  <input type="text" name="nntmax"/>
       Min Oxygens  <input type="text" name="noxmin"/>      Max Oxygens    <input type="text" name="noxmax"/>
       Show Smiles structure <input type="radio" name="tgval" value="yes"/>
                   <input type="submit" value="list" />
</pre></form></div>



</body>
</html>
_TAIL1;

$property[]="natm";
$property[]="ncar";
$property[]="nnit";
$property[]="noxy";

foreach($property as $value){

     $query = sprintf("select AVG(%s), STD(%s), MIN(%s), MAX(%s) from Compounds",$value,$value,$value,$value);
     $result = mysql_query($query);
     if(!$result) die("unable to process query: " . mysql_error());
     $row = mysql_fetch_row($result);
     printf("$value stat: Average %.2f  Standard Dev %.2f Minimum %.0f Maximum %.0f <br />\n",$row[0],$row[1],$row[2],$row[3]);

}




function get_post($var)
{
  return mysql_real_escape_string($_POST[$var]);
}
?>
