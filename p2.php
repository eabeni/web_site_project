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

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$query = "select * from Manufacturers";

$result = $conn->query($query);
if(!$result) die("unable to process query: " . mysqli_error());


$rows = mysqli_num_rows($result);
#until here the code is the same to complib.php;
$smask = $_SESSION['supmask'];
for($j = 0 ; $j < $rows ; ++$j)
  {
    $row = mysqli_fetch_row($result);#
    $sid[$j] = $row[0];
    #echo "sid is now $row <br>";
    $snm[$j] = $row[1];
    #echo "snm is now $row[1]<br>";
    $sact[$j] = 0;
    #echo "sact is now $sact[$j]<br>";
    $tvl = 1 << ($sid[$j] - 1);
    #echo "tv1 is now $tv1 <br>";
    if($tvl == ($tvl & $smask)) {
	$sact[$j] = 1;
  #echo "sact is now $sact[$j]<br>";
      }
  }
#isset checks if the variable is empty
if(isset($_POST['supplier']))
   {
     $supplier = $_POST['supplier'];
     $nele = sizeof($supplier);
      for($k = 0; $k <$rows; ++$k) {
       $sact[$k] = 0;
       for($j = 0 ; $j < $nele ; ++$j) {
	 if(strcmp($supplier[$j],$snm[$k]) == 0) $sact[$k] = 1;
       }
     }
     $smask = 0;
     for($j = 0 ; $j < $rows ; ++$j)
       {
	 if($sact[$j] == 1) {
	   $smask = $smask + (1 << ($sid[$j] - 1));
	 }
       }
     $_SESSION['supmask'] = $smask;
   }
   #this part is for the first line of text;
   echo '<p style=color:blue;font-size:35px>Catalogue retrieval Page. Please fill the boxes to retrieve the CAT number of compounds</p>';
   echo '<div class=box>';
   echo "<span style='color:black;font-size:20px'>Currently selected Suppliers: </span>";
   for($j = 0 ; $j < $rows ; ++$j)
      {
    	if($sact[$j] == 1) {
    echo "<span style='color:black;font-size:20px;'>&#8226; $snm[$j]   </span>";
    $supplier_bis[]=$snm[$j]; #to retrieve the supplier to use in the query for page2
	}
      }
    echo '<br><br><span style=color:black;font-size:20px>Select Suppliers: </span>';
    echo  '<pre style=color:black;font-size:20px> <form action="p2.php" method="post">';
    for($j = 0 ; $j < $rows ; ++$j)
      {
    	echo $snm[$j];
	echo' <input type="checkbox" name="supplier[]" value="';
	echo $snm[$j];
        echo'"/>';
	echo" ";
      }
echo <<<_TAIL1
 <input type="submit" value="OK" />
</pre></form></div>

_TAIL1;





echo <<<_TAIL1
   <div class=box>
   <form action="p2b.php" method="post"><pre style=color:black;font-size:20px>
       Min Atoms    <input type="text" name="natmin"/>      Max Atoms      <input type="text" name="natmax"/>
       Min Carbons  <input type="text" name="ncrmin"/>      Max Carbons    <input type="text" name="ncrmax"/>
       Min Nitrogens<input type="text" name="nntmin"/>      Max Nitrogens  <input type="text" name="nntmax"/>
       Min Oxygens  <input type="text" name="noxmin"/>      Max Oxygens    <input type="text" name="noxmax"/>
       Show Smiles structure <input type="radio" name="tgval" value="yes"/>
                   <input type="submit" value="list" />
</pre></form></div>




_TAIL1;

echo "<div class=box style=color:black;font-size:25px>";
   echo '<span style=color:black;font-size:30px>REFERENCE RESEARCH VALUES</span>';
   echo '<br>Currently statistics for the following Suppliers: ';
   for($j = 0 ; $j < $rows ; ++$j)
      {
    	if($sact[$j] == 1) {
    echo "&#8226;" ;
	  echo $snm[$j] ;
    echo " " ;

	}
      }
echo '<br><br>';




echo <<<_MAIN1

<table>
  <tr>
    <td>Property</td>
    <td>AVG</td>
    <td>STD</td>
    <td>MIN</td>
    <td>MAX</td>



  </tr>
_MAIN1;


$property[]="natm";
$property[]="ncar";
$property[]="nnit";
$property[]="noxy";


$name_property[]="Number Atoms";
$name_property[]="Number Carbons";
$name_property[]="Number Nitrogens";
$name_property[]="Number Oxygens";




for($j = 0 ; $j < count($property) ; $j++){

     printf("<tr><td>%s</td>", $name_property[$j]);
     $query = sprintf('select AVG(%s) FROM Compounds JOIN Manufacturers ON Compounds.ManuID = Manufacturers.id where name="%s" OR name="%s" OR name="%s" OR name="%s" OR name="%s"',$property[$j],$supplier_bis[0],$supplier_bis[1],$supplier_bis[2],$supplier_bis[3],$supplier_bis[4]); #add new slots here if future suppliers will be add in the database
     $result = $conn->query($query);
     if(!$result) die("unable to process query: " . mysqli_error());
     $row = mysqli_fetch_row($result);
     printf("<td>%.2f</td>",$row[0]);
     $query = sprintf('select STD(%s) FROM Compounds JOIN Manufacturers ON Compounds.ManuID = Manufacturers.id where name="%s" OR name="%s" OR name="%s" OR name="%s" OR name="%s"',$property[$j],$supplier_bis[0],$supplier_bis[1],$supplier_bis[2],$supplier_bis[3],$supplier_bis[4]); #add new slots here if future suppliers will be add in the database
     $result = $conn->query($query);
     if(!$result) die("unable to process query: " . mysqli_error());
     $row = mysqli_fetch_row($result);
     printf("<td>%.2f</td>",$row[0]);
     $query = sprintf('select MIN(%s) FROM Compounds JOIN Manufacturers ON Compounds.ManuID = Manufacturers.id where name="%s" OR name="%s" OR name="%s" OR name="%s" OR name="%s"',$property[$j],$supplier_bis[0],$supplier_bis[1],$supplier_bis[2],$supplier_bis[3],$supplier_bis[4]); #add new slots here if future suppliers will be add in the database
     $result = $conn->query($query);
     if(!$result) die("unable to process query: " . mysqli_error());
     $row = mysqli_fetch_row($result);
     printf("<td>%.2f</td>",$row[0]);
     $query = sprintf('select MAX(%s) FROM Compounds JOIN Manufacturers ON Compounds.ManuID = Manufacturers.id where name="%s" OR name="%s" OR name="%s" OR name="%s" OR name="%s"',$property[$j],$supplier_bis[0],$supplier_bis[1],$supplier_bis[2],$supplier_bis[3],$supplier_bis[4]); #add new slots here if future suppliers will be add in the database
     $result = $conn->query($query);
     if(!$result) die("unable to process query: " . mysqli_error());
     $row = mysqli_fetch_row($result);
     printf("<td>%.2f</td>",$row[0]);
     printf("</tr>%n");

}






function get_post($var)
{
  return mysqli_real_escape_string($_POST[$var]);

echo <<<_TAIL1

 </table>

</div>
</body>
</html>

_TAIL1;


}
?>
