
<?php
session_start();
require_once 'login.php';
echo<<<_HEAD1
<html>

<head>

<link rel="stylesheet" type="text/css" href="style.css">


</head>

<body>
_HEAD1;
#OLD PART CODE MADE WITH PHP5
#--The mysql_connect() function opens a non-persistent MySQL connection.This function returns the connection on success, or  FALSE and an error on failure. ;
#$db_server = mysqli_connect($db_hostname,$db_username,$db_password);
#--die(): Print a message and terminate the current script. The die() function is an alias of the exit() function.;
#if(!$db_server) die("Unable to connect to database: " . mysqli_error());
#--mysql_select_db. The mysql_select_db() function sets the active MySQL database. This function returns TRUE on success, or FALSE on failure. mysql_select_db(database,connection)-->;
#mysqli_select_db($db_server,$db_database) or die ("Unable to select database: " . mysqli_error());



$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



$query = "select * from Manufacturers";
#--mysql_query() function executes a query on a MySQL database-->;
$result = $conn->query($query);
     if(!$result) die("unable to process query: " . mysqli_error());
     #--mysql_num_rows. Retrieves the number of rows from a result set. This command is only valid for statements like SELECT or SHOW ;
     #that return an actual result set. To retrieve the number of rows affected by a INSERT, UPDATE, REPLACE or DELETE query, use mysql_affected_rows().#--> ;
     $rows = mysqli_num_rows($result);
     $mask = 0;
     mysqli_close($db_server);
     #++$j means increment of 1. Alternatively $j+=1;
     for($j = 0 ; $j < $rows ; ++$j)
     {
       $mask = (2 * $mask) + 1;
     };
     #$row=10;
     #$mask=0;
     #for ($j = 0; $j < $row; $j+=1) {;
     #$mask = (2 * $mask) + 1 ;
     #echo "mask is: $mask <br>";
     #};

    # mask is: 1;
    # mask is: 3;
    # mask is: 7;
    # mask is: 15;
    # mask is: 31;
    # mask is: 63;
    # mask is: 127;
    # mask is: 255;
    # mask is: 511;
    # mask is: 1023;

$_SESSION['supmask'] = $mask;



#function validate; variable fail become not empty if the user doesn t insert nothnig;
#if full=TRUe, if FALSE display the error.
   echo <<<_EOP
<script>
   function validate(form) {
   fail = ""
   if(form.fn.value =="") fail = "Must Give Forname "
   if(form.sn.value == "") fail += "Must Give Surname"
   if(fail =="") return true
       else {alert(fail); return false}
   }
</script>

<div class=box>
<p style="font-size:50px;font-family: Calibri;">Welcome to Compound Drugs Exploration Database (CDED)</p>
<form action="indexp.php" method="post" onSubmit="return validate(this)">
  <pre>
       <span style="font-size:30px;font-family: Calibri;">First Name<input type="text" name="fn"></span>
       <span style="font-size:30px;font-family: Calibri;">Second Name <input type="text" name="sn"></span>
                   <input type="submit" value="submit" />
</pre></form></div>
_EOP;

# form is use to insert data that then is sent to another page (index.php). The data are collected with the post get_class_methods;
#onsubmit: if true procedee, if false display allert until user inser values;
#input type forms the text box ;
#input submit generates the button to submit;


echo <<<_TAIL1
</pre>
</body>
</html>
_TAIL1;

?>
