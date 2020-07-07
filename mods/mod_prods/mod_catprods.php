<?php
$qRSpc = sprintf("SELECT db_items.item_id AS i_id, db_items.item_nom AS i_nom, db_items.item_img AS i_img, db_items.item_aliasurl AS i_url, db_items.item_hits AS i_hits 
FROM db_items_type_vs 
INNER JOIN db_items ON db_items_type_vs.item_id=db_items.item_id 
WHERE typID=(select typID FROM db_items_type_vs WHERE item_id=%s) 
AND db_items_type_vs.item_id<>%s 
ORDER BY i_hits DESC LIMIT 6",
						 SSQL($idI, "int"),
						 SSQL($idI, "int"));
$RSpc = mysqli_query($conn,$qRSpc) or die(mysqli_error($conn));
$dRSpc = mysqli_fetch_assoc($RSpc);
$tRSpc = mysqli_num_rows($RSpc);
?>
<?php if($tRSpc>0){?>
<div class="panel panel-default">
	<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-cubes fa-lg"></i> RELATED PRODUCTS</h3></div>
    <div class="row">
  		
		<?php do { ?>
		<?php 
		$vImgPC=vImg('data/img/item/',$dRSpc['i_img']);
		$linkPC=$RAIZ.'p/related/'.$dRSpc['i_url'];?>
        <div class="col-sm-2" id="dRSpc_<?php echo $dRSpc['i_id'] ?>">
        <a href="<?php echo $linkPC ?>" class="thumbnail text-center">
        <img src="<?php echo $vImgPC[t] ?>"/> 
        <?php echo $dRSpc['i_nom']; ?>
        </a>
        </div>
        <?php } while ($dRSpc = mysqli_fetch_assoc($RSpc)); ?>
	</div>
</div>
<?php } ?>
<?php mysqli_free_result($RSpc) ?>