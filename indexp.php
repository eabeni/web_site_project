<?php
session_start();
require_once 'domain_name.php';

if(isset($_POST['fn']) && isset($_POST['sn']))
{

    $_SESSION['forname'] = $_POST['fn'];
    $_SESSION['surname'] = $_POST['sn'];
    $smask =  $_SESSION['supmask'];


header('location: '.$domain.'Bioinformatics/home.php');

}

else {

header('location: '.$domain.'Bioinformatics/complib.php');

}

?>
