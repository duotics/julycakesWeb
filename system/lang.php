<?php 
function startLang(){
	if(!($_SESSION['txt'])){
		if(!$_SESSION['lang']) $_SESSION['lang']='en';
		$conf=parse_ini_file(RAIZs.'lang/'.$_SESSION['lang'].'.ini',TRUE);
		foreach($conf as $x => $xval){
			foreach($xval as $y => $yval) $langEnd[$x][$y]=$yval;
		}
	}
	return $langEnd;
}
$lang=startLang();
?>