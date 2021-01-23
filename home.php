<?php
session_start();
require_once 'login.php';
include 'redir.php';
echo<<<_HEAD1
<html>

<head>

<link rel="stylesheet" type="text/css" href="style.css">


</head>


<meta charset="utf-8">
_HEAD1;


echo '<script type="text/javascript" src="'.$domain.'Bioinformatics/jsmol/JSmol.min.js"></script>';

echo<<<_HEAD2



<style>



.myclass_home {
background-color:#e6ffee;
padding:30px;
border: 5px
outset black;
top:200;
overflow: hidden;
position: sticky;
}


.myclass_home a{
color:red;
font-weight:bold;
text-decoration: none;
}

.myclass_home p{
color:black;
font-size:20px;
text-decoration: none;
}

.myclass_home span{
color:blue;
font-weight:bold;
text-decoration: none;
}


</style>



<body>

_HEAD2;
include 'menuf.php';



$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$query = "select count(*) from Compounds";
$result = $conn->query($query);
if(!$result) die("unable to process query: " . mysqli_error());

$row = mysqli_fetch_row($result);
printf("<p style='color:black;font-size:20px;font-weight:bold'>Welcome to Compound Drugs Exploration Database (CDED).<br> This database currently contains information on the composition and chemical structure of<span style='color:red'> %.d </span> compounds provided by our partner companies.  </p>",$row[0]);




echo<<<_TAIL2



<div class="myclass_home">

<p>&#8226; To have a general idea of the properties of our compounds go in<span> Compounds Statistics </span> section: <p>

<ul>
_TAIL2;
echo '<li><a href="'.$domain.'Bioinformatics/p9.php">General Compound Statistics</a>: Main properties of the compounds among the different suppliers. </li>';
echo '<li><a href="'.$domain.'Bioinformatics/p3.php">Spefic Property Statistics </a>: Compounds statistics specific for a given properties. </li>';
echo '<li><a href="'.$domain.'Bioinformatics/p4.php">Correlations Properties Statistics </a>: Correlation analysis between two desired properties.</li>';
echo '</ul>';

echo '<p>&#8226; The <a href="'.$domain.'Bioinformatics/p2.php"> Search Compounds </a> section allows to select the compound based on the supplier and the main chemistry features.</p>';

echo '<p>&#8226;The <a href="'.$domain.'Bioinformatics/p8a.php"> Property search </a> section allows you to search by Molecular Weight, TPSA and XlogP.';

echo '<p>&#8226;The<a href="'.$domain.'Bioinformatics/p13a_sort.php"> Compounds table </a> allows to quickly access to the complete records of a large number of compounds divided by company.<p>';

echo '<p>&#8226; In the search bar in the menu it is possible to enter the ID number of the compound and view the Smiles  and 3d structure of the compounds.<p>';

echo '<p>&#8226; For more information on how to use this site visit the <a href="'.$domain.'Bioinformatics/phelp.php"> About</a> section.<p>';









$query = "select molecule from Molecules where id='1'";


$result = $conn->query($query);
if(!$result) die("unable to process query: " . mysqli_error());

$row = mysqli_fetch_row($result);



echo <<<_endpage2
<script type="text/javascript">
$(document).ready(function() {
Info = {
        width: 150,
        height: 150,
        debug: false,
_endpage2;

echo 'j2sPath: "'.$domain.'Bioinformatics/jsmol/j2s",';



echo <<<_endpage3
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

<span id=mydiv></span>


<img src="image/7.png" alt="Correlation" height="110" width="110">
<img src="image/6.png" alt="Histogram" height="110" width="110">
<img src="image/11.png" alt="Histogram" height="110" width="110">
<img src="image/13.png" alt="Histogram" height="110" width="110">
<img src="image/12.png" alt="Histogram" height="110" width="110">
<img src="image/14.png" alt="Histogram" height="110" width="110">



_endpage3;



mysqli_close($conn);







echo<<<_TAIL3
















<a href="http://www.asinex.com/">
<img src="image/1-Asinex.png" alt="Asinex" height="100" width="100">
</a>
<a href="https://www.keyorganics.net/">
<img src="image/2-keyorganics.jpg" alt="KeyOrganics" height="100" width="100">
</a>
<a href="https://www.maybridge.com/portal/alias__Rainbow/lang__en/tabID__177/DesktopDefault.aspx">
<img src="image/3-maybridge.gif" alt="Maybridge" height="100" width="100">
</a>
<a href="https://www.nanosyn.com/">
<img src="image/4-nanosyn.png" alt="Nanosyn" height="100" width="100">
</a>
<a href="https://www.evotec.com/en">
<img src="image/5-Oai40000.png" alt="Oai40000" height="100" width="100">
</a>
</body>
</html>
_TAIL3;
?>
