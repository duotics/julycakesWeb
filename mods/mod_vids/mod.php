<?php
$query_RSv = sprintf("SELECT * FROM tbl_mod_videos WHERE itemview = %s AND vid_status=%s",
SSQL($iditem, "int"),
SSQL('1', "int"));
$RSv = mysqli_query($conn,$query_RSv) or die(mysqli_error($conn));
$dRSv = mysqli_fetch_assoc($RSv);
$totalRows_RSv = mysqli_num_rows($RSv); ?>

<?php if($totalRows_RSv>0){ ?>
<div class="panel panel-primary">
	<div class="panel-heading"><i class="fa fa-youtube-play fa-lg"></i> VIDEOS</div>
    <div class="panel-body">
		<ul class="list-group">
			<?php do { ?>
            <?php
            $vidTit=$dRSv['vid_title'];
			$vidCod=$dRSv['vid_code'];
			if($vidTit){$vidTit='<h4>'.$vidTit.'</h4>';} ?>
			<li class="list-group-item">
            <?php echo $vidTit ?>
            <?php echo $vidCod ?>
            </li>
			<?php } while ($dRSv = mysqli_fetch_assoc($RSv)); ?>
		</ul>
    </div>
</div>
<?php } ?>
<?php mysqli_free_result($RSv);?>