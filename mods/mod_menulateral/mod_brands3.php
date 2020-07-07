<?php
$qryRSlb="SELECT * FROM db_items_brands WHERE status=1 ORDER BY name ASC";
$RSlb = mysql_query($qryRSlb) or die(mysql_error());
$dRSlb = mysql_fetch_assoc($RSlb);
?>
    <ul class="dropdown-menu">
	<?php do{ ?>
    	<li class="list-group-item"><?php genBrand($dRSlb); ?></li>
	<?php }while ($dRSlb = mysql_fetch_assoc($RSlb)); ?>
	</ul>
<?php mysql_free_result($RSlb); ?>