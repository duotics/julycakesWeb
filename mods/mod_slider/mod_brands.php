<?php //BRANDS
$qryB=sprintf('SELECT * FROM db_items_brands WHERE status=1 AND url<>"var"  ORDER BY name ASC');
$RSb=mysqli_query($conn,$qryB) or die (mysqli_error($conn));
$dRSb=mysqli_fetch_assoc($RSb);
$tRSb = mysqli_num_rows($RSb);
$numItemsRow=6;
$spanSlides=12/$numItemsRow;
$tRSb_slides=$tRSb/$numItemsRow;
?>
<?php if(FALSE){ ?>
<div class="slickSlider">
<?php do{ ?>
	<div style="margin:0px 1px;" class="text-center">
		<a href="<?php echo $RAIZ.'brand/'.$dRSb['url']; ?>">
			<img class="img-thumbnail" src="<?php echo $RAIZi.'brand/t_'.$dRSb['img'] ?>" style="max-height:100px;"/>
		</a>
	</div>
	<?php }while($dRSb=mysqli_fetch_assoc($RSb)); ?>
</div>
<?php } ?>


<div id="carBrands" class="carousel slide carousel-brands" data-ride="carousel">
			
		  <!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
			<?php
			$contI=0; $contT=0;
			do{
				$dat=$dRSb;//CAMPO A CAMBIAR SEGUN EL RS RESPECTIVOS
				//echo $dat['img'];
				$vImg=vImg('images/brand/',$dat['img']);
				if($contT==0) $cssItem='active';
				else $cssItem='';
				if($contI==0){ 
				echo '<div class="item '.$cssItem.'"><div class="row">';
					$banCloseTag=FALSE;
				} 

				$linkd=$RAIZ.'brand/'.$dat['url'].'/';
			?>
			<div class="col-xs-2 col-md-<?php echo $spanSlides ?>">
				<a href="<?php echo $linkd ?>" class="" style="margin:1px">
					<img src="<?php echo $vImg['t'] ?>" alt="<?php echo $dat['i_nom']; ?>" class="img-thumbnail" style="max-height: 85px">
					<div class="caption text-center"><small><?php echo $dat['i_cod']; ?></small></div>
				</a>
			</div>
			<?php 
				if($contI==$numItemsRow-1){ 
					$contI=0;
					echo '</div></div>';
					$banCloseTag=TRUE;
				}else $contI++;
				$contT++;
			}while($dRSb=mysqli_fetch_assoc($RSb)); ?>
			<?php if($banCloseTag==FALSE) echo '</div></div>'; ?>
			</div>
			
			<ol class="carousel-indicators">
				<?php for($x=0;$x<round($tRSb_slides);$x++){ ?>
				<?php
				if($x==0) $tempCssCarousel='active';
				else $tempCssCarousel='';
				?>
				<li data-target="#carBrands" data-slide-to="<?php echo $x ?>" class="<?php echo $tempCssCarousel ?>"></li>
				<?php } ?>
			</ol>
			
		</div>



<?php mysqli_free_result($RSb); ?>
<script>
$('#carBrands').carousel({
	interval: 3000
})
</script>