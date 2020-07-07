<?php
$qRSm = sprintf("SELECT * FROM tbl_mod_media WHERE itemview = %s AND med_status=%s",
SSQL($iditem, "int"),
SSQL('1', "int"));
$RSm = mysqli_query($conn,$qRSm) or die(mysqli_error($conn));
$row_RSm = mysqli_fetch_assoc($RSm);
$tRSm = mysqli_num_rows($RSm) ?>
<?php if($tRSm>0){ ?>
	<div class="well well-small">
		<span class="welltit"><i class="icon-facetime-video"></i> MULTIMEDIA</span>
            <ul class="unstyled">
			<?php do { ?>
			<li class="text-center"><?php echo $row_RSm['med_code']; ?></li>
            <?php } while ($row_RSm = mysqli_fetch_assoc($RSm)); ?>
            </ul>
	</div>
<?php } ?>
<?php mysqli_free_result($RSm);?>