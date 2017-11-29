<?php

if(!isset($_SESSION)) 
{ 
    session_start(); // Starting Session
} 

$_SESSION['site'] = null;
$_SESSION['protocol'] = null;
$_SESSION['protocolname'] = null;
?>