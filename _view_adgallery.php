<?php
$query_RSfv = sprintf("SELECT * FROM db_items WHERE cat_id = %s AND item_status=%s ORDER BY item_cod ASC", GetSQLValueString($idc, 'int'),
GetSQLValueString('1', 'int'));
$RSfv = mysql_query($query_RSfv) or die(mysql_error());
$row_RSfv = mysql_fetch_assoc($RSfv);
$totalRows_RSfv = mysql_num_rows($RSfv);
?>
<div align="center">
<?php if ($totalRows_RSfv>0){ ?>
<ul class="list-group">
<?php do { ?>
<?php $statnew=fnc_franew($row_RSfv['item_id']);
	$url_image_small=$RAIZi.'frame/small/'.$row_RSfv['item_cod'].".jpg";
    $url_image_big=$RAIZi.'frame/big/'.$row_RSfv['item_cod'].".jpg";
    
    //Return Material Info
    $material_det=detRow('db_items_mat','mat_id',$row_RSfv['mat_id']);
	
	if ($statnew==1){ //NEW
	}else{ //OLD
	}
?>
<li class="list-group-item">
    <a href="<?php echo $url_image_big; ?>" class="fancybox">
        <img src="<?php echo $url_image_small; ?>" title="<?php echo $fnew['codigo']; ?>" longdesc="<?php echo $RAIZ?>frame.php?cod=<?php echo $fnew['codigo']; ?>" alt="<?php echo $material_det['mat_des']; ?>:<?php echo $fnew['size']; ?>">
    </a>
    <img src="<?php echo $RAIZi?>struct/label_black_new-32.png" width="32" height="32" alt="NEW"/>
</li>
<?php }while ($row_RSfv = mysql_fetch_assoc($RSfv)); ?>
</ul>
<?php }else{ ?>
	<div class="alert alert-default">No Items Found</div>
<?php } ?>
</div>
<?php  mysql_free_result($RSfv); ?>