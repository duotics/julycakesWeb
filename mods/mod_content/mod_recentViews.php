<?php $contViewItemsRV=12;
$spanItemsRV=12/$contViewItemsRV;
$cookieView=getCookieArray('recViews',$contViewItemsRV);
?>

<div class="row m0 widgetS">
	<h4>You Recent View Items</h4>
	<?php if($cookieView){ ?>
		<div class="row">
			<?php foreach ($cookieView as $name => $value){ ?>
			<?php
				$qryTP1 = sprintf("SELECT tbl_items.item_id as i_id, tbl_items.item_cod as i_cod, tbl_items.item_nom as i_nom, tbl_items.item_aliasurl as i_url, tbl_items.item_img as i_img, tbl_items_brands.name as b_nom, tbl_items_brands.url as b_url, tbl_items_brands.img as b_img FROM tbl_items 
				INNER JOIN tbl_items_brands ON tbl_items.brand_id=tbl_items_brands.id 
				WHERE tbl_items.item_status=1 AND tbl_items.item_id=%s
				ORDER BY item_hits DESC",
								 SSQL($name,'int'));
				$RSrv1 = mysqli_query($conn,$qryTP1) or die(mysqli_error($qryTP1));
				$dRSrv1 = mysqli_fetch_assoc($RSrv1);
				$linkd=$RAIZ.'p/'.$dRSrv1['b_url'].'/'.$dRSrv1['i_url'];
				$item_img=vImg('data/img/item/',$dRSrv1['i_img'],TRUE,'_t');
			?>
			<?php if($dRSrv1){ ?>
			<div class="colItems col-xs-3 col-md-<?php echo $spanItemsRV ?> nopadding" data-toggle="tooltip" data-placement="top" title="<?php echo $dRSrv1['i_nom'] ?>">
				<a href="<?php echo $linkd ?>" class="thumbnail" style="margin:1px">
					<img src="<?php echo $item_img['t'] ?>" alt="<?php echo $dRSrv1['i_cod'] ?>">
				</a>
			</div>
			<?php } ?>
			<?php } ?>
			</div>
		<?php mysqli_free_result($RSrv1);?>
		<?php } ?>
</div>