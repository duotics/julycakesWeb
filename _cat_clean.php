<?php $c_url=vParam('c_url', $_GET['c_url'], $_POST['c_url']); //parametro enviado es el URL de db_items_type
$b_url=vParam('b_url', $_GET['b_url'], $_POST['b_url']); //parametro enviado es el URL de db_items_type
$sort=vParam('s', $_GET['s'], $_POST['s']); //parametro enviado es el URL de db_items_type
//Verifico si existe el parametro muestro la categoria si no muestro el root
$isView=TRUE;
if(!$c_url){
	$tView='2';
	$idc=1;
	$vTit=FALSE;
}else{
	$det=detRow('db_items_type','typUrl',$c_url);
	$idc=$det['typID'];
	$det_nom=$det['typNom'];
	$tView=$det['typ_id'];
	$vTit=TRUE;
}
/*
echo 'c_url. *'.$c_url.'*'.'<br>';
echo 'b_url. *'.$b_url.'*'.'<br>';
echo 's. *'.$s.'*'.'<br>';
*/
?>
<?php if(($idc)&&($isView==TRUE)){ ?>
<div class="well contGen">
<?php if($vTit==TRUE){ ?>
<div id="dcat_head">
<div id="dcat_tit">
<h1 id="c_<?php echo $idc ?>"><?php echo $det_nom?></h1>
</div>
</div>
<?php } ?>
<div class="cont-catalog">
	<?php include("_cat_viewCatClean.php"); ?>
</div>
<div style="clear:both;"></div>
<?php }else{ ?>

<div>
	<div class="alert alert-warning">
    	<h4>Category unavailable</h4>
    </div>
</div>
<?php } ?>