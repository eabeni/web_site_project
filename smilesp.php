
<?php
session_start();
include 'redir.php';
require_once 'login.php';
echo<<<_HEAD1
<html>
<body>
_HEAD1;
include 'menuf.php';
$mysmiles ="[H]C(=NN1C(=O)C2=C(N=C1C([H])([H])[H])SC(=C2C([H])([H])[H])C([H])([H])[H])C=3C([H])=C([H])C(OC([H])([H])[H])=C(OC([H])([H])[H])C=3([H])";

$convurl = "https://cactus.nci.nih.gov/chemical/structure/".urlencode($mysmiles)."/image";

$convstr = base64_encode(file_get_contents($convurl));



echo "<img  src='data:image/gif;base64,$convstr'>";


echo<<<_BODY1






</body>
</html>
_BODY1;
?>
