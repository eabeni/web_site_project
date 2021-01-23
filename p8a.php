<?php
session_start();
include 'redir.php';
require_once 'login.php';
echo<<<_HEAD1
<html>
<head>

<link rel="stylesheet" type="text/css" href="style.css">




  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



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


  /* Tooltip */
  .test + .tooltip > .tooltip-inner {
    background-color: #73AD21;
    color: #FFFFFF;
    border: 1px solid green;
    padding: 15px;
    font-size: 20px;
  }

  /* Tooltip on right */
  .test + .tooltip.right > .tooltip-arrow {
    border-right: 5px solid black;
  }




</style>
</head>








<body>
_HEAD1;
include 'menuf.php';


echo <<<_MAIN1
    <p style=color:blue;font-size:35px>
This is the Property search page
    </p>









<div class=box style=color:black;font-size:25px>
    </pre><form action="p8b.php" method="post"><pre>   MW <input type="radio" name="tgval" value="mw" checked>
 TPSA <input type="radio" name="tgval" value="TPSA"/>
XlogP <input type="radio" name="tgval" value="XlogP"/>

Value <input type="text" name="cval"/><span class="test" data-toggle="tooltip" data-placement="right" title="Set a central value"><SUP> ? </SUP></span>

Interval <input type="text" name="int"/><span class="test" data-toggle="tooltip" data-placement="right" title="Set the range of the interval (example: if value is 10 and interval is 5, it retrieves all the results from 5 to 15)"><SUP> ? </SUP></span>
<input type="submit" value="OK" />

Show Smiles structure <input type="radio" name="tgval2" value="yes"/>
</pre>
</form></div>
_MAIN1;




echo <<<_MAIN1
<div class=box style=color:black;font-size:25px>
<table>
  <tr>
    <td>Property</td>
    <td>AVG</td>
    <td>STD</td>
    <td>MIN</td>
    <td>MAX</td>



  </tr>
_MAIN1;





$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



$property[]="mw";
$property[]="TPSA";
$property[]="XLogP";



$name_property[]="mw: mol wt";
$name_property[]="TPSA: Polar surface area";
$name_property[]="XLOG: estimate of the logP of the compound";





for($j = 0 ; $j < count($property) ; $j++){



     printf("<tr><td>%s</td>", $name_property[$j]);
     $query = sprintf("select AVG(%s) from Compounds",$property[$j]);
     $result = $conn->query($query);
     if(!$result) die("unable to process query: " . mysqli_error());

     $row = mysqli_fetch_row($result);
     printf("<td>%.2f</td>",$row[0]);
     $query = sprintf("select  STD(%s) from Compounds",$property[$j]);
     $result = $conn->query($query);
     if(!$result) die("unable to process query: " . mysqli_error());

     $row = mysqli_fetch_row($result);
     printf("<td>%.2f</td>",$row[0]);
     $query = sprintf("select  MIN(%s) from Compounds",$property[$j]);
     $result = $conn->query($query);
     if(!$result) die("unable to process query: " . mysqli_error());

     $row = mysqli_fetch_row($result);
     printf("<td>%.2f</td>",$row[0]);
     $query = sprintf("select MAX(%s) from Compounds",$property[$j]);
     $result = $conn->query($query);
     if(!$result) die("unable to process query: " . mysqli_error());

     $row = mysqli_fetch_row($result);
     printf("<td>%.2f</td>",$row[0]);
     printf("</tr>%n");

}












echo <<<_MAIN2
 </table>
 </div>
</body>
</html>
_MAIN2;
�
?>
