<?php

function genBreadcrumb($type,$id,$sel=NULL){//v.2.0
	$ret_li='<li class="breadcrumb-item"><a href="'.$GLOBALS['RAIZ'].'">Inicio</a></li>';
	//BREADCRUMB CATALOG
	if(($type=='item')||($type=='cat')){
		if($type=='item'){
			$detI=detRow('db_items','item_id',$id);
			$ret_lil='<li class="breadcrumb-item">'.$detI['item_cod'].'</li>';
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
			if($detC_id==0) $detC_nom='Productos';
			$ret_lil='<li class="breadcrumb-item"><a href="'.$GLOBALS['RAIZ'].'c/'.$detC['typUrl'].'">'.$detC_nom.'</a></li>'.$ret_lil;
			if(($detC_idp==NULL)||($cloop>='100')) $loop=FALSE;
			$cloop++;
		}while($loop==TRUE);
	}
	
	if($type=='gall'){
		$ret_li.='<li class="breadcrumb-item"><a href="'.$GLOBALS['RAIZ'].'g">Gallery</a></li>';
	}
	
	//BREADCRUMB OTHER
	if($sel)$ret_li.='<li class="breadcrumb-item active">'.$sel.'</li>';
	//CONCAT BREADCRUMB
	$ret.='<nav aria-label="breadcrumb">';
	$ret.='<ol class="breadcrumb">';
	$ret.=$ret_li;
	$ret.=$ret_lil;
	$ret.='</ol>';
	$ret.='</nav>';
	return $ret;
}

function getLangT($table,$field,$idr,$lang){
	$detLT=detRow('db_lang_table','table_name',$table);
	if($detLT){
		$idt=$detLT[id];

		$paramsN=NULL;//REINICIAR EL $paramsN siempre ya que si entra a un bucle se almacena y da error
		$paramsN[]=array(
			array("cond"=>"AND","field"=>"idt","comp"=>"=","val"=>$idt),
			array("cond"=>"AND","field"=>"field_name","comp"=>'=',"val"=>$field),
			array("cond"=>"AND","field"=>"idr","comp"=>'=',"val"=>$idr),
			array("cond"=>"AND","field"=>"lang","comp"=>'=',"val"=>$lang),
		);
		$detT=detRowNP('db_lang_txt',$paramsN);
		$ret=$detT['txt'];
	}
	return $ret;
}
function cLOG($data){//v.0.1 -> duotics_lib
  echo '<script>';
  echo 'console.log('.json_encode($data).')';
  echo '</script>';
}
function vrfLinkStr($param){
//cadena origen con los enlaces sin detectar
//filtro los enlaces normales
$cadena_resultante= preg_replace("/((http|https|www)[^\s]+)/", '<a href="$1">$0</a>', $param);
//miro si hay enlaces con solamente www, si es así le añado el http://
$cadena_resultante= preg_replace("/href=\"www/", 'href="http://www', $cadena_resultante);
echo '<h3>Cadena filtrada con enlaces normales:</h3>'.$cadena_resultante;
 
//saco los enlaces de twitter
$cadena_resultante = preg_replace("/(@[^\s]+)/", '<a target=\"_blank\"  href="http://twitter.com/intent/user?screen_name=$1">$0</a>', $cadena_resultante);
$cadena_resultante = preg_replace("/(#[^\s]+)/", '<a target=\"_blank\"  href="http://twitter.com/search?q=$1">$0</a>', $cadena_resultante);
echo '<h3>Cadena filtrada con enlaces de Twitter:</h3>'.$cadena_resultante;
}
//
function detRowNP($table,$params){ //v2.0 -> duotics_lib
	Global $conn;
	if($params){
		foreach($params as $x => $dat) {
			foreach($dat as $y => $xVal) $lP.=$xVal['cond'].' '.$xVal['field'].' '.$xVal['comp'].' "'.$xVal['val'].'" ';
		}
	}
	$qry = sprintf("SELECT * FROM %s WHERE 1=1 ".$lP,
	SSQL($table, ''));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	mysqli_free_result($RS);
	return ($dRS);
}
//
//GENERACION DE MENUS CON NIVELES Y LENGUAJES
function genMenu($refMC,$css=NULL,$vrfUL=TRUE, $active=null){//v.3.0
	Global $conn;
	//verifico si el menu existe
	$dMC=detRow('tbl_menus','ref',$refMC);
	if($dMC){
		//Consulta si el usuario es SuperAdmin
		if($_SESSION['dU']['LEVEL']!=0){
			$userJoin=' INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id = tbl_menu_usuario.men_id ';
			$userLevel=' AND tbl_menu_usuario.usr_id ='.$_SESSION['dU']['ID'];
		}
		//Consulta para Menus Principales
		$qry=sprintf("SELECT * FROM tbl_menus_items ".
		$userJoin.
		"INNER JOIN tbl_menus on tbl_menus_items.men_idc=tbl_menus.id WHERE tbl_menus.ref = %s AND tbl_menus_items.men_padre = %s ".
		$userLevel.
		" AND tbl_menus_items.men_stat = %s ORDER BY men_orden ASC",
		SSQL($refMC,'text'),
		SSQL('0','int'),
		SSQL('1','text'));
		
		$RSmp = mysqli_query($conn,$qry) or die(mysqli_error($conn));
		$dRSmp = mysqli_fetch_assoc($RSmp);
		$tRSmp = mysqli_num_rows($RSmp);
		//echo $qry;
		//
		if($tRSmp > 0){
			do{
				$detMenuTopLang_tit=getLangT('tbl_menus_items','men_tit',$dRSmp['men_id'],$_SESSION['lang']);
				//echo $dRSmp['men_id'].'-'.$detMenuTopLang_tit.'<br>';
								
				//Consulta para Submenus
				$qry2 = sprintf("SELECT * FROM tbl_menus_items  
				WHERE tbl_menus_items.men_padre = %s AND tbl_menus_items.men_stat = %s 
				ORDER BY men_orden ASC",
				SSQL($dRSmp['men_id'],'int'),
				SSQL(1,'int'),
				SSQL($_SESSION['lang'],'text'));
				
				$RSmi = mysqli_query($conn,$qry2) or die(mysqli_error($conn));
				$dRSmi = mysqli_fetch_assoc($RSmi);
				$tRSmi = mysqli_num_rows($RSmi);
				
				if($tRSmi>0) $cssSM="dropdown"; 
				else $cssSM="";
				if($dRSmp['men_link']) $link = $GLOBALS['RAIZ'].$dRSmp['men_link'];
				else $link = "#";
				if($dRSmp['men_precode']) $ret.=$dRSmp['men_precode'];
				$cssActive='';
				if($dRSmp['men_nombre']==$active) $cssActive=' active ';
				$ret.='<li id="'.$dRSmp['men_nombre'].$active.'" class="'.$cssSM.$cssActive.' '.$dRSmp['men_css'].'" style="'.$dRSmp['men_sty'].'">';
				if($tRSmi > 0){
					$ret.='<a href="'.$link.'" class="dropdown-toggle"';
					if($tRSmi > 0){ $ret.='data-toggle="dropdown"';
				}
				$ret.='>';
				if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
				$ret.=$detMenuTopLang_tit;
				if($tRSmi > 0){
					$ret.=' <b class="caret"></b>';
				}
				$ret.='</a>';
				$ret.='<ul class="dropdown-menu">';
				do{
					$detMenuSecLang_tit=getLangT('tbl_menus_items','men_tit',$dRSmi['men_id'],$_SESSION['lang']);//TEXT according to language
					if($dRSmi['men_link']){ 
						$link = $GLOBALS['RAIZ'].$dRSmi['men_link'];
					}else{
						$link = "#"; 
					}
					if($dRSmi['men_precode']) $ret.=$dRSmi['men_precode'];
					$ret.='<li><a href="'.$link.'">';
					
					if($dRSmi['men_icon']) $ret.='<i class="'.$dRSmi['men_icon'].'"></i> ';
					//if(!$dRSmi['titv']) $dRSmi['titv']=$dRSmi['men_tit'];
					//$ret.=$dRSmi['titv'].'</a></li>';
					$ret.=$detMenuSecLang_tit.'</a></li>';
					
					
					if($dRSmi['men_postcode']) $ret.=$dRSmi['men_postcode'];
					
				}while($dRSmi = mysqli_fetch_assoc($RSmi));
				mysqli_free_result($RSmi);
				$ret.='</ul>';
			}else{
				$ret.='<a href="'.$link.'">';
				if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
				$ret.=$detMenuTopLang_tit.'</a>';
			}
			$ret.='</li>';
			if($dRSmp['men_postcode']) $ret.=$dRSmp['men_postcode'];
		}while($dRSmp = mysqli_fetch_assoc($RSmp));
		mysqli_free_result($RSmp);
		}else{
			$ret.='<li>No items in menu <strong>'.$refMC.'</strong></li>';
		}
	}else $ret.='<li>No existe menu <strong>'.$refMC.'</strong></li>';
	//Verifica si solicito UL, si no devolveria solo LI
	if($vrfUL) $ret='<ul class="'.$css.'">'.$ret.'</ul>';
	return $ret;
}

function genMenu_old($refMC,$css=NULL,$vrfUL=TRUE, $active=null){//v.3.0
	Global $conn;
	//verifico si el menu existe
	$dMC=detRow('tbl_menus','ref',$refMC);
	if($dMC){
		//Consulta si el usuario es SuperAdmin
		if($_SESSION['dU']['LEVEL']!=0){
			$userJoin=' INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id = tbl_menu_usuario.men_id ';
			$userLevel=' AND tbl_menu_usuario.usr_id ='.$_SESSION['dU']['ID'];
		}
		//Consulta para Menus Principales
		$qry=sprintf("SELECT * FROM tbl_menus_items ".
		$userJoin.
		"INNER JOIN tbl_menus on tbl_menus_items.men_idc=tbl_menus.id 
		WHERE tbl_menus.ref = %s 
		AND tbl_menus_items.men_padre = %s ".
		$userLevel.
		" AND tbl_menus_items.men_stat = %s 
		ORDER BY men_orden ASC",
		SSQL($refMC,'text'),
		SSQL('0','int'),
		SSQL('1','text'));
		
		$RSmp = mysqli_query($conn,$qry) or die(mysqli_error($conn));
		$dRSmp = mysqli_fetch_assoc($RSmp);
		$tRSmp = mysqli_num_rows($RSmp);
		//echo $qry;
		//
		if($tRSmp > 0){
			do{
				$paramsN=NULL;//REINICIAR EL $paramsN siempre ya que si entra a un bucle se almacena y da error
				$paramsN[]=array(
					array("cond"=>"AND","field"=>"idm","comp"=>"=","val"=>$dRSmp['men_id']),
					array("cond"=>"AND","field"=>"lang","comp"=>'=',"val"=>$_SESSION['lang'])
				);
				$detMenuTopLang=detRowNP('tbl_menus_items_txt',$paramsN);
				if($detMenuTopLang){
					$detMenuTopLang_tit=$detMenuTopLang[titv];
				}else{
					$detMenuTopLang_tit=$dRSmp[men_tit];
				}
				if(!$detMenuTopLang_tit) $detMenuTopLang_tit='N/D';
				
				//Consulta para Submenus
				$qry2 = sprintf("SELECT * FROM tbl_menus_items 
				LEFT JOIN tbl_menus_items_txt ON tbl_menus_items.men_id=tbl_menus_items_txt.idm 
				WHERE tbl_menus_items.men_padre = %s AND tbl_menus_items.men_stat = %s 
				ORDER BY men_orden ASC",
				SSQL($dRSmp['men_id'],'int'),
				SSQL(1,'int'),
				SSQL($_SESSION['lang'],'text'));
				
				//echo $qry2.'<br>'.$tRSmi.'<hr>';
				
				$RSmi = mysqli_query($conn,$qry2) or die(mysqli_error($conn));
				$dRSmi = mysqli_fetch_assoc($RSmi);
				$tRSmi = mysqli_num_rows($RSmi);
				
				
				if($tRSmi>0) $cssSM="dropdown"; 
				else $cssSM="";
				if($dRSmp['men_link']) $link = $GLOBALS['RAIZ'].$dRSmp['men_link'];
				else $link = "#";
				if($dRSmp['men_precode']) $ret.=$dRSmp['men_precode'];
				$cssActive='';
				if($dRSmp['men_nombre']==$active) $cssActive=' active ';
				$ret.='<li id="'.$dRSmp['men_nombre'].$active.'" class="'.$cssSM.$cssActive.' '.$dRSmp['men_css'].'" style="'.$dRSmp['men_sty'].'">';
				if($tRSmi > 0){
					$ret.='<a href="'.$link.'" class="dropdown-toggle"';
					if($tRSmi > 0){ $ret.='data-toggle="dropdown"';
				}
				$ret.='>';
				if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
				$ret.=$detMenuTopLang_tit;
				if($tRSmi > 0){
					$ret.=' <b class="caret"></b>';
				}
				$ret.='</a>';
				$ret.='<ul class="dropdown-menu">';
				do{
					if($dRSmi['men_link']){ 
						$link = $GLOBALS['RAIZ'].$dRSmi['men_link'];
					}else{
						$link = "#"; 
					}
					if($dRSmi['men_precode']) $ret.=$dRSmi['men_precode'];
					$ret.='<li><a href="'.$link.'">';
					
					if($dRSmi['men_icon']) $ret.='<i class="'.$dRSmi['men_icon'].'"></i> ';
					if(!$dRSmi['titv']) $dRSmi['titv']=$dRSmi['men_tit'];
					$ret.=$dRSmi['titv'].'</a></li>';
					
					if($dRSmi['men_postcode']) $ret.=$dRSmi['men_postcode'];
					
				}while($dRSmi = mysqli_fetch_assoc($RSmi));
				mysqli_free_result($RSmi);
				$ret.='</ul>';
			}else{
				$ret.='<a href="'.$link.'">';
				if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
				$ret.=$dRSmp['men_tit'].'</a>';
			}
			$ret.='</li>';
			if($dRSmp['men_postcode']) $ret.=$dRSmp['men_postcode'];
		}while($dRSmp = mysqli_fetch_assoc($RSmp));
		mysqli_free_result($RSmp);
		}else{
			$ret.='<li>No items in menu <strong>'.$refMC.'</strong></li>';
		}
	}else $ret.='<li>No existe menu <strong>'.$refMC.'</strong></li>';
	//Verifica si solicito UL, si no devolveria solo LI
	if($vrfUL) $ret='<ul class="'.$css.'">'.$ret.'</ul>';
	return $ret;
}

function getRemoteFile($url, $timeout = 10) {
  $ch = curl_init();
  curl_setopt ($ch, CURLOPT_URL, $url);
  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $file_contents = curl_exec($ch);
  curl_close($ch);
  return ($file_contents) ? $file_contents : FALSE;
}

//////////////////////////
/* BEG COOKIES FUNCTION */
function delCookie($cookieName){
	unset($_COOKIE[$cookieName]);
	setcookie($cookieName, "", time() - (86400 * 30),'/', ".mercoframes.com");
}
function setCookieArray($cookieName,$cookieID,$cookieVal,$cookieIDtoVAL=TRUE,$limitItems=100,$cookieTime=NULL){
	$LOG.= $cookieName.' - ';
	if(($cookieName)&&($cookieID)){
		if(array_key_exists($cookieName, $_COOKIE)) {
			$cookie = unserialize($_COOKIE[$cookieName]);
		} else {
			$cookie = array();
		}
		if($cookieIDtoVAL==TRUE) $cookieVal=$cookieID;
		if($cookie[$cookieID] != $cookieVal){
				$Newcookie[$cookieID] = $cookieVal;
				$cookie=$Newcookie+$cookie;
				$salida = array_slice($cookie, 0, $limitItems,true);   // devuelve "a", "b", y "c"
				$cookie = serialize($salida);
				if(!$cookieTime) $cookieTime=86400*30;
				if(setcookie($cookieName, $cookie, time()+$cookieTime,'/', ".ecuahomes.net")){
					$LOG.='Value. '.$cookieID.' set in Cookie<br>';
				}else $LOG.='Error Value no set in Cookie<br>';
		}else $LOG.='Values for cookie exists, not set*<br>';
	}else $LOG.='No data for Cookie<br>';
	return $LOG;
}

function getCookieArray($cookieName,$limitItems=20){
	if (isset($_COOKIE[$cookieName])){
		$cookie=unserialize($_COOKIE[$cookieName]);
		$cookieFIN = array_slice($cookie, 0, $limitItems,true);
	}
	return $cookieFIN;
}
/* END COOKIES FUNCTION */
//////////////////////////
function sysmsg($msg=NULL, $style=NULL, $action=NULL){
if($action==1){
	$_SESSION['msg']=$msg; $_SESSION['msgc']=$style;
}else{
	if ($_SESSION['msg']){
		echo '<div id="sysmsg" class="alert alert-'.$_SESSION['msgc'].'">'.$_SESSION['msg'].'</div>';
        $_SESSION['msg']=NULL;
	}
}
}

function sLOG($type=NULL, $msg_m=NULL, $msg_t=NULL, $msg_c=NULL, $msg_i=NULL){//v.2.2
	$vrfVL=TRUE; //var para setear $LOG
	if($msg_m){//echo 'set message. ';
		$LOG['m']=$msg_m;
		$LOG['t']=$msg_t;
		$LOG['c']=$msg_c;
		$LOG['i']=$msg_i;
	}else{//echo 'SESSION. ';
		if($_SESSION['LOG']){//echo 'load LOG with SESSION. ';
			$LOG=$_SESSION['LOG'];
			unset($_SESSION['LOG']);
		}//else{//echo 'empty LOG. '; }
	}
	
	if($LOG){
		//if(!$LOG[c]) $ret[c]='a';
		switch ($type){
			case 'a':
				$rLog='<div id="log">';
				$rLog.='<div class="alert alert-dismissable '.$LOG['c'].'" style="margin:10px;">';
				$rLog.='<button type="button" class="close" data-dismiss="alert">&times;</button>';
				if($LOG['t']) $rLog.='<h3>'.$LOG['t'].'</h3>';
				$rLog.=$LOG['m'];
				$rLog.='</div></div>';
			break;
			case 'g':
				$rLog='<script>
				logGritter("'.$LOG['t'].'","'.$LOG['m'].'","'.$LOG['i'].'");
				</script>';
			break;
			case 's':
				$vrfVL=FALSE;
			break;
			default:
				$rLog='<div>'.$LOG['m'].'</div>';
			break;
		}
		echo $rLog;
	}
	/*
	if($vrfVL){//TRUE unset->LOG, FALSE $_SESSION LOG -> $LOG
		unset($_SESSION['LOG']);
	}else{
		$_SESSION['LOG']=$LOG;
	}
	*/
}

function fnc_sysmsg_date($param1,$param2){
	$fechasys=time(); 
	$datenow=date("Y-m-d", $fechasys);//FECHA SISTEMA
	$datestart=$param1; // FECHA INICIA
	$dateend=$param2; // FECHA FINALIZA	
	$f0 = explode("-", $datenow);
	$f1 = explode("-", $datestart);
	$f2 = explode("-", $dateend);
	$timestamp0 = mktime(0,0,0,$f0[1],$f0[2],$f0[0]);
	$timestamp1 = mktime(0,0,0,$f1[1],$f1[2],$f1[0]);
	$timestamp2 = mktime(0,0,0,$f2[1],$f2[2],$f2[0]); 
	$seg_dif_i = $timestamp1-$timestamp0 ;
	$seg_dif_f = $timestamp2-$timestamp0;
	//convierto segundos en días 
	$dia_dif_i = $seg_dif_i / (60 * 60 * 24); 
	$dia_dif_f = $seg_dif_f / (60 * 60 * 24); 
	//obtengo el valor absoulto de los días (quito el posible signo negativo) 
	/*$dia_dif_i = abs($dia_dif_i); 
	$dia_dif_f = abs($dia_dif_f); */
	//quito los decimales a los días de diferencia 
	$dia_dif_i = floor($dia_dif_i); $dia_dif_f = floor($dia_dif_f);
	if(($dia_dif_i>=0)&&($dia_dif_f>=0))return(1); else return(0);
}

function vParam($nompar, $pget, $ppost){
	session_start();
	if(isset($pget)) {$id_ret=$pget;}
	else if (isset($ppost)){$id_ret=$ppost;}
	else $id_ret=$_SESSION[$nompar];
	return $id_ret;
}
//OBTENER IP
function getRealIP(){
   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' ){
      $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            : ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               : "unknown" );
      // los proxys van añadiendo al final de esta cabecera
      // las direcciones ip que van "ocultando". Para localizar la ip real
      // del usuario se comienza a mirar por el principio hasta encontrar
      // una dirección ip que no sea del rango privado. En caso de no
      // encontrarse ninguna se toma como valor el REMOTE_ADDR
      $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);
      reset($entries);
      while (list(, $entry) = each($entries)){
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list)){
            // http://www.faqs.org/rfcs/rfc1918.html
            $private_ip = array(
                  '/^0\./',
                  '/^127\.0\.0\.1/',
                  '/^192\.168\..*/',
                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                  '/^10\..*/');
            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
            if ($client_ip != $found_ip){ $client_ip = $found_ip; break;
            }
         }
      }
   }else{
      $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            : ((!empty($_ENV['REMOTE_ADDR'])) ?
               $_ENV['REMOTE_ADDR']
               : "unknown" );
   }
   return $client_ip;
}

function vImg($ruta,$nombre,$thumb=TRUE,$pthumb='t_',$retHtml=FALSE){//v1.5
	//$ruta. Ruta o subcarpeta definida dentro de la RAIZi (carpeta de imagenes)
	//$nombre. Nombre del Archivo
	//$thumb. TRUE o FALSE en caso de querer recuperar thumb
	//$pthumb PREFIJO de Thumb
	//echo RAIZ.$ruta.$nombre;
	$imgRet['n']=$GLOBALS['RAIZa'].'img/struct/no_image.jpg';
	$imgRet['t']=$imgRet['n'];
	$imgRet['s']=FALSE;//Verify if file exist is default FALSE
	$imgRet['r']=$ruta.$nombre;//Verify if file exist is default FALSE
	if($nombre){
		//echo '<hr>RAIZ0. '.RAIZ0.$ruta.$nombre;
		//echo '<hr>$RAIZ0. '.$RAIZ.$ruta.$nombre;
		if (file_exists(RAIZ.$ruta.$nombre)){
			$imgRet['s']=TRUE;//FILE EXIST RETURN TRUE AND ALL DATA (link normal, link thumb, file name original)
			$imgRet['f']=$nombre;
			$imgRet['n']=$GLOBALS['RAIZ'].$ruta.$nombre;
			$imgRet['t']=$imgRet['n'];
			if ($thumb==TRUE){
				if (file_exists(RAIZ.$ruta.$pthumb.$nombre)){
					$imgRet['t']=$GLOBALS['RAIZ'].$ruta.$pthumb.$nombre;
				}
			}
		}
	}
	//Direct Return HTML Code *********** TERMINAR ESTE CODIGO
	if($retHtml){
		foreach($retHtml as $key => $valor){
			if($key!='tip') $paramCode=' '.$key.' = '.'"'.$valor.'"';
		}
		switch($retHtml['tip']){
			case 'imgn':
				$imgRet['code']='<img src="'.$imgRet['n'].'" '.$paramCode.'>';
			break;
			case 'imgt':
				$imgRet['code']='<img src="'.$imgRet['t'].'" '.$paramCode.'>';
			break;
			case 'aimg':
				$imgRet['code']='<a href="'.$imgRet['n'].'" '.$paramCode.'><img src="'.$imgRet['t'].'"></a>';
			break;
		}
		
	}
	return $imgRet;
}

function getCurlData($url){
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
	$curlData = curl_exec($curl);
	curl_close($curl);
	return $curlData;
}
if (!function_exists("SSQL")) {//v.2.0 -> duotics_lib
function SSQL($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
  Global $conn;
  if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($conn, $theValue) : mysqli_real_escape_string($conn, $theValue);
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>