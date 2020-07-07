<?php
$item=vparam('item', $_GET['item'], $_POST['item']);
$qry=sprintf('SELECT db_items.item_id AS i_id, db_items.item_aliasurl AS i_url, db_items.item_cod AS i_cod, db_items.item_nom AS i_nom, db_items.item_ref AS i_ref, db_items.item_des AS i_des, db_items.item_spec AS i_spec, db_items.item_date AS i_date, db_items.item_img AS i_img, db_items.item_hits AS i_hit, db_items.item_status AS i_stat, 
db_items_brands.id as b_id, db_items_brands.url AS b_url, db_items_brands.name AS b_nom, db_items_brands.img as b_img, db_items_brands.vimg as b_vimg, db_items_brands.status as b_stat, 
db_items_type.typID AS c_id, db_items_type.typNom AS c_nom, db_items_type.typUrl AS c_url, db_items_type.typImg AS c_img
FROM `db_items` 
LEFT JOIN db_items_brands ON db_items.brand_id=db_items_brands.id
LEFT JOIN db_items_type_vs ON db_items.item_id=db_items_type_vs.item_id 
LEFT JOIN db_items_type ON db_items_type_vs.typID=db_items_type.typID 
WHERE db_items.item_aliasurl=%s',
SSQL($item,'text'));
$RS=mysqli_query($conn,$qry) or die (mysqli_error($conn));
$dRS=mysqli_fetch_assoc($RS);
?>
<div>
<?php
if($dRS){//Verify Item Exists
	$idI=$dRS['i_id'];
	seoGoogleMetas($dRS['i_nom']." - ".$dRS['b_nom']);
	updHits('db_items','item_hits','item_id',$dRS['i_id']);
	//BEG Verivy VIEW item (brand and category)
	if($dRS['i_stat']=='1'){
		if(($dRS['b_id'])){
			if($dRS['b_stat']==1) $vV=TRUE;
		}else $vV=TRUE;
	}//BEG Verivy VIEW
	if ($vV){//Verify item.status and brand.status
		$vImg=vImg('data/db/prods/',$dRS['i_img'],TRUE,'_t');
		$vImgC=vImg('data/db/cats/cat/',$dRS['c_img'],TRUE,'_t');
		if($vImgC['s']) $styCover='style="background: url('.$vImgC['n'].');"';
?>
<meta property="og:image" content="<?php echo $vImg['n'] ?>" />
<section id="pageCover" class="row projectProd" <?php echo $styCover ?>>
<div class="wrapper pageCover-a">
	<div class="row pageTitle"><?php echo $dRS['i_nom'] ?> <small><?php echo $dRS['i_ref'] ?></small></div>
	<div class="row pageBreadcrumbs">
		<?php echo genBrdc('item',$dRS['i_id']) ?>
	</div>
</div>
</section>
	
<div class="container-fluid">
	<div class="row">
	<div class="col-sm-9" style="background: #fff">
	<div id="<?php echo $idI ?>">
    	<h1>
		<?php if($dRS['b_vimg']){ ?>
		<div class="pull-right v-item-brand">
        	<a href="<?php echo $RAIZ?>brand/<?php echo $dRS['b_url']?>">
            <img src="<?php echo $RAIZi?>brand/<?php echo $dRS['b_img']?>" style="max-height:50px;" class="img-thumbnail"/>
            </a>
		</div>
		<?php } ?>
		<?php echo $dRS['i_nom']; ?> <small><?php echo $dRS['i_ref']; ?></small> 
        </h1>
	</div>
	<div class="row">
    	<div class="col-sm-8">
        <a href="<?php echo $vImg['n'] ?>" class="fancybox" rel="fancybox-thumb">
            <img src="<?php echo $vImg['n'] ?>" alt="<?php echo $dRS['i_id'] ?>" class="img-fluid"/>
		</a>
        </div>
        <div class="col-sm-4">
			<table class="table table-vtools">
				<?php if(vrfNew($dRS['i_date'],120)){ ?>
				<tr>
					<td colspan="2"><span class="label label-warning"><i class="fa fa-star"></i> New Product</span></td>
				</tr>
				<?php } ?>
				<tr>
					<td><i class="fa fa-tag fa-fw"></i> Category</td>
					<td><a href=""><strong><?php echo $dRS['c_nom'] ?></a></td>
				</tr>
				<tr>
					<td><i class="fa fa-calendar fa-fw"></i> Date</td>
					<td><?php echo date("m/d/Y", strtotime($dRS['a_date'])) ?></td>
				</tr>
				<tr>
					<td><i class="fa fa-eye fa-fw"></i> Views</td>
					<td><?php echo $dRS['i_hit'] ?></td>
				</tr>
				<tr>
					<td colspan="2"><a href="#secCont" class="btn btn-Ygen"><i class="fa fa-envelope"></i> GET A QUOTE</a></td>
				</tr>
			</table>
        </div>
        
    </div>
    <div class="contProd">
		<?php if ($dRS['i_des']){ ?>
		<div class="contProd-des"><?php echo $dRS['i_des']; ?></div>
		<?php } ?>
		<?php if ($dRS['i_spec']){ ?>
		<div class="contProd-esp"><?php echo $dRS['i_spec']; ?></div>
		<?php } ?>
	</div>
	<div class="v-itools-sel">
		<div class="v-itools-sel-tit">
			<div class="btn btn-default btn-xs disabled"><i class="fa fa-share-alt"></i> Share</div>
		</div>
	<div class="text-center"><?php include(RAIZm."mod_social/mod02.php") ?></div>
	</div>
    <div id="attach"><?php include(RAIZm.'mod_attach/mod.php') ?></div>
    <div id="video"><?php include(RAIZm.'mod_vids/mod.php') ?></div>
    <div id="media"><?php include(RAIZm.'mod_media/mod.php') ?></div>
	<div id="gallery"><?php include(RAIZm.'mod_gallery/mod.php'); modGall($idI,'ITEM') ?></div>
    <div id="secCont"><?php include(RAIZm.'mod_contact/mod_contProd2.php') ?></div>
	<div class="row m0 widgetS" style="margin: 40px 0;">
		<a href="<?php echo $RAIZ?>c/<?php echo $dRS['c_url']; ?>">
			<i class="fas fa-chevron-left"></i> Go back to <strong><?php echo $dRS["c_nom"]; ?></strong>
		</a>
	</div>
	<div><?php include(RAIZm.'mod_prods/mod_lastprod.php') ?></div>
	<div><?php include(RAIZm.'mod_prods/mod_topprod.php') ?></div>
	</div>
	<div class="col-sm-3"><?php include(RAIZf.'rightInv.php');?></div>
	</div>
</div>

<script>
	//SETEO LA COOKIE CON JS
	$.post("<?php echo $RAIZs ?>functions/cookie.php", { cookieName: "recViews", cookieID: "<?php echo $dRS['i_id'] ?>", cookieNum:20 }, 
	function(data){
		console.log(data.LOG);
	}, "json");
</script>
<?php }else include(RAIZm.'mod_static/mod-404-disabled.php'); ?>
<?php }else include(RAIZm.'mod_static/mod-404.php');?>
	<div class="container-fluid">
		<div><?php include(RAIZm."mod_content/mod_recentViews.php")?></div>
	</div>
</div>
<?php mysqli_free_result($RS) ?>