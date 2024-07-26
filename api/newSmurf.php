<?php
include_once(dirname(__FILE__) . "/secrets.php");


$name = $_POST['name'];
$msg = "Name: " . $name;

for ($i=0; $i < count(EMAILS); $i++) { 
    mail(EMAILS[$i], "gargameleaks smurf request", $msg);
}

header("location: ../index.html");

?>