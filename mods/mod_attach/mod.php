<?php
$qRSv = sprintf("SELECT * FROM tbl_mod_attach_item 
INNER JOIN tbl_mod_attach ON tbl_mod_attach_item.att_id=tbl_mod_attach.att_id 
WHERE item_id = %s AND att_status='1'",
	SSQL($iditem, "int"));
$RSv = mysqli_query($conn,$qRSv) or die(mysql_error($conn));
$dRSv = mysqli_fetch_assoc($RSv);
$tRSv = mysqli_num_rows($RSv);
?>
<?php if($tRSv>0){ ?>
<div class="panel panel-default" id="files">
	<div class="panel-heading"><i class="fa fa-file-o fa-lg"></i> Documents</div>
	<ul class="list-group">
		<?php do { ?>
		<?php $isexternal=$dRSv['is_external'];
		$valpathdoc=NULL;
		if ($isexternal==0) $valpathdoc=$RAIZ."docs/"; ?>
		<li class="list-group-item">
			<a href="<?php echo $valpathdoc.$dRSv['att_link']; ?>" target="_blank">
			<span class="label label-default"><i class="fa fa-download fa-lg"></i> Download</span> <?php echo $dRSv['att_title']; ?></a>
		</li>
		<?php } while ($dRSv = mysqli_fetch_assoc($RSv)); ?>
	</ul>
</div>
<?php
}
mysqli_free_result($RSv);
?>