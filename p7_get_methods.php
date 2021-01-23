<?php
session_start();
include 'redir.php';
require_once 'login.php';
echo<<<_HEAD1
<html>

<head>
<title>Visualization page </title>
<meta charset="utf-8">

_HEAD1;


echo '<script type="text/javascript" src="'.$domain.'Bioinformatics/jsmol/JSmol.min.js"></script>';

echo<<<_HEAD2
<style>

<link rel="stylesheet" type="text/css" href="style.css">

table {
  font-family: arial, sans-serif;

  border-collapse: collapse;
  width: 100%;
}

td, th {
  font-size:20px;
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>


</head>




<body>
_HEAD2;
include 'menuf.php';




if($_GET['ID']!="") {


echo <<<_MAIN1
    <p style="color:blue;font-size:30">
This page retrieve molecule coordinates for a specific ID
    </p>
_MAIN1;


$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}




$ID = $_GET['ID'];



echo "<p style='font-size:30'><b> The ID of the Compound selected is $ID </b></p>";
$dbfs = array("catn","natm","ncar","nnit","noxy","nsul","ncycl","nhdon","nhacc","nrotb","mw","TPSA","XLogP");
$nms = array("catid","n atoms","n carbons","n nitrogens","n oxygens","n sulphurs","n cycles","n H donors","n H acceptors","n rot bonds","mol wt","TPSA","XLogP");
$rowid = array(11,1,2,3,4,5,6,7,8,9,12,13,14);
$query = "select * from Compounds  where id='".$ID."'";

$result = $conn->query($query);
if(!$result) die("unable to process query: " . mysqli_error());
$resrows = mysqli_num_rows($result);



if($resrows==0){
echo "<p><b> ID name '$ID' is not present in the database </b></p>";}
else {
echo <<<_MAIN1
    <pre>
_MAIN1;
    echo "<table><tr>";
    for($k = 0 ; $k < sizeof($dbfs) ; ++$k) {
      echo "<th>".$nms[$k]."</th>";
    }
    echo "</tr></thead><tbody>";
    for($j = 0 ; $j < $resrows ; ++$j)
      {
         $row = mysqli_fetch_row($result);
         echo "<tr>";
         for($k = 0 ; $k < sizeof($dbfs) ; ++$k) {
           echo "<td>".$row[$rowid[$k]]."</td>";
         }
         echo "</tr>";
      }

}


################

$compsel_2= "select smiles from Smiles where cid='".$ID."'";
   $result_2=mysqli_query($compsel_2);
   if(!result_2) die("unable to process query: " . mysqli_error());
   $row_2 = mysqli_fetch_row($result_2);
   if($row_2[0]==""){}
   else {
	 echo "<table><tr><td>Smiles Formula</td>";
   echo "<td><span style='font-size:20px'> $row_2[0];</span></td></tr>";
   $convurl = "https://cactus.nci.nih.gov/chemical/structure/".urlencode($row_2[0])."/image";
   $convstr = base64_encode(file_get_contents($convurl));

   echo "<tr><td>2D Smiles structure</td><td><br><img  src='data:image/gif;base64,$convstr'><br><br><br></td></tr>";
   }
#########
$query = "select molecule from Molecules where cid='".$ID."'";
$result = $conn->query($query);
if(!$result) die("unable to process query: " . mysqli_error());
$row = mysqli_fetch_row($result);
if($row[0]==""){}
else {
echo <<<_endpage2
<script type="text/javascript">
$(document).ready(function() {
Info = {
        width: 400,
        height: 400,
        debug: false,
        j2sPath: "jsmol/j2s",
        color: "0xC0C0C0",
  disableJ2SLoadMonitor: true,
  disableInitialConsole: true,
        addSelectionOptions: false,
        readyFunction: null,
        src: "data:text/javascript;base64,$row[0]"
}
$("#mydiv").html(Jmol.getAppletHtml("jmolApplet0",Info))
});
</script>

<tr><td>3D structure</td><td><span id=mydiv></span>

<p>
<a href="javascript:Jmol.script(jmolApplet0, 'spin on')">spin on</a>

<a href="javascript:Jmol.script(jmolApplet0, 'spin off')">spin off</a>
</p></td></tr>
_endpage2;
echo "<tr><td>Melecular Coordinates</td><td><pre>",base64_decode($row[0]),"</pre></td></tr></table>";
}

##############################






mysql_close($db_server);
}

else
{
echo "No Query Given\n";

}


echo <<<_MAIN2

</body>
</html>
_MAIN2;
�
?>
