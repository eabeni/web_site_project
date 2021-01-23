<?php
session_start();
include 'redir.php';
require_once 'login.php';
echo <<<_endpage
<!DOCTYPE html>
<html>
<head>
<title>Paul s JSmol demo </title>
<meta charset="utf-8">
<script type="text/javascript" src="http://mscidwd.bch.ed.ac.uk/s2002448/webpage/jsmol/JSmol.min.js"></script>






</head>
<body>
_endpage;

$db_server = mysql_connect($db_hostname,$db_username,$db_password);
if(!$db_server) die("Unable to connect to database: " . mysql_error());
mysql_select_db($db_database,$db_server) or die ("Unable to select database: " .
mysql_error());



$query = "select molecule from Molecules JOIN Compounds ON Molecules.cid=Compounds.id where catn='SPH1-000-003'";
$result = mysql_query($query);
if(!result) die("unable to process query: " . mysql_error());
$row = mysql_fetch_row($result);








echo <<<_endpage2
<script type="text/javascript">
$(document).ready(function() {
Info = {
        width: 400,
        height: 400,
        debug: false,
        j2sPath: "http://mscidwd.bch.ed.ac.uk/s2002448/webpage/jsmol/j2s",
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


This illustrates that the applet
<span id=mydiv></span>
is inline
<p>
<a href="javascript:Jmol.script(jmolApplet0, 'spin on')">spin on</a>

<a href="javascript:Jmol.script(jmolApplet0, 'spin off')">spin off</a>
</p>
</body>
</html>
_endpage2;
?>




