<?php
$qryTP1 = sprintf("SELECT * FROM db_items WHERE item_status = %s ORDER BY item_hits DESC LIMIT 0,4",
	GetSQLValueString('1', "int"));
$RStp1 = mysql_query($qryTP1) or die(mysql_error());
$row_RStp1 = mysql_fetch_assoc($RStp1);
$qryTP2 = sprintf("SELECT * FROM db_items WHERE item_status = %s ORDER BY item_hits DESC LIMIT 4,4",
	GetSQLValueString('1', "int"));
$RStp2 = mysql_query($qryTP2) or die(mysql_error());
$row_RStp2 = mysql_fetch_assoc($RStp2);

?>

<div class="panel panel-default panel-steel">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-star"></i> NEW COLLECTIONS</h3>
  </div>
  <div class="panel-body">

    <div class="carousel slide" data-ride="carousel">
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <div class="row">
	<?php do {?>
    	<div class="col-xs-6 col-md-3">
    <a href="<?php echo $RAIZ ?>product/<?php echo $row_RStp1['item_aliasurl']; ?>" class="thumbnail" style="margin:1px">
      <img src="<?php echo $RAIZi."items/t_".$row_RStp1['item_img']; ?>" alt="<?php echo $row_RStp1['item_nom']; ?>" style="max-height:100px;">
      <div class="caption"><small><?php echo $row_RStp1['item_cod']; ?></small></div>
    </a>
  </div>
    
	<?php } while ($row_RStp1 = mysql_fetch_assoc($RStp1)); ?>
</div>
    </div>
    <div class="item">
      <div class="row">
	<?php do {?>
    	<div class="col-xs-6 col-md-3">
    <a href="<?php echo $RAIZ ?>product/<?php echo $row_RStp2['item_aliasurl']; ?>" class="thumbnail" style="margin:1px">
      <img src="<?php echo $RAIZi."items/t_".$row_RStp2['item_img']; ?>" alt="<?php echo $row_RStp2['item_nom']; ?>" style="max-height:100px;">
      <div class="caption"><small><?php echo $row_RStp2['item_cod']; ?></small></div>
    </a>
  </div>
    
	<?php } while ($row_RStp2 = mysql_fetch_assoc($RStp2)); ?>
</div>
    </div>
  </div>
</div>
    
  </div>
</div>
<?php mysql_free_result($RStp1);
mysql_free_result($RStp2); ?>