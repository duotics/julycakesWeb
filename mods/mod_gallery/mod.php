<?php
//$iditem variable que viene con el ID desde el contenedor principal
function modGall($idr,$ref){
	Global $conn;
$qRSg = sprintf("SELECT tbl_gallery_ref.idg AS gallID, tbl_gallery_ref.idr AS refID, tbl_gallery_ref.ref AS REF, 
tbl_gallery.gall_tit AS gallTit, tbl_gallery.gall_span AS gallSpan, tbl_gallery.gall_stat AS gallStat FROM tbl_gallery_ref
INNER JOIN tbl_gallery ON tbl_gallery_ref.idg=tbl_gallery.gall_id
WHERE tbl_gallery_ref.idr = %s AND tbl_gallery_ref.ref=%s AND tbl_gallery.gall_stat=%s",
				SSQL($idr, "int"),
				SSQL($ref,'text'),
				SSQL('1','int'));
$RSg = mysqli_query($conn,$qRSg) or die(mysqli_error($conn));
$dRSg = mysqli_fetch_assoc($RSg);
$tRSg = mysqli_num_rows($RSg);
if($tRSg>0){//Verifico si existen galerias?>
	<?php do { ?>
	<?php $gID=$dRSg['gallID'];
	if (!$dRSg['gallTit'])$gTit="Gallery";
	else $gTit=$dRSg['gallTit'];
	?>
    <div class="panel panel-default">
    	<div class="panel-heading"><i class="fa fa-picture-o"></i> <?php echo $gTit?></div>
        <div class="panel-body">
	<?php
		$qRSi = sprintf("SELECT * FROM tbl_gallery_items WHERE gall_id = %s AND img_status = %s",
		SSQL($gID, "int"),
		SSQL('1','int'));
		$RSi = mysqli_query($conn,$qRSi) or die(mysqli_error($conn));
		$dRSi = mysqli_fetch_assoc($RSi);
		$tRSi = mysqli_num_rows($RSi);
		if($tRSi>0){
		$contIGRow=1;?>
		<div class="row">
		<?php do{ ?>
   		<?php
		$itemimg=$dRSi['img_path'];
		$itemimgt=$dRSi['img_tit'];
		?> 
			<div class="col-xs-6 col-md-3">
                <a href="<?php echo $GLOBALS['RAIZi']."data/".$itemimg ?>" class="thumbnail fancybox-thumb text-center" rel="fancybox-thumb" title="<?php echo $itemimgt ?>">
					<img src="<?php echo $GLOBALS['RAIZi']."data/t_".$itemimg; ?>" style="height:100px;"/>
                    <?php if($itemimgt){ echo '<small>'.$itemimgt.'</small>'; } ?>
                </a>
            </div>
           <?php if($contIGRow==4){echo '</div><div class="row">'; $contIGRow=1;}else{$contIGRow++;};?>
		<?php } while ($dRSi = mysqli_fetch_assoc($RSi)); ?>
        </div>
		<?php }
		mysqli_free_result($RSi);?>
        </div><!--END Panel Body-->
    </div>	<!--END Panel-->
	<?php } while ($dRSg = mysqli_fetch_assoc($RSg)); ?>
<?php } ?>
<?php mysqli_free_result($RSg);?>
<?php } ?>