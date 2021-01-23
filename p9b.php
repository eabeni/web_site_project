<?php
session_start();
require_once 'login.php';
include 'redir.php';
echo<<<_HEAD1
<html>
<head>
<style>

<link rel="stylesheet" type="text/css" href="style.css">

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
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
_HEAD1;
include 'menuf.php';

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$query = "select * from Manufacturers";

$result = $conn->query($query);
if(!$result) die("unable to process query: " . mysqli_error());



$manrows = mysqli_num_rows($result);
$manarray = array();
for($j = 0 ; $j < $manrows ; ++$j)
  {
    $row = mysqli_fetch_row($result);
    $manarray[$j] = $row[1];
  }
#array("natm","ncar","nnit","noxy","nsul","ncycl","nhdon","nhacc","nrotb","mw","TPSA","XLogP");
echo <<<_MAIN1

    <p style="color:blue;font-size:35px;">
This is the complete compounds statistics page
    </p>

<table border="1">


  <tr>
    <td>Manufacturer</td>
    <td>Min A</td>
    <td>Max A</td>
    <td>Avg A</td>
    <td>Min C</td>
    <td>Max C</td>
    <td>Avg C</td>
    <td>Min N</td>
    <td>Max N</td>
    <td>Avg N</td>
    <td>Min O</td>
    <td>Max O</td>
    <td>Avg O</td>
    <td>Min S</td>
    <td>Max S</td>
    <td>Avg S</td>
    <td>Min Cy</td>
    <td>Max Cy</td>
    <td>Avg Cy</td>

  </tr>





_MAIN1;

$property[]="natm";
$property[]="ncar";
$property[]="nnit";
$property[]="noxy";
$property[]="nsul";
$property[]="ncycl";




$operation[]="min";
$operation[]="max";
$operation[]="avg";

for($j = 0 ; $j < $manrows ; ++$j)
  { printf("<tr><td>%s</td>", $manarray[$j]);
    foreach($property as $value){
    foreach($operation as $value_2){
    $compsel = "Select $value_2($value) from Compounds where ManuID=".($j+1);
    $result = mysqli_query($compsel);
    $row = mysqli_fetch_row($result);
    printf("<td>%.2f</td>", $row[0]);
    }
    }
    printf("</tr>%n");
  }
echo "</table><br><br>";
###################

echo <<<_MAIN2

    </pre>
<table border="1">


  <tr>


    <td>Manufacturer</td>
    <td>Min Hdon</td>
    <td>Max Hdon</td>
    <td>Avg Hdon</td>
    <td>Min Hacc</td>
    <td>Max Hacc</td>
    <td>Avg Hacc</td>
    <td>Min Rotb</td>
    <td>Max Rotb</td>
    <td>Avg Rotb</td>
    <td>Min Mw</td>
    <td>Max Mw</td>
    <td>Avg Mw</td>
    <td>Min TPSA</td>
    <td>Max TPSA</td>
    <td>Avg TPSA</td>
    <td>Min XLogP</td>
    <td>Max XLogP</td>
    <td>Avg XLogP</td>
 </tr>

_MAIN2;

$property1[]="nhdon";
$property1[]="nhacc";
$property1[]="nrotb";
$property1[]="mw";
$property1[]="TPSA";
$property1[]="XLogP";



$operation1[]="min";
$operation1[]="max";
$operation1[]="avg";

for($j = 0 ; $j < $manrows ; ++$j)
  { printf("<tr><td>%s</td>", $manarray[$j]);
    foreach($property1 as $value){
    foreach($operation1 as $value_2){
    $compsel = "Select $value_2($value) from Compounds where ManuID=".($j+1);
    $result = mysqli_query($compsel);
    $row = mysqli_fetch_row($result);
    printf("<td>%.2f</td>", $row[0]);
    }
    }
    printf("</tr>%n");
  }








echo <<<_TAIL1
</table>


<div class=box_pink>
<pre style="font-family: Calibri">
Legend:
A = n atoms
C= n carbons
N= n nitrogens
O= n oxygens
S= n sulphurs
Cy= n cycles
Hdon= n H donors
Hacc= n H acceptors
RotB= n rot bonds
Wt= mol wt
TPSA= Polar surface area
XLOG= estimate of the logP of the compound
</pre>







</body>
</html>
_TAIL1;
?>
