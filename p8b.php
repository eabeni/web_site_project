<?php
session_start();
require_once 'login.php';
include 'redir.php';
echo<<<_HEAD1
<html>

<head>

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
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$query = "select * from Manufacturers";
$result = $conn->query($query);
if(!$result) die("unable to process query: " . mysqli_error());

$rows = mysqli_num_rows($result);
$manarray = array();
for($j = 0 ; $j < $rows ; ++$j)
  {
    $row = mysqli_fetch_row($result);
    $manarray[$j] = $row[1];
  }

echo <<<_MAIN1
    <p style=color:blue;font-size:35px>
This is the property retrieval Page
    </p>
_MAIN1;
if (($_POST['tgval'] != "") && ($_POST['cval']!="")) {
    $mychoice=$_POST['tgval'];
    $myvalue=$_POST['cval'];
    $interval=$_POST['int'];
    $compsel = "select * from Compounds where ";
    if($mychoice == "mw") {
      $compsel = $compsel."( mw > ".($myvalue - $interval)." and  mw < ".($myvalue + $interval).")";
    }
    if($mychoice == "TPSA") {
      $compsel = $compsel."( TPSA > ".($myvalue - $interval)." and  TPSA < ".($myvalue + $interval).")";
    }
    if($mychoice == "XlogP") {
      $compsel = $compsel."( XlogP > ".($myvalue - $interval)." and  XlogP < ".($myvalue + $interval).")";
    }
    echo "<pre>";
    //    echo $compsel;
    echo "\n";
    $result = $conn->query($compsel);
    if(!$result) die("unable to process query: " . mysqli_error());

    $rows = mysqli_num_rows($result);


if(isset($_POST['tgval2'])){if($rows > 200) {
      echo "Too many results for smile visualization! ",$rows," Max is 200\n";
    } else  {

      for($j = 0 ; $j < $rows ; ++$j)
	{
  echo " <table border='1'>";
  echo "<tr>";
    echo "<td>ID Number</td>";
    echo "<td>CAT Number</td>";
    echo "<td>Manufacturer</td>";
    echo "<td>Property: $mychoice</td>";
  echo "</tr>";




	  echo "<tr>";
	  $row = mysqli_fetch_row($result);

   echo "<td>".$row[0]."</td><td><a href='".$domain."Bioinformatics/p7_get_methods.php?ID=".$row[0]."'>".$row[11]."</a></td><td>".$manarray[$row[10] - 1]."</td>";
	  if($mychoice == "mw") {
	     printf("<td>%s</td> ", $row[12]);
	  }
	  if($mychoice == "TPSA") {
	     printf("<td>%s</td> ", $row[13]);
	  }
	  if($mychoice == "XlogP") {
	     printf("<td>%s</td> ", $row[14]);

	  }
          echo "</tr>";

   $compsel_2= "select smiles from Smiles where cid= $row[0]";


   $result_2= $conn->query($compsel_2);
   if(!result_2) die("unable to process query: " . mysqli_error());


   $row_2 = mysqli_fetch_row($result_2);
	 echo "<tr>";
   echo "<td> $row_2[0]</td>";
   echo "</tr>";
   $convurl = "https://cactus.nci.nih.gov/chemical/structure/".urlencode($row_2[0])."/image";
   $convstr = base64_encode(file_get_contents($convurl));
   echo "<br><img  src='data:image/gif;base64,$convstr'><br><br><br>";



	}
      echo "</table>";
    }












}



#no smile option selected

else{

if($rows > 10000) {
      echo "Too many results ",$rows," Max is 10000\n";
    } else  {
      echo<<<TABLESET_
<table border="1">
  <tr>
    <td>CAT Number</td>
    <td>Manufacturer</td>
    <td>Property: $mychoice</td>
  </tr>
TABLESET_;
      for($j = 0 ; $j < $rows ; ++$j)
	{
	  echo "<tr>";
	  $row = mysqli_fetch_row($result);
    echo "<td>".$row[0]."</td><td><a href='".$domain."Bioinformatics/p7_get_methods.php?ID=".$row[0]."'>".$row[11]."</a></td><td>".$manarray[$row[10] - 1]."</td>";
	  if($mychoice == "mw") {
	     printf("<td>%s</td> ", $row[12]);
	  }
	  if($mychoice == "TPSA") {
	     printf("<td>%s</td> ", $row[13]);
	  }
	  if($mychoice == "XlogP") {
	     printf("<td>%s</td> ", $row[14]);
	  }
          echo "</tr>";
	}
      echo "</table>";
    }

 }











  } else {
    echo "No Query Given\n";
  }
echo "</pre>";










echo <<<_TAIL1
</body>
</html>
_TAIL1;
function get_post($var)
{
  return mysqli_real_escape_string($_POST[$var]);
}
?>
