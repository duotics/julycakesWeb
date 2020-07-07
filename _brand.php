<?php //PARAMS
$b_url=vParam('b_url', $_GET['b_url'], $_POST['b_url']); //parametro enviado es el URL de db_items_type
$sort=vParam('s', $_GET['s'], $_POST['s']); //parametro enviado es el URL de db_items_type
//Verifico si existe el parametro muestro la categoria si no muestro el root
if($b_url){
	$vTit=TRUE;
	$bView='vb';
	$detB=detRow('db_items_brands','url',$b_url);
	$detB_nom=$detB['name'];
	$detB_img=fnc_image_exist($RAIZ,'images/brand/',$detB['img']);
	$idb=$detB['id'];
	seoGoogleMetas($detB_nom);
}else{
	$vTit=FALSE;
	$bView='vlb';
	$tView='2';
	$detB['status']='1';
	seoGoogleMetas('BRANDS - Mercoframes Optical Corp');
}
//var_dump($detB);
?>
<?php if(($detB) && ($detB['status']=='1')){ ?>
<?php updBrandhits($detB['id']); ?>
<div class="well contGen">
<ol class="breadcrumb">
	<li><a href="#">Home</a></li>
	<li><a href="<?php echo $RAIZ?>brand/">Brands</a></li>
    <li><a href="<?php echo $RAIZ?>brand/<?php echo $detB['url']?>"><?php echo $detB['name']?></a></li>
</ol>
<?php if($vTit==TRUE){ ?>
<div class="dbrand-head"> 
	<div class="dbrand-img pull-right">
			<img src="<?php echo $detB_img['t'] ?>" class="img-thumbnail"/>
	</div>
    <div class="dbrand-tit">
			<a href="http://www.mercoframes.net/blog" class="bcont-titm pull-left">BRAND</a>
            <h1 id="c_<?php echo $idb ?>">
			<?php echo $detB['name']?></h1>
	</div>
</div>
<div class="dbrand-des"><?php echo $detB['data']?></div>
<?php } ?>
<div class="cont-catalog-brand">
<!-- vlb -> VISTA LISTA BRANDS -->
<?php if ($bView=="vlb"){ include("_brand_viewLB.php"); } ?>
<!-- vc -> VISTA CATALOGO -->
<?php if ($bView=="vb"){ include("_brand_viewB.php"); } ?>
</div>

<div style="clear:both;"></div>

<div id="attach"><?php include(RAIZm.'mod_attach/mod_att_brand.php') ?></div>

</div>
<?php }else{ ?>
	<div class="alert alert-warning">
    	<h4>This section is not available.</h4>
        <a class="btn btn-primary" href="<?php echo $RAIZ ?>">Return to Homepage</a>
    </div>
<?php } ?>