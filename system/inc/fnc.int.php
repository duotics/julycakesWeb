<?php
function genMenPri($det){
	$detT=detRow('tbl_types','typ_cod',$det['typ_id']);
	//Geenero el menú segun el Type
	switch ($detT['typ_nom']) {
	case "catalog":
		if($det['typUrl']){
			$mLink=$GLOBALS['RAIZ'].'c/'.$det['typUrl'];
		}else $mLink='#';
		break;
	case "external":
		if($det['typDes']){
			$mLink=$det['typDes'];
			$mOpt=' target="_blank" ';
		}else $mLink='#';
		break;
	case "under construction":
		$mLink='#';
		$mOpt=' id="btnUC" ';
		break;
	}
	$ret='<a href="'.$mLink.'"'.$mOpt.'>'.strtoupper($det['typNom']).'</a>';
	return ($ret);
}
function genBrand($det){
	//Geenero el menú segun el Type
	$mLink=$GLOBALS['RAIZ'].'brand/'.$det['url'];
	$ret='<a href="'.$mLink.'">'.strtoupper($det['name']).'</a>';
	echo $ret;
}
function genBrandI($det){
	//Geenero el menú segun el Type
	$mLink=$GLOBALS['RAIZ'].'brand/'.$det['url'];
	$ret.='<a href="'.$mLink.'" class="text-center">';
	$ret.='<img src="'.$GLOBALS['RAIZi'].'brand/t_'.$det['img'].'" style="max-height:80px;"/>';
	$ret.='</a>';
	echo $ret;
}

?>