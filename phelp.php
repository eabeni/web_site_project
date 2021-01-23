<?php
session_start();
require_once 'login.php';
include 'redir.php';
echo<<<_HEAD1
<html>

<head>




</head>






<style>



.myclass_help {
background-color:yellow;


}



.myclass_help p{
color:black;
background:yellow;
font-size:20px;
text-decoration: none;
}

.myclass_help pre{
color:black;
background:yellow;
font-size:20px;
font-family:calibri;
text-decoration: none;
}



</style>



<body>

_HEAD1;
include 'menuf.php';


$output = shell_exec('ls ');
echo "<pre>$output</pre>";






echo<<<_TAIL3


<h1>Tutorial</h1>

<pre style="font-family:calibri;background-color:yellow">The main purpose of this database is to allow the user to find easily the compounds with  the specific properties desired.
The database provides several search tools that can help the user choose the desired product.</pre>

<br><br><br>
<p class=myclass_help>The research bar allows you to enter the unique ID number of the compound and to be able to view the summary card or just the figures of the chemical structure.</p>
<img src="image/20.png" height="150" width="500">
<br><br><br>

<p class=myclass_help> The full record form allows you to see the summary of chemical characteristics, <a href='https://www.daylight.com/dayhtml_tutorials/languages/smiles/index.html'>the smiles structure</a>, <a href="https://chemapps.stolaf.edu/jmol/jsmol/jsmol.htm">the 3d structure</a> and the molecular coordinates for a given compound.</p>
<img src="image/21.png" height="500" width="500">
<br><br><br>


<p class=myclass_help>In the drop-down menu we find 3 statistical tools </p>
<img src="image/23.png" height="400" width="500",class="center">
<br><br><br>


<p class=myclass_help>A summary statistical table divided by the 5 companies. The button allows to expand the table to obtain the complete table with all the features. </p>
<a href="https://edoardoabeni.com/p9.php">
<img src="image/24.png" height="400" width="500",class="center"></a>
<br><br><br>



<img src="image/25.png" height="400" width="500",class="center">
<br><br><br>


<p class=myclass_help> The specific property statistic page allows to select a specific chemical property and then view the statistics. It is also possible to select the option to display a nice histogram</p>
<a href="https://edoardoabeni.com/p3.php">
<img src="image/26.png" height="400" width="500"></a>
<br><br><br>


<p class=myclass_help> </p>
<img src="image/27.png" height="400" width="500">
<br><br><br>

<p class=myclass_help>The correlation page allows to obtain the pearson correlation index between two chemical properties chosen by the user. is; It is also possible to choose to show a nice correlation graph </p>
<a href="https://edoardoabeni.com/p4.php">
<img src="image/40.png" height="400" width="500"></a>
<br><br><br>


<p class=myclass_help> </p>
<img src="image/41.png" height="400" width="500">
<br><br><br>

<pre style="font-family:calibri;background-color:yellow">Search compound page allows you to select compounds from different companies and to choose certain ranges of chemical characteristics to refine your search.
On the page there is a statistical table to guide the user. It is also possible to choose whether to display the SMILES structure on the results page.
Each result has a link linked to the full report form </pre>
<a href="https://edoardoabeni.com/p2.php">
<img src="image/28.png" height="400" width="500"></a>
<br><br><br>


<p class=myclass_help> </p>
<img src="image/29.png" height="400" width="500">
<br><br><br>

<pre style="font-family:calibri;background-color:yellow">The properties page allows you to search using other physical / chemical characteristics by setting a search center value and a range of intervals set by the user.
You can choose to display the SMILES structure in the results. The results have a link directly linked to the full report form. </pre>
<a href="https://edoardoabeni.com/p8a.php">
<img src="image/30.png" height="400" width="500"></a>
<br><br><br>

<p class=myclass_help> </p>
<img src="image/31.png" height="400" width="500">
<br><br><br>

<pre class=myclass_help>The compound tables page allows you to select the company concerned and the number of results to be obtained. The result shows a more or less long list of all the
compounds belonging to the chosen company. It is possible to click on the name of the compounds to be sent back to the full record form </pre>
<a href="https://edoardoabeni.com/p13a_sort.php">
<img src="image/32.png" height="400" width="500"></a>
<br><br><br>

<p class=myclass_help> </p>
<img src="image/33.png" height="400" width="500">
<br><br><br>


<h1>Acknowledgments.</h1>

<pre style="font-family:calibri;background-color:yellow">For the construction of this site we first of all thank Professor Paul Taylor who provided me with the skeleton of the site and also
helped me in the production of the python graphics.
Much of the additional code was taken from the <a href="www.w3schools.com"> www.w3schools.com </a> website. The code to create the
url-variables with the _GET method was found thanks to this <a href="https://stackoverflow.com/questions/5884807/get-url-parameter-in-php">forum discussion</a>.</pre>





<br>
<span style="color:blue;font-size:30px">Our partner suppliers:</span><br>

<a href="http://www.asinex.com/">
<img src="image/1-Asinex.png" alt="Asinex" height="100" width="200">
</a>
<a href="https://www.keyorganics.net/">
<img src="image/2-keyorganics.jpg" alt="KeyOrganics" height="100" width="200">
</a>
<a href="https://www.maybridge.com/portal/alias__Rainbow/lang__en/tabID__177/DesktopDefault.aspx">
<img src="image/3-maybridge.gif" alt="Maybridge" height="100" width="200">
</a>
<a href="https://www.nanosyn.com/">
<img src="image/4-nanosyn.png" alt="Nanosyn" height="100" width="350">
</a>
<a href="https://www.evotec.com/en">
<img src="image/5-Oai40000.png" alt="Oai40000" height="100" width="200">
</a>
</body>
</html>
_TAIL3;
?>
