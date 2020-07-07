<?php include('../../init.php');
$vP=FALSE;
$vSM=TRUE;//Veerify to Send Mail
//unset($_SESSION[LOGd]);
//$LOGd.='<hr> BEG EJECUTION MAIL';
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
		SSQL($dataf['txtRef'],'int'));
		$RSi=mysqli_query($conn,$qryI) or die (mysqli_error($conn));
		$dRSi=mysqli_fetch_assoc($RSi);
		$goTo = $RAIZ.'p/'.$dRSi['c_url'].'/'.$dRSi['i_url'];
		mysqli_free_result($RSi);
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
	if(!empty($recaptcha)){
	//if($VARTEMP){
		$google_url="https://www.google.com/recaptcha/api/siteverify";
		$secret='6LezEFEUAAAAALjUDvYCR8QFI33E6dTqWYaFInxV';
		$ip=$_SERVER['REMOTE_ADDR'];
		$url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
		$res=getCurlData($url);
		$res= json_decode($res, true);
		//reCaptcha success check
		if($res['success']){
		//if($VARTEMP){
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
						$dataS['msg']=getRemoteFile($GLOBALS['RAIZ'].'system/msgs/s_contact.php?id='.md5($idc));
						$dataS['msgC']=getRemoteFile($GLOBALS['RAIZ'].'system/msgs/s_contact.php?id='.md5($idc).'&resp=TRUE');
						$dataS['subject'] = 'ECUA Homes : Contact us';
						$dataS['subjectC'] = 'Information contact from website';
					break;
					case "leasing":
						$dataS['msg']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_leasing.php?id='.md5($idc));
						$dataS['msgC']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_leasing.php?id='.md5($idc).'&resp=TRUE');
						$dataS['subject'] = 'Mercoframes - Leasing Optical Equipment';
						$dataS['subjectC'] = 'Inquiry Leasing from Mercoframes Web';
					break;
					case "asupport":
						$retSP=supportInsert($idc,$dataf);
						$ids=$retSP[id];
						$LOG.=$retSP[log];
						if($retSP[est]==TRUE){
							$dataS['msg']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_support.php?id='.md5($ids));
							$dataS['msgC']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_support.php?id='.md5($ids).'&resp=TRUE');
							$dataS['subject'] = 'Mercoframes Technical Support';
							$dataS['subjectC'] = 'Mercoframes Technical Support';
						}else{
							$vSM=FALSE;
							$vP=FALSE;
						}
					break;
					case "askItem":
						$dProd=detRow('db_items','item_id',$dataf['txtRef']);
						$dataS['msg']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_ask.php?id='.md5($idc));
						$dataS['msgC']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_ask.php?id='.md5($idc).'&resp=TRUE');
						$dataS['subject'] = 'Mercoframes Inquiry product | '.$dProd['item_nom'];
						$dataS['subjectC'] = 'Inquiry Product | '.$dProd['item_nom'];
					break;
					case "askPage":
						$detPage=detRow('tbl_articles','art_id',$dataf['txtRef']);
						$dataS['msg']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_ask.php?id='.md5($idc));
						$dataS['msgC']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_ask.php?id='.md5($idc).'&resp=TRUE');
						$dataS['subject'] = 'Mercoframes Question | '.$detPage['title'];
						$dataS['subjectC'] = 'Question | '.$detPage['title'];
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

$_SESSION[LOG]=$rLOG;
header(sprintf("Location: %s", $goTo));
?>