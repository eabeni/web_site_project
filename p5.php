<?php
session_start();
include 'redir.php';
require_once 'domain_name.php';
echo<<<_HEAD1
<html>

<style>
body {
font-family: Calibri;
background-color: silver;
 }
</style>
<body>
_HEAD1;
$fn = $_SESSION['forname'];
echo <<<_MAIN1
    <br><br><br><p style="color:blue;font-size:70px">
    Goodbye  $fn;
    You have now exited Complib
    </p><br><br><br><br>
_MAIN1;

echo    '<a href="'.$domain.'Bioinformatics/complib.php" style="color:red;font-size:70px">Log In again</a>';



echo <<<_MAIN2
<br><br><br><p style="color:blue;font-size:70px">
    Visit our suppliers websites
    </p>
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

_MAIN2;
$_SESSION = array();
if( session_id() != "" || isset($_COOKIE[session_name()]))
  setcookie(session_name(), '', time() - 2592000, '/');
  session_destroy();
echo <<<_TAIL1
</pre>
</body>
</html>
_TAIL1;

?>
