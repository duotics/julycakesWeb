<?php
$qryRSlb="SELECT * FROM db_items_brands WHERE status=1 ORDER BY name ASC";
$RSlb = mysqli_query($conn,$qryRSlb) or die(mysqli_error($qryRSlb));
$dRSlb = mysqli_fetch_assoc($RSlb);
$tRSlb = mysqli_num_rows($RSlb);
?>
<div class="panel panel-primary">
    <div class="panel-heading text-center"><a href="<?php echo $RAIZ?>marca/" style="color:#fff">Marcas</a></div>
    <ul class="list-group">
	<?php if($tRSlb>0){ ?>
	<?php do{ ?>
    	<li class="list-group-item menMF"><?php genBrand($dRSlb); ?></li>
	<?php }while ($dRSlb = mysqli_fetch_assoc($RSlb)); ?>
	<?php } ?>
    </ul>
</div>
<?php mysqli_free_result($RSlb); ?>