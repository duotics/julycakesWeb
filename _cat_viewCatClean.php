<?php

function genBtnTypGC($det,$paramBrand=NULL){
$det_nom=strtoupper($det['c_nom']);
$image=fnc_image_exist($GLOBALS['RAIZ'],'images/types/',$det['c_img']);
$imgcat='<div class="vcat-cat-img" class="text-center">
<img src="'.$image['t'].'" alt="'.$det_nom.'" class="img-responsive"/></div>';
$tV=$det['c_typ'];
//Construct URL
switch ($tV) {
    case 1://Under Construcction
        $link_opt='onclick="alert('."'Under Construction'".')"';
		$link_url='#';
        break;
    case 2://Catalog
        $link_url=$GLOBALS["RAIZ"].'cat_clean.php?c_url='.$det['c_url'].'&'.$paramBrand;
		$link_trg='_self';
        break;
    case 3://External
        $link_url="#";
        break;
    default:
        //No View
}

$btnRet='<a href="'.$link_url.'" target="'.$link_trg.'" id="c_'.$param1.'" '.$link_opt.' class="vcat-cat-cont">';
$btnRet.='<div class="panel panel-default vcat-cat">';
$btnRet.='<div class="panel-heading text-center">'.$det_nom.'</div>';
$btnRet.='<div class="panel-body">';
//$btnRet.='<span class="btn btn-default btn-md btn-block" style="overflow:hidden; font-size:12px">'.$det_nom.'</span>';
$btnRet.=$imgcat;
$btnRet.='</div>';
$btnRet.='</div>';
$btnRet.='</a>';
echo $btnRet;
}

function genBtnItemGC($det){
$i_img=fnc_image_exist($GLOBALS['RAIZ'],'images/items/',$det['i_img']);
$b_img=fnc_image_exist($GLOBALS['RAIZ'],'images/brand/',$det['b_img']);
$link=$i_img['n'];

$btnRet.='<a href="'.$link.'" class="thumbnail vcat-item fancybox" id="i_'.$det['i_id'].'" rel="gall" title="'.$det['b_nom'].' - '.$det['i_cod'].'">';
$btnRet.='<div class="vcat-item-img text-center">';
$btnRet.='<img src="'.$i_img['t'].'" alt="'.$det['i_cod'].'" class="img-responsive"/>';
$btnRet.='</div>';
$btnRet.='<div class="vcat-item-tit text-center">'.$det['i_cod'].'</div>';
$btnRet.='</a>';
return $btnRet;
}

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
			$qbrandC=sprintf('AND db_items_brands.url=%s',GetSQLValueString($b_url,'text'));
	}
}

$query_RSvc = sprintf("SELECT DISTINCT db_items_type.typID AS c_id, db_items_type.typNom AS c_nom, db_items_type.typUrl AS c_url, db_items_type.typImg AS c_img, db_items_type.typ_id AS c_typ, db_items_type.typDes as c_des 
FROM db_items_type 

LEFT JOIN db_items_type_vs ON db_items_type.typID = db_items_type_vs.typID
LEFT JOIN db_items ON db_items_type_vs.item_id = db_items.item_id

LEFT JOIN db_items_brands ON db_items.brand_id = db_items_brands.id 

WHERE db_items_type.typIDp=%s AND db_items_type.typEst=1 ".$qbrandC." ORDER BY typNom ASC", 
GetSQLValueString($idc, "int"));
//echo $query_RSvc;
$RSvc = mysql_query($query_RSvc) or die(mysql_error());
$dRSvc = mysql_fetch_assoc($RSvc);
$TR_RSvc = mysql_num_rows($RSvc);
?>
<?php if($TR_RSvc>0){ //View List Categories parent ?>
<?php if($idc!=1){?>
<div style="border-top:1px solid #e7e7e7; margin-bottom:0px;">
<span class="label label-default" style="top: -12px; position: relative;">Subcategories</span>
</div>
<?php } ?>
    <div class="row">
	<?php $contCS=0; ?>
	<?php do { ?>
		<div class="col-sm-3"><?php genBtnTypGC($dRSvc); ?></div>
        <?php $contCS++;
		if($contCS==4){
			echo '<div style="clear:both;"></div>';
			$contCS=0;
		}
		?>
	<?php } while ($dRSvc = mysql_fetch_assoc($RSvc)); ?>
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
$query_RSvi = sprintf("SELECT db_items.item_id AS i_id, db_items.item_cod AS i_cod, db_items.item_aliasurl AS i_url, db_items.item_img AS i_img, db_items.item_date as i_date, db_items.item_status as i_stat, db_items_type.typUrl AS c_url, db_items_brands.name as b_nom, db_items_brands.URL as b_url, db_items_brands.img AS b_img FROM db_items_type_vs
LEFT JOIN db_items 
ON db_items_type_vs.item_id=db_items.item_id
LEFT JOIN db_items_type
ON db_items_type_vs.typID=db_items_type.typID
LEFT JOIN db_items_brands 
ON db_items.brand_id=db_items_brands.id
WHERE db_items_type_vs.typID=%s AND db_items.item_status=1 ".$qbrand." %s", 
GetSQLValueString($idc, 'int'),
GetSQLValueString($qsort,''));
$RSvi = mysql_query($query_RSvi) or die(mysql_error());
$row_RSvi = mysql_fetch_assoc($RSvi);
$TR_RSvi = mysql_num_rows($RSvi);
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
<div class="bar-itools"><strong><?php echo $TR_RSvi?></strong> Results</div>
    <div class="row">
	<?php $contIS=0; ?>
	<?php do { ?>
		<div class="col-sm-3" id="<?php echo $row_RSvi['item_id']?>">
        <?php echo genBtnItemGC($row_RSvi); ?>
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
mysql_free_result($RSvc);
mysql_free_result($RSvi);
?>