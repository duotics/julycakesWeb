<?php if($detcat['cat_des']){ ?>
<div><?php echo $detcat['cat_des'];?></div>
<hr style="margin:10px 0px;">
<?php } ?>
<?php
$idcat=$idc;
$query_RSvc = sprintf("SELECT * FROM db_items_cats WHERE cat_id_parent = %s AND cat_status='1' ORDER BY cat_order ASC", GetSQLValueString($idcat, "int"));
$RSvc = mysql_query($query_RSvc) or die(mysql_error());
$row_RSvc = mysql_fetch_assoc($RSvc);
$totalRows_RSvc = mysql_num_rows($RSvc);
$query_RSvi = sprintf("SELECT * FROM db_items WHERE cat_id = %s AND item_status=1 ORDER BY item_id DESC", GetSQLValueString($idcat, "int"));
$RSvi = mysql_query($query_RSvi) or die(mysql_error());
$row_RSvi = mysql_fetch_assoc($RSvi);
$totalRows_RSvi = mysql_num_rows($RSvi);
if($totalRows_RSvc>0){ //View List Categories parent ?>
	<div class="row">
	<?php do { ?>
		<div class="col-sm-4">
        	<?php link_catlist($row_RSvc['cat_id'],$RAIZidbC); ?>
		</div>
	<?php } while ($row_RSvc = mysql_fetch_assoc($RSvc)); ?>
	</div>
<?php } ?>
<?php if($totalRows_RSvi>0){ //View Items of this Category ?>
	<div class="row">
	<?php do { ?>
		<div class="col-sm-4">
        <?php link_itemlist($row_RSvi['item_id'],$RAIZidbP); ?>
		</div>
	<?php } while ($row_RSvi = mysql_fetch_assoc($RSvi)); ?>
	</div>
<?php } ?>
<?php if((!$totalRows_RSvi)&&(!$totalRows_RSvc)){ ?>
	<div class="alert alert-default">*** Items Not Found ! ***</div>
<?php }
mysql_free_result($RSvc);
mysql_free_result($RSvi);
?>