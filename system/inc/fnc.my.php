<?php
ini_set('allow_url_fopen',1);
/*Verify Category Cont True*/
function verifyCatContHistory($idc){
	$verStat=TRUE;
	$statRepeat=0;
	do{
		$detCat=detRow('db_items_cats','cat_id',$idc);
		$idc=$detCat['cat_id_parent'];
		if(($idc==0)||(!$idc))$statRepeat=1;
		if($detCat['cat_status']==0) $verStat=FALSE;
	}while($statRepeat==0);
	return $verStat;
}
/*Breadcrumb Generate*/
function genBrdc($type,$id,$sel=NULL){
	$ret_li='<li><a href="'.$GLOBALS['RAIZ'].'">Home</a></li>';
	//BREADCRUMB CATALOG
	switch($type){
		case 'item' || 'cat':
			if($type=='item'){
				$detI=detRow('db_items','item_id',$id);
				$ret_lil='<li>'.$detI['item_cod'].'</li>';
				$detIC=detRow('db_items_type_vs','item_id',$id);
				$id=$detIC['typID'];
			}
			$loop=TRUE;//Bucle repeticion
			$cloop=0;//Contador Loops
			$detC_idp=$id;//ID de la primera categoria a realizar el Buble
			do{
				$detC=detRow('db_items_type','typID',$detC_idp);//DEtalle de la primera categoria
				$detC_id=$detC['typID'];
				$detC_nom=$detC['typNom'];
				$detC_idp=$detC['typIDp'];
				if($detC_id==1) $detC_nom='Products';
				$ret_lil='<li><a href="'.$GLOBALS['RAIZ'].'c/'.$detC['typUrl'].'">'.$detC_nom.'</a></li>'.$ret_lil;
				if(($detC_idp<=0)||($cloop>='100')) $loop=FALSE;
				$cloop++;
			}while($loop==TRUE);
		break;
		case 'blog' || 'blogc':
		break;
		default:
			if($sel)$ret_li.='<li class="active">'.$sel.'</li>';
		break;
	}
	//CONCAT BREADCRUMB
	$ret.='<ol class="breadcrumb">';
	$ret.=$ret_li;
	$ret.=$ret_lil;
	$ret.='</ol>';
	return $ret;
}

function genBrdc_old($type,$id,$sel=NULL){
	$ret_li='<li><a href="'.$GLOBALS['RAIZ'].'">Home</a></li>';
	//BREADCRUMB CATALOG
	if(($type=='item')||($type=='cat')){
		if($type=='item'){
			$detI=detRow('db_items','item_id',$id);
			$ret_lil='<li>'.$detI['item_cod'].'</li>';
			$detIC=detRow('db_items_type_vs','item_id',$id);
			$id=$detIC['typID'];
		}
		$loop=TRUE;
		$cloop=0;
		$detC_idp=$id;
		do{
			$detC=detRow('db_items_type','typID',$detC_idp);
			$detC_id=$detC['typID'];
			$detC_nom=$detC['typNom'];
			$detC_idp=$detC['typIDp'];
			if($detC_id==1) $detC_nom='Products';
			$ret_lil='<li><a href="'.$GLOBALS['RAIZ'].'c/'.$detC['typUrl'].'">'.$detC_nom.'</a></li>'.$ret_lil;
			if(($detC_idp==NULL)||($cloop>='100')) $loop=FALSE;
			$cloop++;
		}while($loop==TRUE);
	}
	//BREADCRUMB OTHER
	if($sel)$ret_li.='<li class="active">'.$sel.'</li>';
	//CONCAT BREADCRUMB
	$ret.='<ol class="breadcrumb">';
	$ret.=$ret_li;
	$ret.=$ret_lil;
	$ret.='</ol>';
	return $ret;
}
function fnc_franew($param1){
	$query_RS_datos = "SELECT item_date FROM db_items WHERE item_id='".$param1."'";
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	$fechasys=time(); 
	$datenow=date("Y-m-d", $fechasys);//FECHA SISTEMA
	$dateframe=$row_RS_datos["item_date"]; // FECHA FRAME
	$f1 = explode("-", $datenow);
	$f2 = explode("-", $dateframe);
	$timestamp1 = mktime(0,0,0,$f1[1],$f1[2],$f1[0]); $timestamp2 = mktime(0,0,0,$f2[1],$f2[2],$f2[0]); 
	$segundos_diferencia = $timestamp1 - $timestamp2; 
	//convierto segundos en días 
	$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 
	//obtengo el valor absoulto de los días (quito el posible signo negativo) 
	$dias_diferencia = abs($dias_diferencia); 
	//quito los decimales a los días de diferencia 
	$dias_diferencia = floor($dias_diferencia); 
	if ($dias_diferencia<90) return (TRUE); else return (FALSE);
	mysql_free_result($RS_datos);
}
function fnc_typlink($lcod, $lnom, $lali, $ldes, $ltyp){
	$link;
	if(($ltyp=="0")||($ltyp=="1"))//link
		$link="<a href='#' onclick='alert(".'"Under Construction"'.")'>".$lnom." <span style='font-size:70%; color:#888;'>[ Under Construction ]</span>"."</a><br />";
	if(($ltyp=="2")||($ltyp=="3")||($ltyp=="4")||($ltyp=="6"))//catalog, html, iframe, adgallery
		$link="<a href='".$RAIZ."category/".$lali."' style='text-decoration:none'>".$lnom."</a><br />";
	if($ltyp=="5")//link
		$link='<a href="'.$ldes.'" target="_blank">'.$lnom.' <i class="icon-resize-full"></i> <span class="muted" style="font-weight:normal">'.$ldes.'</span></a>';
	return $link;
}

function genValBrand($idb,$res=NULL){
$RAIZic=$GLOBALS['RAIZi'].'brand/';
$detB=detRow('db_items_brands','id',$idb);
	if($res=='image'){
		$result = '<img src="'.$RAIZic.$detB['img'].'" alt="'.$detCat['nom'].'" style="max-width:100px; max-height:50px;" class="img-thumbnail"/>';
	} else if($res=='text'){ $result = $detB['nom'];
	}else{ $result = 'NULL'; }
return($result);
}

function updHits($table,$fieldHits,$fieldId,$val){//v.1.1
	$ret=NULL;
	$vP=FALSE;
	$qry=sprintf('UPDATE %s SET %s=%s+1 WHERE %s=%s',
	SSQL(strip_tags($table),''),
	SSQL(strip_tags($fieldHits),''),
	SSQL(strip_tags($fieldHits),''),
	SSQL(strip_tags($fieldId),''),
	SSQL($val,'int'));
	if(mysqli_query($GLOBALS['conn'],$qry)){
		$LOG.='Hits updated';
		$vP=TRUE;
	}else{
		$LOG.=mysqli_error();
	}
	$ret['log']=$LOG;
	$ret['est']=$vP;
	return $ret;
}

/*UPDATE HITS Articles, Category and Products*/
function updateArtHits($param1){
	$query_upd=sprintf('UPDATE tbl_articles SET hits=hits+1 WHERE art_id=%s',
		SSQL($param1,'int'));
	mysqli_query($conn,$query_upd) or (print mysqli_error($conn));
}
function updItemhits($param1){
	$query_upd=sprintf('UPDATE db_items SET item_hits=item_hits+1 WHERE item_id=%s',
		SSQL($param1,'int'));
	mysqli_query($query_upd)or (print mysql_error());
}
function updBrandhits($param1){
	$query_upd=sprintf('UPDATE db_items_brands SET hits=hits+1 WHERE id=%s',
		SSQL($param1,'int'));
	mysqli_query($query_upd)or (print mysql_error());
}
function updateCatHits($param1){
	$query_upd=sprintf('UPDATE db_items_cats SET cat_hits=cat_hits+1 WHERE cat_id=%s',
		SSQL($param1,'int'));
	mysqli_query($query_upd) or (print mysql_error());
}

/*************** TYPE GROUP *******************/
function genBtnTypG($det,$paramBrand=NULL){
$det_nom=strtoupper($det['c_nom']);
$image=vImg('data/img/cat/',$det['c_img']);
$imgcat='<div class="vcat-cat-img" class="text-center">
<img src="'.$image['t'].'" alt="'.$det_nom.'" class="img-responsive"/></div>';
$tV=$det['c_typ'];
//Construct URL
switch ($tV) {
    case 1://Under Construcction
        $link_opt='onclick="alert('."'Under Construction'".')"';
		$link_url='#';
        break;
    case 2://Catalog
        $link_url=$GLOBALS["RAIZ"].'c/'.$det['c_url'].'/'.$paramBrand;
		$link_trg='_self';
        break;
    case 3://External
        $link_url=$det['c_des'];
		$link_trg='_blank';
        break;
    default:
        //No View
}

$btnRet='<a href="'.$link_url.'" target="'.$link_trg.'" id="c_'.$det['c_id'].'" '.$link_opt.' class="vcat-cat-cont">';
$btnRet.='<div class="panel panel-default vcat-cat">';
$btnRet.='<div class="panel-heading text-center">'.$det_nom.'</div>';
$btnRet.='<div class="panel-body">';
//$btnRet.='<span class="btn btn-default btn-md btn-block" style="overflow:hidden; font-size:12px">'.$det_nom.'</span>';
$btnRet.=$imgcat;
$btnRet.='</div>';
$btnRet.='</div>';
$btnRet.='</a>';
echo $btnRet;
}

function genBtnItemG($det,$css=NULL,$other=NULL){
	$i_img=vImg('data/db/prods/',$det['i_img']);
	if($det['b_img']) $b_img=vImg('data/db/brands/',$det['b_img']);
	
	$det_price=$det['i_pri'];
	if($det['i_pri2']) $det_price=$det['i_pri2'];
	$det_price=number_format($det_price,2,',','.');
	
	$detPri=$det['i_pri'];
	$detPri2=$det['i_pri2'];
	$detPorc=NULL;
	if($detPri2){
		$detPorc=100-(($detPri2*100)/$detPri);
		$detAho=$detPri-$detPri2;
		$detPri='<tr><td><div class="label-pri">Normal:</div></td>
		<td><div class="cat-pri_ant">$ '.number_format($detPri,2,',','.').'</div></td></tr>';
		$detPri2='<tr><td><div class="label-pri">Final: </div></td>
		<td><div class="cat-pri_fin">$ '.number_format($detPri2,2,',','.').'</div></td></tr>';
		$detPorc='<tr><td><div class="label-pri">Ahorra:</div></td>
		<td><div class="cat-pri_aho">$ '.number_format($detAho,2,',','.').' ('.number_format($detPorc,0).'%)</div></td>';
	}else{
		$detPri='<tr><td><div class="label-pri">Final:</div></td>
		<td><div class="cat-pri_fin">$ '.number_format($detPri,2,',','.').'</div></td></tr>';
	}
	
	/*
	<?php echo $detPri ?>
    <?php echo $detPri2 ?>
    <?php echo $detPorc ?>
	*/

	$dias = (strtotime($GLOBALS['sdate'])-strtotime($det['i_date']))/86400;
	$dias = abs($dias);
	$dias = floor($dias);	

	$link=$GLOBALS["RAIZ"].'p/'.$det['c_url'].'/'.$det['i_url'];
	/***********************************************************/
	/*
	$btnRet.='<a href="'.$link.'" class="card vcat-item" id="**i_'.$det['i_id'].'">';
	$btnRet.='<div class="vcat-item-head">';
	$btnRet.='<div class="vcat-item-brand"><img src="'.$b_img['t'].'"/></div>'; 
	if($dias<=45) $btnRet.='<div class="vcat-item-starNew"><img src="'.$GLOBALS['RAIZa'].'img/icon/New-32.png"></div>';
	$btnRet.='</div>';
	$btnRet.='<div class="vcat-item-img text-center">';
	$btnRet.='<img src="'.$i_img['t'].'" alt="'.$det['i_cod'].'" class="img-fluid"/>';
	$btnRet.='</div>';
	$btnRet.='<div class="vcat-item-tit text-center">'.$det['i_cod'].'</div>';
	$btnRet.='</a>';
	*/
	/***********************************************************/
	$btnRet2.='<a href="'.$link.'" id="i_'.$det['i_id'].'" class="'.$css.'" '.$other.'>';
	//if($dias<=45) $btnRet2.='<div class="lastViewCat"><img src="'.$GLOBALS['RAIZa'].'img/icon/New-32.png"></div>';
	//$btnRet2.='<div class="cont-img-card-prod text-center">';
	$btnRet2.='<img src="'.$i_img['t'].'" alt="'.$det['i_cod'].'" class="card-img-top"/>';
	//$btnRet2.='</div>';
	$btnRet2.='<div class="vcat-item-tit text-center">';
	$btnRet2.=$det[i_nom];
	$btnRet2.='<div class="badge badge-light">'.$det[b_nom].'</div>';
	$btnRet2.='</div>';
	$btnRet2.='<div class="cat-v-itools-sel"><table class="prices">
			<tr><td width="50%"></td>
			<td width="50%"></td></tr>';
	$btnRet2.=$detPri;
	$btnRet2.=$detPri2;
	$btnRet2.=$detPorc;
	$btnRet2.='</table></div>';
	$btnRet2.='</a>';
	/***********************************************************/
	return $btnRet2;
}

function genBtnItemG_old($det){
	$img=vImg('data/db/prods/',$det['i_img']);
	
	$viewIB=FALSE;
	if($det['b_vimg']==1){
		$b_img=vImg('data/img/brand/',$det['b_img']);
		$viewIB=TRUE;
	}

	$dias = (strtotime($GLOBALS['sdate'])-strtotime($det['i_date']))/86400;
	$dias = abs($dias);
	$dias = floor($dias);	

	$link=$GLOBALS["RAIZ"].'p/'.$det['c_url'].'/'.$det['i_url'];

	$btnRet2.='<a href="'.$link.'" class="thumbnail vcat-item" id="i_'.$det['i_id'].'">';
	
	if($viewIB) $btnRet2.='<div class="brandVC"><img src="'.$b_img['t'].'"/></div>';
	
	if($dias<=120) $btnRet2.='<div class="icon-new"><span class="badge text-warning">NEW</span></div>';
	$btnRet2.='<div class="vcat-item-img text-center">';
	$btnRet2.='<img src="'.$img['t'].'" alt="'.$det['i_cod'].'" style="max-height:150px"/>';
	$btnRet2.='</div>';
	$btnRet2.='<div class="caption text-center">'.$det['i_nom'].'</div>';
	$btnRet2.='</a>';
	return $btnRet2;
}

function genBtnBrand($det){
$link=$GLOBALS["RAIZ"].'brand/'.$det['b_url'];
$b_img=fnc_image_exist($GLOBALS['RAIZ'],'images/brand/',$det['b_img']);
$btnRet.='<a href="'.$link.'" class="thumbnail vcat-item" id="i_'.$det['i_id'].'">';
$btnRet.='<div class="vcat-item-img text-center">';
$btnRet.='<img src="'.$b_img['t'].'" alt="'.$det['i_cod'].'" class="img-responsive"/>';
$btnRet.='</div>';
$btnRet.='<div class="vcat-item-tit text-center">'.$det['b_nom'].'</div>';
$btnRet.='</a>';
echo $btnRet;
}

/*VERIFY NEW BETWEEN DATE*/
function vrfNew($date,$days){
	$datenow=$GLOBALS['sdate'];//FECHA SYS
	$datesel=$date; // FECHA SEL
	$f1 = explode("-", $datenow);
	$f2 = explode("-", $datesel);
	$timestamp1 = mktime(0,0,0,$f1[1],$f1[2],$f1[0]); $timestamp2 = mktime(0,0,0,$f2[1],$f2[2],$f2[0]); 
	$segundos_diferencia = $timestamp1 - $timestamp2; 
	//convierto segundos en días 
	$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 
	//obtengo el valor absoulto de los días (quito el posible signo negativo) 
	$dias_diferencia = abs($dias_diferencia); 
	//quito los decimales a los días de diferencia 
	$dias_diferencia = floor($dias_diferencia); 
	if ($dias_diferencia<=$days) return (TRUE);
	else return (FALSE);
}

function contactInsert($data){
	Global $conn;
	$LOGd.='<hr> BEG FUN CONTACT_INS';
	$vP=FALSE;
	$detM=detRow('tbl_contact_mail','mail',$data["txtMail"]);//Detalles de Contacto Existente con email
	if($detM){//Sel idMail
		$LOGd.= '<p>Si hay Mail</p>';
		$idm=$detM['idMail'];
	}else{//INSERT tbl_contact_mail : Mail contacto
		$LOGd.= '<p>No data Mail, INSERT tbl_contact_mail</p>';
		$qryInsM = sprintf("INSERT INTO `tbl_contact_mail` (`mail`) VALUES (%s)",
			SSQL($data["txtMail"], "text"));
		if(mysqli_query($conn,$qryInsM)){
			$LOGd.= '<p>*tbl_contact_mail INSERT TRUE</p>';
			$idm=mysqli_insert_id($conn);
			
		}else{
			$LOGd.= '<p>*tbl_contact_mail INSERT FALSE</p>';
			$LOG.='<p>Error insert mail in database</p>'.mysqli_error($conn);
		}
	}
	if($idm){
		//Insert contact_data
			$qryInsC = sprintf("INSERT INTO tbl_contact_data 
			(idMail, name, date, company, phone1, address, country, state, city, zip, message, cfrom, ip, type, id_ref, ContactKnow) 
			VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				SSQL($idm, "int"),
				SSQL($data['txtName'], "text"),
				SSQL($GLOBALS['sdate'], "text"),
				SSQL($data['txtCompany'], "text"),
				SSQL($data['txtPhone'], "text"),
				SSQL($data['txtAdress'], "text"),
				SSQL($data['txtCountry'], "text"),
				SSQL($data['txtState'], "text"),
				SSQL($data['txtCity'], "text"),
				SSQL($data['txtZipcode'], "text"),
				SSQL(substr($data["txtMessage"], 0, 1000), "text"),
				SSQL('web', "text"),
				SSQL(getRealIP(), "text"),
				SSQL($data['txtType'], "text"),
				SSQL($data['txtRef'], "text"),
				SSQL($data['ContactKnow'], "int"));
			if(mysqli_query($conn,$qryInsC)){
				$LOGd.= '<p>*tbl_contact_data INSERT TRUE</p>';
				$idc=mysqli_insert_id($conn);
				$vP=TRUE;
			}else{
				$LOGd.= '<p>*tbl_contact_data INSERT FALSE</p>';
				$LOG.='<p>Error insert contact_data in database</p>'.mysqli_error($conn);
			}
	}else{
		$LOGd.= 'NO HAY MAIL';
	}
	$ret['log']=$LOG;
	if($vP==TRUE){
		$ret['est']=TRUE;
		$ret['id']=$idc;
	}else{
		$ret['est']=FALSE;
	}
	$LOGd.= 'END FUN CONT_INS_DATA<hr>';
	$_SESSION[LOGd].=$LOGd;
	return($ret);
	
}
function supportInsert($idc,$data){
	//Inserto Soporte
	$vP=FALSE;
	$qryIns = sprintf("INSERT INTO tbl_support (idData, invoice, date, datep, msg, status) VALUES (%s,%s,%s,%s,%s,%s)",
		SSQL($idc, "int"),
		SSQL($data['txtInv'], "text"),
		SSQL($GLOBALS['sdate'], "text"),
		SSQL($data['txtDP'], "text"),
		SSQL($data['txtMessage'], "text"),
		SSQL("1", "int"));
	if(mysql_query($qryIns)){
		$ids=mysql_insert_id();
		$fPS['PN']=$data['txtPN'];
		$fPS['SN']=$data['txtSN'];
		$fPS['MS']=$data['txtMS'];
		$qryInsR=sprintf('INSERT INTO tbl_support_det (idSp,item_id,nom,serial,problem) VALUES (%s,%s,%s,%s,%s)',
		SSQL($ids,'int'),
		SSQL($fPS['IN'],'int'),
		SSQL($fPS['PN'],'text'),
		SSQL($fPS['SN'],'text'),
		SSQL($fPS['MS'],'text'));
		if(mysql_query($qryInsR)){
			$vP=TRUE;
		}else{
			$LOG.='<p>Error in insert support detaill</p>'.mysql_error();
		}
	}
	$ret[log]=$LOG;
	if($vP==TRUE){
		$ret[est]=TRUE;
		$ret[id]=$ids;
	}else{
		$ret[est]=FALSE;
	}
	return $ret;
}

/*
function contactUs($data){
	$LOGd.= '<hr> BEG FUN CONTUS';
	$vP=FALSE;
	$retCI=contactInsert($data);
	$idc=$retCI['id'];
	$LOG.=$retCI['log'];
	if($retCI['est']==TRUE){
		$LOGd.= '<p>* OK INSERT - ARM MAIL</p>';
		//$dataS['msg']='<p>Msg A</p>';//getRemoteFile($GLOBALS[RAIZ].'system/msgs/s_contact.php?id='.$idc)
		//$dataS['msgC']='<p>Msg B</p>';//getRemoteFile($GLOBALS[RAIZ].'system/msgs/s_contact.php?id='.$idc.'&resp=TRUE')
		$dataS['msg']=getRemoteFile($GLOBALS['RAIZ'].'system/msgs/s_contact.php?id='.$idc);
		$dataS['msgC']=getRemoteFile($GLOBALS['RAIZ'].'system/msgs/s_contact.php?id='.$idc.'&resp=TRUE');
		
		$dataS['subject'] = 'Mercoframes | Contact us - Msg';
		$dataS['subjectC'] = 'Contact Website Mercoframes';
		$dataS['altbody']='Message Receive Successfully';
		$dataS['altbodyC']='Our Team, reply you message quickly';
		$dataS['datMail']=$data['txtMail'];
		$dataS['datName']=$data['txtName'].'. '.$data['txtCompany'];
		$retSM=fsendPhpMailer($dataS);
		$LOG.=$retSM['log'];
		if($retSM[est]==TRUE){
			$vP=TRUE;
		}else{
			$LOG.='<p>Mail send error</p>';
		}
	}else{
		$LOGd.= '<p>* no contact data inserted, no arm mail</p>';
	}
	$ret[log]=$LOG;
	if($vP==TRUE){
		$ret[est]=TRUE;
	}else{
		$ret[est]=FALSE;
	}
	$LOGd.= 'END FNC CONTUS<hr>';
	$_SESSION[LOGd].=$LOGd;
	return $ret;
	
}
function cLeasing($data){
	$idc=contactInsert($data);
	ini_set('allow_url_fopen',1);
	ini_set('allow_url_include',1);
	$dataS['msg']=file_get_contents($GLOBALS['RAIZs'].'msgs/s_leasing.php?id='.md5($idc));
	ini_set('allow_url_fopen',1);
	ini_set('allow_url_include',1);
	
	$dataS['msgC']=file_get_contents($GLOBALS['RAIZs'].'msgs/s_leasing.php?id='.md5($idc).'&resp=TRUE');
	$dataS['subject'] = 'Mercoframes - Leasing Optical Equipment';
	$dataS['subjectC'] = 'Inquiry Leasing from Mercoframes Web';
	$dataS['altbody']='Message Receive Successfully';
	$dataS['altbodyC']='Our Team, reply you message quickly';
	$dataS['datMail']=$data['txtMail'];
	$dataS['datName']=$data['txtName'].'. '.$data['txtCompany'];
	fsendPhpMailer($dataS);
}
function cSupport($data){
	$idc=contactInsert($data);
	$ids=supportInsert($idc,$data);
	$dataS['msg']=file_get_contents($GLOBALS['RAIZs'].'msgs/s_support.php?id='.$ids);
	$dataS['msgC']=file_get_contents($GLOBALS['RAIZs'].'msgs/s_support.php?id='.$ids.'&resp=TRUE');
	$dataS['subject'] = 'Mercoframes Technical Support';
	$dataS['subjectC'] = 'Mercoframes Technical Support';
	$dataS['altbody']='Message Receive Successfully';
	$dataS['altbodyC']='Our Team, reply you message quickly';
	$dataS['datMail']=$data['txtMail'];
	$dataS['datName']=$data['txtName'].'. '.$data['txtCompany'];
	fsendPhpMailer($dataS);
}
function contactItem($data){
	$vP=FALSE;
	//$idc=contactInsert($data);
	$retCI=contactInsert($data);
	$idc=$retCI['id'];
	$LOG.=$retCI['log'];
	
	$detProd=detRow('db_items','item_id',$data['txtRef']);

	
	
	if($retCI['est']==TRUE){
		//$dataS['msg']=file_get_contents($GLOBALS['RAIZs'].'msgs/s_contact.php?id='.$idc);
		//$dataS['msgC']=file_get_contents($GLOBALS['RAIZs'].'msgs/s_contact.php?id='.$idc.'&resp=TRUE');
		$dataS['msg']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_contact.php?id='.$idc);
		$dataS['msgC']=getRemoteFile($GLOBALS['RAIZs'].'msgs/s_contact.php?id='.$idc.'&resp=TRUE');
		
		$dataS['subject'] = 'Mercoframes Inquiry product | '.$detProd['item_nom'];
		$dataS['subjectC'] = 'Inquiry Product | '.$detProd['item_nom'];
		$dataS['altbody']='Message Receive Successfully';
		$dataS['altbodyC']='Our Team, reply you message quickly';
		$dataS['datMail']=$data['txtMail'];
		$dataS['datName']=$data['txtName'].'. '.$data['txtCompany'];
		$retSM=fsendPhpMailer($dataS);
		$LOG.=$retSM['log'];
		if($retSM[est]==TRUE){
			$vP=TRUE;
		}else{
			$LOG.='<p>Mail send error</p>';
		}
		
	}else{
		$LOGd.= '<p>* no contact data inserted, no arm mail</p>';
	}
	
	$ret[log]=$LOG;
	if($vP==TRUE){
		$ret[est]=TRUE;
	}else{
		$ret[est]=FALSE;
	}
	$LOGd.= 'END FNC CONTUS<hr>';
	$_SESSION[LOGd].=$LOGd;
	return $ret;
}
function contactPage($data){
	$idc=contactInsert($data);
	$detPage=detRow('tbl_articles','art_id',$data['txtRef']);
	$dataS['msg']=file_get_contents($GLOBALS['RAIZs'].'msgs/s_contact.php?id='.$idc);
	$dataS['msgC']=file_get_contents($GLOBALS['RAIZs'].'msgs/s_contact.php?id='.$idc.'&resp=TRUE');
	$dataS['subject'] = 'Mercoframes Question | '.$detPage['title'];
	$dataS['subjectC'] = 'Question | '.$detPage['title'];
	$dataS['altbody']='Message Receive Successfully';
	$dataS['altbodyC']='Our Team, reply you message quickly';
	$dataS['datMail']=$data['txtMail'];
	$dataS['datName']=$data['txtName'].'. '.$data['txtCompany'];
	fsendPhpMailer($dataS);
}
*/

function fsendPhpMailer($data){
	$LOGd.= '<hr><p>* BEG SEND MAIL</p>';
	date_default_timezone_set('America/New_York');
	$mail = new PHPMailer(true);
	$mail->IsSMTP();//telling the class to use SMTP
	try {
		$mail->Host = 'ssl://consul.websitewelcome.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->Username = 'info@ecuahomes.net';
		$mail->Password = 'EC2018homes';
		
		/*
		$mail->Host = 'ssl://smtp.gmail.com';
		$mail->Port = 465;
		$mail->SMTPAuth = true;
		$mail->Username = 'desarrollo@duotics.com';
		$mail->Password = 'desduotics2012.*';
		*/
		
		/*************** MAIL TO COMPANY ****************/
		$mail->AddAddress('info@ecuahomes.net', 'ECUA homes');
		//$mail->AddAddress('desarrollo@duotics.com', 'DUOTICS');
		$mail->SetFrom('info@ecuahomes.net', 'ECUA homes');
		$mail->Subject = $data['subject'];
		$mail->AltBody = $data['altbody'];
		$mail->MsgHTML($data['msg']);
		$mail->Send();
		/*************** MAIL TO CLIENT *****************/
		$mail->ClearAddresses();
		$mail->AddAddress($data['datMail'], $data['datName']);
  		$mail->SetFrom('info@ecuahomes.net', 'ECUA Homes');
  		$mail->AddReplyTo('info@ecuahomes.net', 'ECUA Homes');
  		$mail->Subject = $data['subjectC'];
		$mail->AltBody = $data['altbodyC'];
	  	$mail->MsgHTML($data['msgC']);
  		$mail->Send();
		
		switch ($data['txtType']) {
			case "asupport":
				$msgResp='<h4 class="text-center"><i class="fa fa-life-ring fa-lg"></i>  Your Inquiry was sent sucessfully.</h4>';
				break;
			case "contactus":
				$msgResp='<h4 class="text-center">Your message was sent successfully! I will be in touch as soon as I can.</h4>';
				break;
			case "askItem":
				$msgResp='<h4 class="text-center">Your message was sent successfully! I will be in touch as soon as I can.</h4>';
				break;
			case "askPage":
				$msgResp='<h4 class="text-center">Your message was sent successfully! I will be in touch as soon as I can.</h4>';
				break;
			default:
				$msgResp='<h4 class="text-center">Your message was sent successfully! I will be in touch as soon as I can.</h4>';
		}
		$ret[log]=$msgResp;
		$ret[est]=TRUE;
		$LOGd.= '<p>* SEND TRUE</p>';
	} catch (phpmailerException $e) {
	  $e->errorMessage(); //Pretty error messages from PHPMailer
	  $ret[log]=$e;
	  $ret[est]=FALSE;
	  $LOGd.=$e;
	  $LOGd.= '<p>* SEND FAIL</p>';
	} catch (Exception $e) {
	  $e->getMessage(); //Boring error messages from anything else!
	  $ret[log]=$e;
	  $ret[est]=FALSE;
	  $LOGd.=$e;
	  $LOGd.= '<p>* SEND FAIL</p>';
	}
	$LOGd.= '<p>* END SEND MAIL</p>';
	$_SESSION[LOGd].=$LOGd;
	return $ret;
}

function send_email($to, $subject, $msg, $headers=NULL){
	if (mail($to, $subject, $msg, $headers)) return TRUE;
	else return FALSE;
}
function btnBackCat($param1){
	if(!$param1){	
		echo '<a href="'.$GLOBALS['RAIZ'].'"><i class="fa fa-chevron-left"></i> Go back to <span class="btn btn-default btn-xs">Home</span></a>';
	}else if($param1==1){	
		echo '<a href="'.$GLOBALS['RAIZ'].'c/"><i class="fa fa-chevron-left"></i> Go back to <span class="btn btn-default btn-xs">All Products</span></a>';
	}else{
		$detC=detRow('db_items_type','typID',$param1);
		echo '<a href="'.$GLOBALS['RAIZ'].'c/'.$detC['typUrl'].'"><i class="icon-chevron-left"></i> Go back to <span class="btn btn-default btn-xs">'.$detC["typNom"].'</span></a>';
	}
}

function detArticleCat($param1,$idCat=NULL){
	if (!isset($param1)){
		$query_RS_datos = sprintf("SELECT * FROM tbl_articles WHERE cat_id=%s AND status=1 ORDER BY art_id DESC LIMIT 1",
			GetSQLValueString($idCat,'int'));
	} else {
		$query_RS_datos = sprintf("SELECT * FROM tbl_articles WHERE art_id=%s AND cat_id=%s",
			GetSQLValueString($param1,'int'),
			GetSQLValueString($idCat,'int'));
	}
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	return ($row_RS_datos);
	mysql_free_result($RS_datos);
}
function seoGoogleMetas($title=NULL,$metades=NULL){
	if ($title) echo '<title>'.$title.'</title>';
	else echo '<title>Mercoframes Optical Corp</title>';
	if ($metades){
		$metades=strip_tags($metades);
		echo '<meta name="description" content="'.$metades.'">';
	}else echo '<meta name="description" content="'.$title.'">';
}

function seoGenTitle($tit,$pTm=NULL,$pTp=FALSE){
	$seotitle=$tit;
	if($pTm){
		$catTm=dtrademark($pTm,'text');
		$seotitle.=' - '.$catTm;
	}
	if($pTp){
		$seotitle.=' - '.$GLOBALS['wTit'];
	}
	return $seotitle;
}

?>