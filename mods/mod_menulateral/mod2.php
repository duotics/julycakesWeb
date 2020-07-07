<?php
$qryRSm0="SELECT * FROM db_items_type WHERE typIDp=1 AND typEst=1 ORDER BY typNom";
$RSm0 = mysqli_query($conn,$qryRSm0) or die(mysqli_error($conn));
$dRSm0 = mysqli_fetch_assoc($RSm0);
?>
<div class="panel panel-danger">
    <div class="panel-heading text-center"><a href="<?php $RAIZ?>c/" style="color:#fff"><?php echo $lang['gen']['mod-prods'] ?></a></div>
    <ul class="list-group">
	<?php do{ ?>
    	<li class="list-group-item menMF"><?php echo genMenPri($dRSm0); ?></li>
	<?php }while ($dRSm0 = mysqli_fetch_assoc($RSm0)); ?>
	</ul>
</div>
<?php mysqli_free_result($RSm0); ?>