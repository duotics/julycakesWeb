<?php include('../../init.php');
$vP=FALSE;
unset($_SESSION[LOGd]);
$LOGd.='<hr> BEG EJECUTION MAIL';
$dataf=$_POST;
$form=$dataf['txtType'];
$iditem=$dataf['txtRef'];
switch ($form) {
    case "leasing":
        $goTo = $RAIZ."leasing";
        break;
	case "asupport":
        $goTo = $RAIZ."support";
        break;
    case "contactus":
        $goTo = $RAIZ."contact";
        break;
    case "askItem":
        $qryI=sprintf('SELECT db_items.item_aliasurl as i_url, db_items_type.typUrl as c_url 
		FROM db_items 
		LEFT JOIN db_items_type_vs ON db_items.item_id=db_items_type_vs.item_id 
		LEFT JOIN db_items_type ON db_items_type_vs.typID=db_items_type.typID 
		WHERE db_items.item_id=%s LIMIT 1',
		GetSQLValueString($dataf['txtRef'],'int'));
		$RSi=mysql_query($qryI) or die (mysql_error());
		$dRSi=mysql_fetch_assoc($RSi);
		$goTo = $RAIZ.'p/'.$dRSi['c_url'].'/'.$dRSi['i_url'];
        break;
	case "askPage":
        $goTo = $RAIZ;
        break;
    default:
        $goTo = $RAIZ;
}

$VARTEMP=TRUE;

$_SESSION['dataf']=$dataf;
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$recaptcha=$_POST['g-recaptcha-response'];
	//if(!empty($recaptcha)){
	if($VARTEMP){
		$google_url="https://www.google.com/recaptcha/api/siteverify";
		$secret='6LcCKfsSAAAAALRsllPvUaewvLBfcuC6yNsgJUvY';
		$ip=$_SERVER['REMOTE_ADDR'];
		$url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
		$res=getCurlData($url);
		$res= json_decode($res, true);
		//reCaptcha success check
		
		//if($res['success']){
		if($VARTEMP){
			$retCI=contactInsert($dataf);
			$idc=$retCI['id'];
			$LOG.=$retCI['log'];
			if($retCI['est']==TRUE){
				//DATA MAIL
				$dataS['datMail']=$dataf['txtMail'];
				$dataS['datName']=$dataf['txtName'].'. '.$dataf['txtCompany'];
				$dataS['altbody']='Message Receive Successfully';
				$dataS['altbodyC']='Our Team, reply you message quickly';
				//CASE FORM
				switch ($form) {
					case "contactus":
						$dataS['msg']=getRemoteFile($GLOBALS['RAIZ'].'system/msgs/s_contact.php?id='.$idc);
						$dataS['msgC']=getRemoteFile($GLOBALS['RAIZ'].'system/msgs/s_contact.php?id='.$idc.'&resp=TRUE');
						$dataS['subject'] = 'Mercoframes | Contact us - Msg';
						$dataS['subjectC'] = 'Contact Website Mercoframes';
					break;
					case "leasing":
						cLeasing($dataf);
						break;
					case "asupport":
						$ids=supportInsert($idc,$data);
						$dataS['msg']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_support.php?id='.$ids);
						$dataS['msgC']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_support.php?id='.$ids.'&resp=TRUE');
						break;
					case "askItem":
						//contactItem($dataf);
						$dProd=detRow('db_items','item_id',$dataf['txtRef']);
						$dataS['msg']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_contact.php?id='.$idc);
						$dataS['msgC']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_contact.php?id='.$idc.'&resp=TRUE');
						$dataS['subject'] = 'Mercoframes Inquiry product | '.$dProd['item_nom'];
						$dataS['subjectC'] = 'Inquiry Product | '.$dProd['item_nom'];
						break;
					case "askPage":
						contactPage($dataf);
						break;
					default:
					break;
				}
				$retSM=fsendPhpMailer($dataS);
				$LOG.=$retSM['log'];
				if($retSM[est]==TRUE){
					$vP=TRUE;
				}else{
					$LOG.='<p>Mail send error</p>';
				}
			}else{
				$LOG.= '<p>* no contact data inserted, no arm mail</p>';
			}
			$LOG.=$ret['log'];
			unset($_SESSION['dataf']);
		}else{
			$LOG.="<h4>The reCAPTCHA wasn't entered correctly.</h4> Please try again.";
		}
	}else{
		$LOG.="<h4>The reCAPTCHA wasn't entered correctly.</h4> Please try again.";
	}
}

//$LOGd.=$LOG;
//$_SESSION[LOGd]=$LOGd.$_SESSION[LOGd];
$rLOG[m]=$LOG.mysql_error();
if($vP==TRUE){
	$rLOG[c]='alert-success';
}else{
	$rLOG[c]='alert-warning';
}

$_SESSION[LOG]=$LOG;
header(sprintf("Location: %s", $goTo));
?>