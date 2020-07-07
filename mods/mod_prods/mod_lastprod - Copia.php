<?php
$numItemsRow=4;
$limI=12;
$qryRSlp1 = "SELECT db_items.item_id as i_id, db_items.item_cod as i_cod, db_items.item_aliasurl as i_url, db_items.item_img as i_img, db_items_brands.name as b_nom, db_items_brands.url as b_url, db_items_brands.img as b_img FROM db_items 
LEFT JOIN db_items_brands ON db_items.brand_id=db_items_brands.id 
WHERE db_items.item_status=1 
ORDER BY item_id DESC LIMIT 0,".$limI;
$RSlp1 = mysqli_query($conn,$qryRSlp1) or die(mysqli_error());
$dRSlp1 = mysqli_fetch_assoc($RSlp1);
$tRSlp1 = mysqli_num_rows($RSlp1);
$tRSlp1_slides=$tRSlp1/$numItemsRow;
?>
<div class="panel panel-default panel-steel">
  <div class="panel-heading"><?php echo $lang['gen']['mod-lastp'] ?></div>
  <div class="panel-body">

    <div id="carLastProd01" class="carousel slide carousel-topProd" data-ride="carousel">
  <!-- Wrapper for slides -->
		<div class="carousel-inner">
			<div class="item active">
				<div class="row">
				<?php $contI=0; $contT=0 ?>
				<?php do{ ?>
				<?php $linkd1=$RAIZ.'p/'.$dRSlp1['b_url'].'/'.$dRSlp1['i_url'] ?>
				<div class="col-xs-12 col-sm-3">
				<a href="<?php echo $linkd1 ?>" class="thumbnail" style="margin:1px">
				<img src="<?php echo $RAIZd."img/item/t_".$dRSlp1['i_img']; ?>" alt="<?php echo $dRSlp1['i_nom']; ?>" style="max-height:60px; min-height:60px;">
				<div class="caption text-center" style="min-height:60px"><small><?php echo $dRSlp1['i_cod']; ?></small></div>
				</a>
				</div>
				<?php
				$contI++;
				$contT++;
				if(($contI==4)&&($contT<$limI)){
				echo "</div></div><div class='item'><div class='row'>";
				$contI=0; 
				}
				?>
				<?php } while ($dRSlp1 = mysqli_fetch_assoc($RSlp1)); ?>
				</div>
			</div>
		</div>
		
		<ol class="carousel-indicators">
		<?php for($x=0;$x<$tRSlp1_slides;$x++){ ?>
		<?php
		if($x==0) $tempCssCarousel='active';
		else $tempCssCarousel='';
		?>
			<li data-target="#carLastProd01" data-slide-to="<?php echo $x ?>" class="<?php echo $tempCssCarousel ?>"></li>
		<?php } ?>
		</ol>
		
</div>
  </div>
</div>
<?php mysqli_free_result($RSlp1) ?>
<script>
$('#carLastProd01').carousel({ interval: 6000 })
</script>