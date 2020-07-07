<?php
$qRSlb = sprintf("SELECT db_items_brands.id AS b_id, db_items_brands.name AS b_nom, db_items_brands.url AS b_url, db_items_brands.img AS b_img FROM db_items_brands WHERE db_items_brands.status=1 ORDER BY db_items_brands.name ASC");
$RSlb = mysql_query($qRSlb) or die(mysql_error());
$dRSlb = mysql_fetch_assoc($RSlb);
$TR_RSlb = mysql_num_rows($RSlb);
 ?>
<?php if($TR_RSlb>0){ //View List Categories parent ?>
<div class="row">
<?php $contCS=0; ?>
<?php do { ?>
    <div class="col-sm-2"><?php genBtnBrand($dRSlb); ?></div>
    <?php $contCS++;
    if($contCS==6){
        echo '<div style="clear:both;"></div>';
        $contCS=0;
    }
    ?>
<?php } while ($dRSlb = mysql_fetch_assoc($RSlb)); ?>
</div>
<?php
} ?>
<?php mysql_free_result($RSlb);?>