<?php //CATEGORIES IN THIS BRANDS
$qRSlb = sprintf("SELECT DISTINCT db_items_type.typNom AS c_nom, db_items_type_vs.typID AS c_id, db_items_type.typUrl AS c_url, db_items_type.typImg AS c_img, db_items_type.typ_id AS c_typ, db_items_type.typDes FROM db_items_type_vs 
LEFT JOIN db_items_type ON db_items_type_vs.typID = db_items_type.typID
LEFT JOIN db_items ON db_items_type_vs.item_id = db_items.item_id
WHERE db_items.brand_id=%s 
AND db_items.item_status=1 
ORDER BY db_items_type.typNom ASC",
GetSQLValueString($idb,'int'));
$RSlb = mysql_query($qRSlb) or die(mysql_error());
$dRSlb = mysql_fetch_assoc($RSlb);
$TR_RSlb = mysql_num_rows($RSlb);
//ITEMS IN THIS BRAND
$qRSlbo=sprintf('SELECT db_items.item_id AS i_id, db_items.item_aliasurl AS i_url, db_items.item_cod AS i_cod, db_items.item_img as i_img, db_items_brands.url AS c_url, db_items_brands.url AS b_url, db_items_brands.img AS b_img FROM db_items LEFT JOIN db_items_brands ON db_items.brand_id=db_items_brands.id WHERE NOT EXISTS ( SELECT db_items_type_vs.id FROM db_items_type_vs WHERE db_items_type_vs.item_id = db_items.item_id) AND brand_id=%s AND db_items.item_status=1',
GetSQLValueString($idb,'int'));
$RSlbo = mysql_query($qRSlbo) or die(mysql_error());
$dRSlbo = mysql_fetch_assoc($RSlbo);
$TR_RSlbo = mysql_num_rows($RSlbo);

?>
<?php if(($TR_RSlb>0)||($TR_RSlbo>0)){ //View Results ?>
<?php if($TR_RSlb>0){ //View List Categories parent ?>
<div class="row">
<?php $contCS=0; ?>
<?php do { ?>
    <div class="col-sm-3"><?php genBtnTypG($dRSlb,$b_url); //echo $dRSlb['c_nom'] //genBtnBrand($dRSlb); ?></div>
    <?php $contCS++;
    if($contCS==4){
        echo '<div style="clear:both;"></div>';
        $contCS=0;
    }
    ?>
<?php } while ($dRSlb = mysql_fetch_assoc($RSlb)); ?>
</div>
<?php } ?>
<?php if($TR_RSlbo>0){ //View List Products With no Category?>
<hr>
<div class="row">
<?php $contCS=0; ?>
<?php do { ?>
    <div class="col-sm-3"><?php echo genBtnItemG($dRSlbo)?></div>
    <?php $contCS++;
    if($contCS==4){
        echo '<div style="clear:both;"></div>';
        $contCS=0;
    }
    ?>
<?php } while ($dRSlbo = mysql_fetch_assoc($RSlbo)); ?>
</div>
<?php } ?>

<?php }else{ ?>
<div class="well well-sm">
	<h4>No items found in this Brand !</h4>
</div>
<?php } ?>
<?php mysql_free_result($RSlb);?>