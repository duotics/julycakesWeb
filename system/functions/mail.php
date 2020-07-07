<?php
include('../../init.php');
$dataf=$_POST;
$form=$dataf['txtType'];
$iditem=$dataf['txtRef'];
$insertGoTo = $RAIZ;
$_SESSION['dataf']=$dataf;
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$recaptcha=$_POST['g-recaptcha-response'];
	if(!empty($recaptcha)){
		$google_url="https://www.google.com/recaptcha/api/siteverify";
		$secret='6LcCKfsSAAAAALRsllPvUaewvLBfcuC6yNsgJUvY';
		$ip=$_SERVER['REMOTE_ADDR'];
		$url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
		$res=getCurlData($url);
		$res= json_decode($res, true);
		//reCaptcha success check 
		if($res['success']){
			if ($form=='contactus'){
				contactUs($dataf);
				$insertGoTo = $RAIZ."contact.php";
			}
			if ($form=='askItem'){
				contactItem($dataf);
				$detItem=detRow('db_items','item_id',$iditem);
				$insertGoTo = $RAIZ.'product/'.$detItem['item_aliasurl'];
			}
			if ($form=='askPage'){
				contactPage($dataf);
				$insertGoTo = $RAIZ;
			}
			unset($_SESSION['dataf']);
		}else{
			$LOG[m]="<h4>The reCAPTCHA wasn't entered correctly.</h4> Please try again.";
		}
	}else{
		$LOG[m]="<h4>The reCAPTCHA wasn't entered correctly.</h4> Please try again.";
	}
}
$_SESSION['LOG']=$LOG;
echo $LOG[m];
echo $LOG;
//header(sprintf("Location: %s", $insertGoTo));
?>