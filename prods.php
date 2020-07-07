<?php include('init.php');
$item=$_GET['item'];
$dP=detRow('db_items','item_aliasurl',$item);
$dCP=detRow('db_items_type_vs','item_id',$dP['item_id']);
$dC=detRow('db_items_type','typID',$dCP['typID']);
if(!$dC['typUrl']) $dC['typUrl']='old';
if(!$dP['item_aliasurl']) $dP['item_aliasurl']='null';
$urlR=$RAIZ.'p/'.$dC['typUrl'].'/'.$dP['item_aliasurl'];
//echo $urlR;
header('Location: '.$urlR);
/*
include(RAIZf."head.php");
include(RAIZm.'mod_navbar/mod.php') ?>
<div class="container">
	<div class="row">
		<div class="col-sm-9">
            <div><?php include('c_prods.php'); ?></div>
            <div><?php include(RAIZf.'bottom.php'); ?></div>
		</div>
        <div class="col-sm-3">
			<?php include(RAIZf.'right.php');?>
            <?php include(RAIZm.'mod_prods/mod_topprod_lat.php');?>
		</div>
	</div>
</div>
<?php include(RAIZm.'mod_navbarb/mod.php') ?>
<?php include(RAIZf.'foot.php')
*/
?>