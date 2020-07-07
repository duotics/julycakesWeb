<?php $c_url=vParam('c_url', $_GET['c_url'], $_POST['c_url']); //parametro enviado es el URL de db_items_type
$b_url=vParam('b_url', $_GET['b_url'], $_POST['b_url']); //parametro enviado es el URL de db_items_type
$sort=vParam('s', $_GET['s'], $_POST['s']); //parametro enviado es el URL de db_items_type
//Verifico si existe el parametro muestro la categoria si no muestro el root
if(!$c_url){
	$tView='2';
	$idc=0;
	$vTit=FALSE;
	$det['typEst']='1'; 
}else{
	$det=detRow('db_items_type','typUrl',$c_url);
	$idc=$det['typID'];
	$det_nom=$det['typNom'];
	$tView=$det['typ_id'];
	$vTit=TRUE;
}
//echo 'typEst. '.$det['typEst'];
if($det['typEst']=='1'){
	$isView=TRUE;
}else{
	$isView=FALSE;
}
?>
<?php if(($idc>=0)&&($isView==TRUE)){ ?>
<?php echo genBreadcrumb('cat',$idc) ?>
<div class="card mb-4">
	<div class="card-body">
		
	<?php if($vTit==TRUE){ ?>
	<h1 class="card-title" id="c_<?php echo $idc ?>"><?php echo $det_nom?></h1>
	<?php if($det['typDes']){ echo $det['typDes']; }?>
	<?php } ?>
		
	<div class="cont-catalog">
	<!-- VISTA U-CONST --><?php if ($tView=="1"){ include("_cat_viewUC.php"); } ?>
	<!-- VISTA CATALOGO --><?php if ($tView=="2"){ include("_cat_viewCat.php"); } ?>
	<!-- VISTA CATALOGO --><?php if ($tView=="3"){ include("_cat_viewExt.php"); } ?>
	<!-- VISTA CODEembed --><?php if ($tView=="4"){ include("_cat_viewCode.php"); } ?>
	</div>
	<div style="clear:both;"></div>


		<div><?php btnBackCat($det['typIDp']) ?></div>
	</div>
</div>
<?php }else{ ?>

<div>
	<div class="alert alert-warning">
    	<h4>Categoría no válida</h4>
    </div>
    <div class="well well-sm"><?php btnBackCat($det['typIDp']); ?></div>
</div>
<?php } ?>