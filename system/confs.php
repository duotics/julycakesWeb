<?php
$wTit='ECUA homes';
date_default_timezone_set('America/New_York');
setlocale(LC_ALL,"es_ES");
$sdate=date('Y-m-d');
$sdatet=date('Y-m-d H:m:s');
$_SESSION['urlp']=$_SESSION['urlc'];
$_SESSION['urlc']=basename($_SERVER['SCRIPT_FILENAME']);//URL clean Current;
$urlp=$_SESSION['urlp'];
$urlc=$_SESSION['urlc'];
?>