<?php

$domainName=''; //Folder to $RAIZ url
$folderBase=''; //Remoto. '/'; Local. '/Folder/' (Folder in www)
$folderCont='web/'; //Folder if system is in subdirectory
//$folderCont='CLINIC_BIOGEPA/'; //Folder if system is in subdirectory
$serverRoot=$_SERVER['DOCUMENT_ROOT'].'/';
//$hostType='localhost/'; //Remoto. 'www.'; Local. 'localhost/'
$hostType=$_SERVER[HTTP_HOST].'/'; //Remoto. 'www.'; Local. 'localhost/'
$protocolS='http://';

define('RAIZ0',$serverRoot.$folderBase);
define('RAIZ',$serverRoot.$folderBase.$folderCont);
define('RAIZd',$serverRoot.$folderBase.$folderCont.'data/');
define('RAIZi',$serverRoot.$folderBase.$folderCont.'images/');
define('RAIZidb',$serverRoot.$folderBase.$folderCont.'images/db/');
define('RAIZm',$serverRoot.$folderBase.$folderCont.'mods/');
define('RAIZmdb',$serverRoot.$folderBase.$folderCont.'media/db/');
define('RAIZf',$serverRoot.$folderBase.$folderCont.'frames/');
define('RAIZc',$serverRoot.$folderBase.$folderCont.'com/');
define('RAIZs',$serverRoot.$folderBase.$folderCont.'system/');
define('RAIZu',$serverRoot.$folderBase.$folderCont.'uploads/');
define('RAIZa',$serverRoot.$folderBase.$folderCont.'assets/');

global $RAIZ0,$RAIZ,$RAIZi,$RAIZj,$RAIZc,$RAIZc,$RAIZs,$RAIZidb;
$urlCont=$hostType.$domainName;
$RAIZ0=$protocolS.$urlCont;
$RAIZ=$protocolS.$urlCont.$folderCont;
$RAIZd=$RAIZ.'data/';
$RAIZi=$RAIZ.'images/';
$RAIZidb=$RAIZ.'images/db/';
$RAIZii=$RAIZ.'images/icons/';
$RAIZj=$RAIZ.'js/';
$RAIZt=$RAIZ.'css/';
$RAIZc=$RAIZ.'com/';
$RAIZs=$RAIZ.'system/';
$RAIZu=$RAIZ.'uploads/';
$RAIZmdb=$RAIZ.'media/db/';
$RAIZa=$RAIZ.'assets/';
/*
echo '<hr>';
echo 'RAIZ0 -> '.RAIZ0.'<hr>';
echo 'RAIZ -> '.RAIZ.'<hr>';
echo '$RAIZ0 -> '.$RAIZ0.'<hr>';
echo '$RAIZ -> '.$RAIZ.'<hr>';
echo '<hr>';
*/
/*
define('RAIZ',$_SERVER['DOCUMENT_ROOT'].'/');
define('RAIZm',RAIZ.'mods/');
define('RAIZf',RAIZ.'frames/');
define('RAIZa',RAIZ.'assets/');
define('RAIZi',RAIZ.'images/');
define('RAIZs',RAIZ.'system/');
define('RAIZd',RAIZ.'dat/');
//$RAIZ='http://localhost/mercoframes.com/';
$RAIZ='http://www.mercoframes.com/';
$RAIZm=$RAIZ.'mods/';
$RAIZa=$RAIZ.'assets/';
$RAIZs=$RAIZ.'system/';
$RAIZi=$RAIZ.'images/';
$RAIZd=$RAIZ.'dat/';
$RAIZidb=$RAIZi.'db/';
$RAIZidbP=$RAIZi.'items/';
$RAIZidbC=$RAIZi.'cats/';
$RAIZidbF=$RAIZi.'frame/';
$RAIZidbT=$RAIZi.'types/';
$RAIZidbF_s=$RAIZidbF.'small/';
$RAIZidbF_b=$RAIZidbF.'big/';
$RAIZidbF_f=$RAIZidbF.'full/';
*/
?>