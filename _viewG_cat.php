<?php
$query_RSvc = sprintf("SELECT * FROM db_items_type WHERE typIDp=%s AND typEst=1 ORDER BY typNom ASC", 
GetSQLValueString($id, "int"));
$RSvc = mysql_query($query_RSvc) or die(mysql_error());
$row_RSvc = mysql_fetch_assoc($RSvc);
$TR_RSvc = mysql_num_rows($RSvc);
$query_RSvi = sprintf("SELECT * FROM db_items_type_vs WHERE typID=%s ORDER BY id DESC", 
GetSQLValueString($id, "int"));
$RSvi = mysql_query($query_RSvi) or die(mysql_error());
$row_RSvi = mysql_fetch_assoc($RSvi);
$TR_RSvi = mysql_num_rows($RSvi);
if($TR_RSvc>0){ //View List Categories parent ?>
	<div class="row">
	<?php do { ?>
		<div class="col-sm-4">X 
        	<?php echo genBtnTypG($row_RSvc['typID']); ?>
		</div>
	<?php } while ($row_RSvc = mysql_fetch_assoc($RSvc)); ?>
	</div>
<?php } ?>
<?php if($TR_RSvi>0){ //View Items of this Category ?>
	<div class="row">
	<?php do { ?>
		<div class="col-sm-4">
        <?php echo genBtnItemG($row_RSvi['item_id']); ?>
		</div>
	<?php } while ($row_RSvi = mysql_fetch_assoc($RSvi)); ?>
	</div>
<?php } ?>
<?php if((!$TR_RSvi)&&(!$TR_RSvc)){ ?>
	<div class="alert alert-default">*** Items Not Found ! ***</div>
<?php }
mysql_free_result($RSvc);
mysql_free_result($RSvi);
?>