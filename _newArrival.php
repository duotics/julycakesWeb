<?php
$b_url=vParam('b_url', $_GET['b_url'], $_POST['b_url']); //parametro enviado es el URL de db_items_type
$sort=vParam('s', $_GET['s'], $_POST['s']); //parametro enviado es el URL de db_items_type
//Verifico si existe el parametro muestro la categoria si no muestro el root
$isView=TRUE;
?>
<?php if(($isView==TRUE)){ ?>
<div class="well contGen">
<?php echo genBrdc('cat',$idc) ?>
<?php if($vTit==TRUE){ ?>
<div id="dcat_head">
<div id="dcat_tit">
<h1 id="c_<?php echo $idc ?>"><?php echo $det_nom?></h1>
<?php if($det['typDes']){ echo $det['typDes']; }?>
</div>
</div>
<?php } ?>
<div class="cont-catalog">
cont-catalog
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
			$qbrand=sprintf('AND db_items_brands.url=%s',GetSQLValueString($b_url,'text'));
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
$query_RSvi = sprintf("SELECT db_items.item_id AS i_id, db_items.item_cod AS i_cod, db_items.item_aliasurl AS i_url, db_items.item_img AS i_img, db_items.item_date as i_date, db_items.item_status as i_stat, db_items_brands.name as b_nom, db_items_brands.URL as b_url, db_items_brands.img AS b_img 
FROM db_items 
LEFT JOIN db_items_brands 
ON db_items.brand_id=db_items_brands.id
WHERE db_items.item_status=1 ".$qbrand." %s LIMIT 20", 
GetSQLValueString($qsort,''));
$RSvi = mysql_query($query_RSvi) or die(mysql_error());
$row_RSvi = mysql_fetch_assoc($RSvi);
$TR_RSvi = mysql_num_rows($RSvi);
?>

<?php if($TR_RSvi>0){ //View Items of this Category ?>
<script>
	$(document).ready(function() {
		$('#selBrand').change(function(){
			var url=RAIZ+'newArrival.php?b_url='+''+$('#selBrand').val()+'&'+$('#selSort').val();
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
        	<label><i class="fa fa-filter fa-lg text-muted"></i> Filter by Brand</label>
			<?php //MUESTRO SOLO LAS BRANDS EXISTENTES CON LA CATEGORIA SELECCIONADA
            $qryBC=sprintf('SELECT DISTINCT db_items_brands.name AS sVAL, db_items_brands.url as sID FROM db_items_brands  ORDER BY db_items_brands.name ASC', 
            GetSQLValueString($idc,'int'));
            $RSbc = mysql_query($qryBC) or die(mysql_error());
            genSelect('typIDp', $RSbc, $b_url, 'form-control input-sm','','selBrand','',TRUE,'all','All');
            ?>
        </div>
		<div class="form-group" style="padding-left:10px">
        	<label><i class="fa fa-sort fa-lg text-muted"></i> Sorted By</label>
            <select class="form-control input-sm" id="selSort">
                <option value="new" <?php if($sort=='new') echo 'selected' ?>>Newest Arrivals</option>
                <option value="top" <?php if($sort=='top') echo 'selected' ?>>Most Popular</option>
                <option value="brand" <?php if($sort=='brand') echo 'selected' ?>>By Brand</option>
                <option value="az" <?php if($sort=='az') echo 'selected' ?>>Alphabetic A-Z</option>
                <option value="za" <?php if($sort=='za') echo 'selected' ?>>Alphabetic Z-A</option>
            </select>
        </div>
    </form>
    </div>
</div>
</div>
    <div class="row">
	<?php $contIS=0; ?>
	<?php do { ?>
		<div class="col-sm-3" id="<?php echo $row_RSvi['item_id']?>">
        <?php echo genBtnItemG($row_RSvi); ?>
		</div>
        <?php $contIS++;
		if($contIS==4){
			echo '<div style="clear:both;"></div>';
			$contIS=0;
		}
		?>
	<?php } while ($row_RSvi = mysql_fetch_assoc($RSvi)); ?>
	</div>
<?php } ?>
<?php if((!$TR_RSvi)&&(!$TR_RSvc)){ ?>
	<div class="well well-sm"><h4>Items Not Found !</h4></div>
<?php }

mysql_free_result($RSvi);
?>

</div>
<div style="clear:both;"></div>
<!--
<div class="well well-sm"><?php //include(RAIZm."mod_social/mod_bar.php"); ?></div>
-->
<div class="well well-sm"><?php btnBackCat($det['cat_id_parent']); ?></div>
</div>
<?php }else{ ?>

<div>
	<div class="alert alert-warning">
    	<h4>Category unavailable</h4>
    </div>
</div>
<?php } ?>