<?php
$query_RSm0 = "SELECT cat_id, typ_id, cat_nom, cat_aliasurl, cat_des FROM db_items_cats WHERE cat_id_parent = 0 AND cat_id<>0 ORDER BY cat_order";
$RSm0 = mysql_query($query_RSm0) or die(mysql_error());
$row_RSm0 = mysql_fetch_assoc($RSm0);
$totalRows_RSm0 = mysql_num_rows($RSm0);
?>
<div class="panel panel-gray">
  <div class="panel-body">

<ul class="nav nav-pills nav-stacked list-menuleft">
<?php do {
	$mOpt=NULL;
	if($row_RSm0['typ_id']=="5"){
		$mLink=$row_RSm0['cat_des'];
		$mOpt='target="_blank"';
	}else{
		$mLink=$RAIZ.'category/'.$row_RSm0['cat_aliasurl'];
	}
	?>
    <li>
    	<a href="<?php echo $mLink ?>" <?php echo $mOpt ?>><i class="fa fa-angle-right"></i> <?php echo $row_RSm0['cat_nom']; ?></a>
	</li>
<?php } while ($row_RSm0 = mysql_fetch_assoc($RSm0)); ?>
</ul>
</div>
</div>
<?php mysql_free_result($RSm0); ?>