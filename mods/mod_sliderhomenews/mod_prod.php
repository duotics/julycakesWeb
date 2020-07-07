<?php $contSlides=10;
$b_url='bunoviata';
$sort='new'; //parametro enviado es el URL de db_items_type
//Verifico si existe el parametro muestro la categoria si no muestro el root
$isView=TRUE;
/*ARMANDO CONDICIONES QRY db_items*/
if($b_url){
	switch($b_url){
		case "all":
			$qbrand="";
			break;
		default: $qbrand=sprintf('AND db_items_brands.url=%s',SSQL($b_url,'text'));
	}
}
switch($sort){
	case "az":
		$qsort=" ORDER BY db_items.item_cod ASC";
		break;
	case "za":
		$qsort=" ORDER BY db_items.item_cod DESC";
		break;
	case "brand":
		$qsort=" ORDER BY db_items_brands.name ASC";
		break;
	case "top":
		$qsort=" ORDER BY db_items.item_hits DESC";
		break;
	default:
		$qsort=" ORDER BY db_items.item_id DESC";
}
$query_RSbhnp = sprintf("SELECT db_items.item_id AS i_id, db_items.item_cod AS i_cod, db_items.item_nom AS i_nom, db_items.item_aliasurl AS i_url, db_items.item_img AS i_img, 
db_items.item_date as i_date, db_items.item_status as i_stat, db_items_brands.name as b_nom, db_items_brands.URL as b_url, db_items_brands.img AS b_img, db_items_type.typUrl AS c_url 
FROM db_items 
LEFT JOIN db_items_type_vs
ON db_items.item_id=db_items_type_vs.item_id
LEFT JOIN db_items_type
ON db_items_type_vs.typID=db_items_type.typID
LEFT JOIN db_items_brands 
ON db_items.brand_id=db_items_brands.id
WHERE db_items.item_status=1 ".$qbrand." GROUP BY db_items.item_id %s LIMIT %s", 
						SSQL($qsort,''),
						SSQL($contSlides,'int'));
$RSbhnp = mysqli_query($conn,$query_RSbhnp) or die(mysqli_error($conn));
$dRSbhnp = mysqli_fetch_assoc($RSbhnp);
$tr_RSbhnp = mysqli_num_rows($RSbhnp);
?>
<div>
<div class="panel panel-default panel-steel">
    <div class="panel-heading">NEW MODELS <?php echo strtoupper($b_url) ?></div>
    <div id="bhnp" class="carousel slide carousel-home" data-ride="carousel">
		<ol class="carousel-indicators">
			<?php $bhnpFS=TRUE; ?>
			<?php for($x=0;$x<$tr_RSbhnp;$x++){ ?>
			<?php 
				if($bhnpFS==TRUE){
					$cssB='active';
					$bhnpFS=FALSE;
				}else $cssB=NULL; ?>
				<li data-target="#bhnp" data-slide-to="<?php echo $x ?>" class="<?php echo $cssB ?>"></li>
			<?php } ?>
		</ol>
			<!-- Carousel items -->
		<div class="carousel-inner text-center">
			<?php
			$bhnpFS=TRUE;
			do{
			if($bhnpFS==TRUE){
				$cssB='active';
				$bhnpFS=FALSE;
			}else $cssB=NULL;
			if($dRSbhnp['c_url']) $linkI=$RAIZ.'p/'.$dRSbhnp['c_url'].'/'.$dRSbhnp['i_url'];
			else $linkI=$RAIZ.'p/none/'.$dRSbhnp['i_url'];
			?>
			<div class="<?php echo $cssB ?> item item-slider-mod carousel-home">
			<a href="<?php echo $linkI ?>">
				<div class="panel-carousel">
				<div class="">
				<img src="<?php echo $RAIZi.'items/'.$dRSbhnp['i_img'] ?>"  alt="<?php echo $dRSbhnp['i_cod'] ?>" class="carousel-slide-img"/>
				</div>
				</div>

				<div class="carousel-caption">
				<h4><?php echo $dRSbhnp['i_nom'] ?></h4>
				</div>

			</a>
			</div>
			<?php }while($dRSbhnp=mysqli_fetch_assoc($RSbhnp)); ?>
		</div>
	</div>
</div>
</div>
<?php mysqli_free_result($RSbhnp); ?>