<?php if (!isset($_SESSION)) session_start();
ini_set('allow_url_fopen',1);
ini_set('allow_url_include',1);
define( '_JEXEC', 1 );// esto define una constante
include("system/paths.php");
include(RAIZs."confs.php");
include(RAIZs."lang.php");
include(RAIZs."fncts.php");
include(RAIZs."conn/conn.php"); ?>