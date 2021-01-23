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
  font-size:30px;
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
echo <<<_MAIN1
    <p style="color:blue;font-size:35px;">
This is the general compounds statistics page
    </p>
<table>
  <tr>
    <td>Manufacturer</td>
    <td>Min C</td>
    <td>Max C</td>
    <td>Avg C</td>
    <td>Min N</td>
    <td>Max N</td>
    <td>Avg N</td>
    <td>Min O</td>
    <td>Max O</td>
    <td>Avg O</td>
  </tr>
_MAIN1;

for($j = 0 ; $j < $manrows ; ++$j)
  {
    printf("<tr><td>%s</td>", $manarray[$j]);
    $compsel = "Select min(ncar) from Compounds where ManuID=".($j+1);
    $result = $conn->query($compsel);
    $row = mysqli_fetch_row($result);
    printf("<td>%s</td>", $row[0]);
    $compsel = "Select max(ncar) from Compounds where ManuID=".($j+1);
    $result = $conn->query($compsel);
    $row = mysqli_fetch_row($result);
    printf("<td>%s</td>", $row[0]);
    $compsel = "Select avg(ncar) from Compounds where ManuID=".($j+1);
    $result = $conn->query($compsel);
    $row = mysqli_fetch_row($result);
    printf("<td>%s</td>", $row[0]);
    $compsel = "Select min(nnit) from Compounds where ManuID=".($j+1);
    $result = $conn->query($compsel);
    $row = mysqli_fetch_row($result);
    printf("<td>%s</td>", $row[0]);
    $compsel = "Select max(nnit) from Compounds where ManuID=".($j+1);
    $result = $conn->query($compsel);
    $row = mysqli_fetch_row($result);
    printf("<td>%s</td>", $row[0]);
    $compsel = "Select avg(nnit) from Compounds where ManuID=".($j+1);
    $result = $conn->query($compsel);
    $row = mysqli_fetch_row($result);
    printf("<td>%s</td>", $row[0]);
    $compsel = "Select min(noxy) from Compounds where ManuID=".($j+1);
    $result = $conn->query($compsel);
    $row = mysqli_fetch_row($result);
    printf("<td>%s</td>", $row[0]);
    $compsel = "Select max(noxy) from Compounds where ManuID=".($j+1);
    $result = $conn->query($compsel);
    $row = mysqli_fetch_row($result);
    printf("<td>%s</td>", $row[0]);
    $compsel = "Select avg(noxy) from Compounds where ManuID=".($j+1);
    $result = $conn->query($compsel);
    $row = mysqli_fetch_row($result);
    printf("<td>%s</td>", $row[0]);
    printf("</tr>%n");
  }

echo <<<_TAIL1




</pre><form action="p9b.php"><pre>
<input type="submit" value="Show complete table" /></pre></form></body>







</table>
</body>
</html>
_TAIL1;
?>
