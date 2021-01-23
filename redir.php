<?php

require_once 'domain_name.php';


#isset: checks if the variables NOT exist. If true redirect using header('Location:...) to complib page to set forname and surname;
if(!(isset($_SESSION['forname']) &&
     isset($_SESSION['surname'])))
  {
  header('location: '.$domain.'Bioinformatics/complib.php');
  }
?>
