
<?php
#--heredoc synatax echo <<<token;
#--some text;
#--token;
#-- table: make a table;
#-- tr table row;
#th table header;

require_once 'domain_name.php';
#require_once '../side_nav_bar.php';

echo <<<_MENU1


<style>

html {
display: table;
   margin: auto;
font-family: Calibri;

}


body {
font-family: Calibri;
background-color: silver;
 }

.myclass {
top:0;
background-color:orange;
overflow: hidden;


}


.myclass a{

float: left;
display: block;
color: white;
text-align: center;
padding: 14px 16px;
font-size:25px;
font-weight:bold;
text-decoration: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 25px;
  border: none;
  outline: orange;
  color: white;
  font-weight:bold;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.myclass a:hover, .dropdown:hover .dropbtn {
  background-color: red;
}



.dropdown-content {
  display: none;
  position: absolute;
  background-color: orange;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: white;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}






.image_top {

top:0;
background-image:url('drug.jpg');
overflow: hidden;
position: sticky;
padding: 5px;
font-weight:bold;
font-size:35px;
}

</style>
<body>



<div class="myclass">
  <div class="image_top">
    <span style="font-size:65px">CDED: Compound Drugs Exploration Database</span>
  </div>
_MENU1;

echo    '<a href="'.$domain.'Bioinformatics/home.php", style="color:blue;background-color:yellow;"> Home </a>';
echo    '<div class="dropdown">';
echo    '<button class="dropbtn"> &#9660; Compounds Statistics';
echo    '</button>';
echo    '<div class="dropdown-content">';
echo      '<a href="'.$domain.'Bioinformatics/p9.php"> &#8226; General Compound Statistics</a>';
echo      '<a href="'.$domain.'Bioinformatics/p3.php"> &#8226; Spefic Property Statistics </a>';
echo      '<a href="'.$domain.'Bioinformatics/p4.php"> &#8226; Correlations Properties Statistics </a>';
echo    '</div></div>';
echo    '<a href="'.$domain.'Bioinformatics/p2.php"> &#8226; Search Compounds </a>';
echo    '<a href="'.$domain.'Bioinformatics/p8a.php"> &#8226; Property search </a>';
echo    '<a href="'.$domain.'Bioinformatics/p13a_sort.php"> &#8226; Compounds table </a>';
echo    '<a href="'.$domain.'Bioinformatics/phelp.php"> &#8226; Help </a>';
echo    '<a href="'.$domain.'Bioinformatics/p5.php", style="color:blue;background-color:yellow;"> Log Out </a>';

echo <<<_MENU1
<br><br><br>
<form action="p7.php" method="post">

<input type="text" name="ID" placeholder="Insert ID number"/> <input type="submit" value="OK" />

<span style='font-size:20;color:white;font-weight:bold'>Display:</span>
<input type="radio" id="full" name="Visualization" value="full" checked>
<label style='font-size:20;color:white;font-weight:bold' for="full">Full Record</label>
<input type="radio" id="2D" name="Visualization" value="2D">
<label style='font-size:20;color:white;font-weight:bold' for="2D">2D SMILES</label>
<input type="radio" id="3D" name="Visualization" value="3D">
<label style='font-size:20;color:white;font-weight:bold' for="3D">3D structure</label>
<input type="radio" id="coor" name="Visualization" value="coor">
<label style='font-size:20;color:white;font-weight:bold' for="coor">Text Molecular Coordinates</label>

</form>
</div>









</body>
_MENU1;







?>
