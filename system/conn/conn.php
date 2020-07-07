<?php
defined('_JEXEC') or die('Restricted access');//comprueba si la constante esta definida
/*$hostname_conn = "localhost";
$database_conn = "ecuahome_WEB";
$username_conn = "ecuahome_w0";
$password_conn = "##v~{@Ts%TIT2!7#cQ";*/
$hostname_conn = "p:localhost";
$database_conn = "julycake_web";
$username_conn = "julycake_web0";
$password_conn = "C{}%ZH30v7@KGPK?fH";
if(!$conn){
	$conn = mysqli_connect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
	mysqli_select_db($conn,$database_conn);
	mysqli_query($conn,"SET NAMES 'utf8'");
	//cLOG('Successfully connection');
}//else cLOG('Error, bad connection'.mysqli_error($conn));
?>