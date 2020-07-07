<?php $numItemsRow=4;
$limI=16;
$numSlides=$limI/$numItemsRow;
$spanSlides=12/$numSlides;
//ANOTHER CAROUSEL
$qryTP1 = "SELECT db_items.item_id as i_id, db_items.item_cod as i_cod, db_items.item_aliasurl as i_url, db_items.item_img as i_img, db_items_brands.name as b_nom, db_items_brands.url as b_url, db_items_brands.img as b_img FROM db_items 
INNER JOIN db_items_brands ON db_items.brand_id=db_items_brands.id 
WHERE db_items.item_status=1 AND db_items_brands.status=1
ORDER BY item_hits DESC LIMIT 0,".$limI;
$RStp1 = mysqli_query($conn,$qryTP1) or die(mysqli_error($conn));
$dRStp1 = mysqli_fetch_assoc($RStp1);
$tRStp1 = mysqli_num_rows($RStp1);
$tRStp1_slides=$tRStp1/$numItemsRow;
//ANOTHER CAROUSEL
$qryTP2 = "SELECT db_items.item_id as i_id, db_items.item_cod as i_cod, db_items.item_aliasurl as i_url, db_items.item_img as i_img, db_items_brands.name as b_nom, db_items_brands.url as b_url, db_items_brands.img as b_img FROM db_items 
INNER JOIN db_items_brands ON db_items.brand_id=db_items_brands.id 
WHERE db_items.item_status=1 AND db_items_brands.status=1 
ORDER BY item_hits DESC LIMIT ".$limI.','.$limI;
$RStp2 = mysqli_query($conn,$qryTP2) or die(mysqli_error($conn));
$dRStp2 = mysqli_fetch_assoc($RStp2);
$tRStp2 = mysqli_num_rows($RStp2);
$tRStp2_slides=$tRStp2/$numItemsRow;
?>
<div class="panel panel-default panel-steel">
	<div class="panel-heading"><?php echo $lang['gen']['mod-featp'] ?></div>
	<div class="panel-body">
		<div id="carTopProd01" class="carousel slide carousel-topProd" data-ride="carousel">
		  <!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
			<?php
			$contI=0; $contT=0;
			do{
				$dat=$dRStp1;//CAMPO A CAMBIAR SEGUN EL RS RESPECTIVOS
				if($contT==0) $cssItem='active';
				else $cssItem='';
				if($contI==0){ 
				echo '<div class="item '.$cssItem.'"><div class="row">';
				} 

				$linkd=$RAIZ.'p/'.$dat['b_url'].'/'.$dat['i_url'];
			?>
			<div class="colItems col-xs-6 col-md-<?php echo $spanSlides ?>">
				<a href="<?php echo $linkd ?>" class="thumbnail" style="margin:1px">
					<img src="<?php echo $RAIZi."items/t_".$dat['i_img']; ?>" alt="<?php echo $dat['i_nom']; ?>" style="max-height:100px; min-height:100px;">
					<div class="caption text-center"><small><?php echo $dat['i_cod']; ?></small></div>
				</a>
			</div>
			<?php 
				if($contI==$numItemsRow-1){ 
					$contI=0;
					echo '</div></div>';
				}else $contI++;
				$contT++;
			}while($dRStp1 = mysqli_fetch_assoc($RStp1)); ?>
			</div>
			
			<ol class="carousel-indicators">
			<?php for($x=0;$x<$tRStp1_slides;$x++){ ?>
			<?php
			if($x==0) $tempCssCarousel='active';
			else $tempCssCarousel='';
			?>
			<li data-target="#carTopProd01" data-slide-to="<?php echo $x ?>" class="<?php echo $tempCssCarousel ?>"></li>
			<?php } ?>
			</ol>
		</div>
		<!-- ANOTHER CAROUSEL -->
		<div id="carTopProd02" class="carousel slide carousel-topProd hidden-xs" data-ride="carousel">
			
		  <!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
			<?php
			$contI=0; $contT=0;
			do{
				$dat=$dRStp2;//CAMPO A CAMBIAR SEGUN EL RS RESPECTIVOS
				if($contT==0) $cssItem='active';
				else $cssItem='';
				if($contI==0){ 
				echo '<div class="item '.$cssItem.'"><div class="row">';
				} 

				$linkd=$RAIZ.'p/'.$dat['b_url'].'/'.$dat['i_url'];
			?>
			<div class="colItems col-xs-6 col-md-<?php echo $spanSlides ?>">
				<a href="<?php echo $linkd ?>" class="thumbnail" style="margin:1px">
					<img src="<?php echo $RAIZi."items/t_".$dat['i_img']; ?>" alt="<?php echo $dat['i_nom']; ?>" style="max-height:100px; min-height:100px;">
					<div class="caption text-center"><small><?php echo $dat['i_cod']; ?></small></div>
				</a>
			</div>
			<?php 
				if($contI==$numItemsRow-1){ 
					$contI=0;
					echo '</div></div>';
				}else $contI++;
				$contT++;
			}while($dRStp2 = mysqli_fetch_assoc($RStp2));//CAMBIAR SEGUN EL RS seleccionado ?>
			</div>
			
			<ol class="carousel-indicators">
				<?php for($x=0;$x<$tRStp2_slides;$x++){ ?>
				<?php
				if($x==0) $tempCssCarousel='active';
				else $tempCssCarousel='';
				?>
				<li data-target="#carTopProd02" data-slide-to="<?php echo $x ?>" class="<?php echo $tempCssCarousel ?>"></li>
				<?php } ?>
			</ol>
		</div>
	</div>
</div>
<?php mysqli_free_result($RStp1); 
mysqli_free_result($RStp2); ?>
<script>
$('#carTopProd01').carousel({ interval: 6000 })
$('#carTopProd02').carousel({ interval: 6000 })
</script>