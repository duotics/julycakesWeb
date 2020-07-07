<?php //LIST ARTICLES CATEGORIES
$qryLAC=sprintf('SELECT db_items_type.typUrl AS t_url, db_items_type.typID AS t_id, db_items_type.typNom AS t_nom 
FROM db_items_type 
WHERE typEst=1 AND typIDp=1
ORDER BY typHits ASC');
$RSlac=mysqli_query($conn,$qryLAC) or die(mysqli_error($conn));
$dRSlac=mysqli_fetch_assoc($RSlac);
$trRSlac=mysqli_num_rows($RSlac);
?>
<div class="row m0 recentPostWidget widgetS">
	<h4>Catalog of products</h4>
	<div class="media recentblog">
		<?php if($trRSlac>0){ ?>
		<?php do{ ?>
		<div class="media recentblog">
			<div class="media-body">
				<a href="<?php echo $RAIZ.'c/'.$dRSlac['t_url'] ?>" id="<?php echo $dRSlac['t_id'] ?>">
					<h5 class="media-heading"><?php echo $dRSlac['t_nom'] ?></h5>
				</a>
			</div>
		</div>
		<?php }while($dRSlac=mysqli_fetch_assoc($RSlac)); ?>
		<?php }else{ ?>
		<li class="list-group-item">Not Found Categories !</li>
		<?php } ?>
	</div>
</div>

<?php //LIST RECENT POSTS

$qryLAR = sprintf("SELECT db_items.item_id AS i_id, db_items.item_nom AS i_nom, db_items.item_img AS i_img, db_items.item_aliasurl AS i_url, db_items.item_hits AS i_hits, db_items.item_date as i_date  
FROM db_items_type_vs 
INNER JOIN db_items ON db_items_type_vs.item_id=db_items.item_id 
WHERE typID=(select typID FROM db_items_type_vs WHERE item_id=%s) 
AND db_items_type_vs.item_id<>%s 
ORDER BY i_hits DESC LIMIT 8",
						 SSQL($idI, "int"),
						 SSQL($idI, "int"));
$RSlar = mysqli_query($conn,$qryLAR) or die(mysqli_error($conn));
$dRSlar = mysqli_fetch_assoc($RSlar);
$trRSlar = mysqli_num_rows($RSlar);

?>

<div class="row m0 recentPostWidget widgetS">
	<h4>Related Items</h4>
	<div class="row m0 recentblogs">
		 <?php if($trRSlar>0){ ?>
		<?php do{ ?>
		<?php 
		$vImgPC=vImg('data/db/prods/',$dRSlar['i_img']);
		$linkPC=$RAIZ.'p/related/'.$dRSlar['i_url'];
		 ?>
		<div class="media recentblog">
			<div class="media-left">
				<a href="<?php echo $linkPC ?>">
					<img class="media-object img-fluid" src="<?php echo $vImgPC[t] ?>" alt="">
				</a>
			</div>
			<div class="media-body">
				<a href="<?php echo $linkPC ?>">
					<h5 class="media-heading"><?php echo $dRSlar['i_nom'] ?></h5>
					<span class="label label-default">Create • <?php echo $dRSlar['i_date'] ?></span>
				</a>
			</div>
		</div>
		<?php }while($dRSlar=mysqli_fetch_assoc($RSlar)); ?>
		<?php }else{ ?>
		<p>Not Found Articles!</p>
		<?php } ?>
	</div>
</div>

<div class="row m0 contactWidget widgetS">
	<h4>Contact us</h4>
	<ul class="list-unstyled">
		<li><i class="fa fa-phone"></i> 713-293-2735</li>
		<li><i class="fa fa-envelope"></i> info@ecuahomes.net</li>
		<li><i class="fa fa-home"></i> 10301 Northwest Freeway Suite # 401 Houston Texas 77092</li>
	</ul>
</div>

<?php mysqli_free_result($RSlac);
mysqli_free_result($RSlar); ?>