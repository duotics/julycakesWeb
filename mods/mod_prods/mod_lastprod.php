<?php
$numItemsRow=6;
$limI=12;
$qLP1 = "SELECT db_items.item_id as i_id, db_items.item_cod as i_cod, db_items.item_aliasurl as i_url, db_items.item_img as i_img, db_items_brands.name as b_nom, db_items_brands.url as b_url, db_items_brands.img as b_img, 
db_items.item_price AS i_pri, db_items.item_price2 AS i_pri2 
FROM db_items 
INNER JOIN db_items_brands ON db_items.brand_id=db_items_brands.id 
WHERE db_items.item_status=1 
ORDER BY item_id DESC LIMIT 0,".$limI;
$RSlp1 = mysqli_query($conn,$qLP1) or die(mysqli_error($conn));
$dRSlp1 = mysqli_fetch_assoc($RSlp1);
$tRSlp1 = mysqli_num_rows($RSlp1);
$tRSlp1_slides=$tRSlp1/$numItemsRow;
?>

<div class="card card-default border-primary">
	<div class="card-header bg-transparent border-primary text-primary">Nuevos Productos 
		<div class="float-right"><a href="<?php echo $RAIZ ?>nuevos" class="badge badge-primary">Ver más</a></div>
	</div>
	<div class="card-body">
			<div id="car-lp" class="carousel carousel-cb  slide" data-ride="carousel">
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">
				<div class="carousel-item active">
				  <div class="card-group">
				<?php $contI=0; $contT=0; ?>
				<?php do{ ?>
				<?php 
					$pri=$dRSlp1['i_pri'];
					$pri2=$dRSlp1['i_pri2'];
					if($pri2){
						$det_price="<div style='color:#666; text-decoration:line-through;'>Normal: $".number_format($pri,2,',','.')."</div>";
						$det_price.="<div class='vmod-item-pri text-center'>Final: $".number_format($pri2,2,',','.')."</div>";
					}else{
						$det_price='<div class="vmod-item-pri text-center">Final: $'.number_format($pri,2,',','.').'</div>';
					}
					
					$linkd1=$RAIZ.'p/'.$dRSlp1['b_url'].'/'.$dRSlp1['i_url'];
					$item_img=vImg('data/images/prods/',$dRSlp1['i_img'],TRUE,'t_');
				?>
					  
					<div class="card border-white">
				<a href="<?php echo $linkd1 ?>">
				  <div class="cont-img-card-prod text-center">
					  <img src="<?php echo $item_img[t] ?>" alt="<?php echo $dRSlp1['i_nom']; ?>" class="img-card-prod">
					</div>
				  <div class="card-body">
				  	<div class="text-center"><small class="badge badge-light"><?php echo $dRSlp1['b_nom'] ?></small></div>
					  <div><?php echo $dRSlp1['i_cod']; ?></div>
				  	<div><?php echo $det_price ?></div>
				  </div>
				</a>
			  </div>
						
				<?php
				$contI++;
				$contT++;
				if(($contI==6)&&($contT<$limI)){
					echo "</div></div><div class='carousel-item'><div class='card-group'>";
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
					<li data-target="#car-lp" data-slide-to="<?php echo $x ?>" class="<?php echo $tempCssCarousel ?> text-primary"></li>
				<?php } ?>
				</ol>
				
				<a class="carousel-control-prev text-primary" href="#car-lp" role="button" data-slide="prev">
					<i class="fas fa-chevron-left fa-2x fa-fw"></i>
					<span class="sr-only">Previous</span>
			  	</a>
				<a class="carousel-control-next text-primary" href="#car-lp" role="button" data-slide="next">
					<i class="fas fa-chevron-right fa-2x fa-fw"></i>
					<span class="sr-only">Next</span>
				</a>
				
				
			</div>
	</div>
</div>

<script type="text/javascript">
$('#car-lp').carousel({ interval: 6000 })
</script>
<?php mysqli_free_result($RSlp1)?>