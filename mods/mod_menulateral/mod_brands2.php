<?php
$qryRSlb="SELECT * FROM db_items_brands WHERE status=1 ORDER BY name ASC";
$RSlb = mysql_query($qryRSlb) or die(mysql_error());
$dRSlb = mysql_fetch_assoc($RSlb);
?>
<div class="panel panel-danger">
    <div class="panel-heading text-center"><a href="<?php echo $RAIZ?>marca/" style="color:#fff">Brands</a></div>
    <ul class="list-group">
	<?php do{ ?>
    	<li class="list-group-item menMF"><?php genBrandI($dRSlb); ?></li>
	<?php }while ($dRSlb = mysql_fetch_assoc($RSlb)); ?>
	</ul>
</div>
<?php mysql_free_result($RSlb); ?>