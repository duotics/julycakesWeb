<?php
/************************************************
/************************************************
	LISTADO DE CATEGORIAS db_items_type
************************************************/
if($b_url){
	switch($b_url){
		case "all":
			$qbrandC="";
			break;
		default:
			$qbrandC=sprintf('AND db_items_brands.url=%s',SSQL($b_url,'text'));
	}
}
$query_RSvc = sprintf("SELECT DISTINCT db_items_type.typID AS c_id, db_items_type.typNom AS c_nom, db_items_type.typUrl AS c_url, 
db_items_type.typImg AS c_img, db_items_type.typ_id AS c_typ, db_items_type.typDes as c_des 
FROM db_items_type 
LEFT JOIN db_items_type_vs ON db_items_type.typID = db_items_type_vs.typID 
LEFT JOIN db_items ON db_items_type_vs.item_id = db_items.item_id 
LEFT JOIN db_items_brands ON db_items.brand_id = db_items_brands.id 
WHERE db_items_type.typIDp=%s AND db_items_type.typEst=1 ".$qbrandC." ORDER BY typNom ASC", 
SSQL($idc, "int"));
//echo $query_RSvc;
$RSvc = mysqli_query($conn,$query_RSvc) or die(mysqli_error($conn));
$dRSvc = mysqli_fetch_assoc($RSvc);
$TR_RSvc = mysqli_num_rows($RSvc);
?>
<?php if($TR_RSvc>0){ //View List Categories parent ?>
<?php if($idc!=0){?>
<div style="border-top:1px solid #e7e7e7; margin-bottom:0px;">
<span class="badge badge-secondary" style="top: -12px; position: relative;">Sub categorías</span>
</div>
<?php } ?>
    <div class="row mb-4">
	<?php $contCS=0; ?>
	<?php do { ?>
		<div class="col-sm-3"><?php genBtnTypG($dRSvc); ?></div>
        <?php $contCS++;
		if($contCS==4){
			echo '<div style="clear:both;"></div>';
			$contCS=0;
		}
		?>
	<?php } while ($dRSvc = mysqli_fetch_assoc($RSvc)); ?>
	</div>
<?php } ?>
<?php
/************************************************
/************************************************
/************************************************
	LISTADO DE ITEMS db_items
************************************************/
/*ARMANDO CONDICIONES QRY db_items*/
if($b_url){
	switch($b_url){
		case "all":
			$qbrand="";
			break;
		default:
			$qbrand=sprintf('AND db_items_brands.url=%s',SSQL($b_url,'text'));
	}
}
switch($sort){
	case "az": $qsort=" ORDER BY db_items.item_cod ASC";
		break;
	case "za": $qsort=" ORDER BY db_items.item_cod DESC";
		break;
	case "brand": $qsort=" ORDER BY db_items_brands.name ASC";
		break;
	case "top": $qsort=" ORDER BY db_items.item_hits DESC";
		break;
	case "pm": $qsort=" ORDER BY db_items.item_price DESC";
		break;
	case "pl": $qsort=" ORDER BY db_items.item_price ASC";
		break;
	default: $qsort=" ORDER BY db_items.item_id DESC";
}
$query_RSvi = sprintf("SELECT db_items.item_id AS i_id, db_items.item_cod AS i_cod, db_items.item_nom AS i_nom, db_items.item_aliasurl AS i_url, db_items.item_img AS i_img, db_items.item_date as i_date, 
db_items.item_price AS i_pri, db_items.item_price2 AS i_pri2, db_items.item_status as i_stat, 
db_items_type.typUrl AS c_url, db_items_brands.name as b_nom, db_items_brands.URL as b_url, db_items_brands.img AS b_img 
FROM db_items_type_vs
LEFT JOIN db_items 
ON db_items_type_vs.item_id=db_items.item_id
LEFT JOIN db_items_type
ON db_items_type_vs.typID=db_items_type.typID
LEFT JOIN db_items_brands 
ON db_items.brand_id=db_items_brands.id
WHERE db_items_type_vs.typID=%s AND db_items.item_status=1 ".$qbrand." %s", 
SSQL($idc, 'int'),
SSQL($qsort,''));
$RSvi = mysqli_query($conn,$query_RSvi) or die(mysqli_error($conn));
$row_RSvi = mysqli_fetch_assoc($RSvi);
$TR_RSvi = mysqli_num_rows($RSvi);
?>

<?php if($TR_RSvi>0){ //View Items of this Category ?>
<script>
	$(document).ready(function() {
		$('#selBrand').change(function(){
			var url=RAIZ+'c/'+'<?php echo $c_url ?>'+'/'+$('#selBrand').val()+'/'+$('#selSort').val();
			location.href=url;
		});
		$('#selSort').change(function(){
			var url=RAIZ+'c/'+'<?php echo $c_url ?>'+'/'+$('#selBrand').val()+'/'+$('#selSort').val();
			location.href=url;
		});
	});
</script>
<div class="bar-itools">
<div class="row">
	<div class="col-sm-4">
    <span class="bar-itools-res"><strong><?php echo $TR_RSvi?></strong> Results</span>
    </div>
    <div class="col-sm-8 text-right">
    <form class="form-inline">
    	<div class="form-group" style="padding-left:10px">
        	<label><i class="fa fa-filter fa-lg text-muted"></i> Filtrar por Marca</label>
			<?php //MUESTRO SOLO LAS BRANDS EXISTENTES CON LA CATEGORIA SELECCIONADA
            $qryBC=sprintf('SELECT DISTINCT db_items_brands.name AS sVAL, db_items_brands.url as sID FROM db_items_type_vs
            LEFT JOIN db_items ON db_items_type_vs.item_id=db_items.item_id 
            LEFT JOIN db_items_type ON db_items_type_vs.typID=db_items_type.typID 
            LEFT JOIN db_items_brands ON db_items.brand_id=db_items_brands.id 
            WHERE db_items_type_vs.typID=%s AND db_items.item_status=1 ORDER BY db_items_brands.name ASC', 
            SSQL($idc,'int'));
            $RSbc = mysqli_query($conn,$qryBC) or die(mysqli_error($conn));
            genSelect('typIDp', $RSbc, $b_url, 'form-control input-sm','','selBrand','',TRUE,'all','Todos');
            ?>
        </div>
		<div class="form-group" style="padding-left:10px">
        	<label><i class="fa fa-sort fa-lg text-muted"></i> Ordenar por</label>
           <?php $data=array("Nuevos Productos"=>"new", "Mas Populares"=>"top","Por Marca"=>"brand","Alfabetico A-Z"=>"az","Alfabetico Z-A"=>"za","Precio Mayor"=>"pm","Precio Menor"=>"pl");
				genSelectManual('selSort', $data, $sort, 'form-control input-sm', NULL, NULL, NULL, FALSE); ?>
        </div>
    </form>
    </div>
</div>
</div>
    <div class="row">
	<?php do { ?> 
		<div class="col-xs-6 col-md-3 animated fadeIn mb-4" id="<?php echo $row_RSvi['item_id']?>">
        <?php echo genBtnItemG($row_RSvi, 'card prod-card', ''); ?>
		</div>
	<?php } while ($row_RSvi = mysqli_fetch_assoc($RSvi)); ?>
	</div>
<?php } ?>
<?php if((!$TR_RSvi)&&(!$TR_RSvc)){ ?>
	<div class="well well-sm"><h4>No existen artículos en esta categoría !</h4></div>
<?php }
mysqli_free_result($RSvc);
mysqli_free_result($RSvi);
?>