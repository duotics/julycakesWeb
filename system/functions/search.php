<div class="well" style="background:#FFF;">
<?php
$ss=$_GET['ss'];
if ($ss<>''){// IF STRING SEARCH EXITS
	$sse=explode(" ",$ss); //Divide Search string each " " (space)
	$ssc=count($sse); //Count Number of words in ssq
	if ($ssc==1) { //Search with Like
		$cadbusca="SELECT * FROM db_items WHERE db_items.item_status='1' AND db_items.item_cod LIKE '%".$ss."%' OR db_items.item_nom LIKE '%".$ss."%' OR db_items.item_des LIKE '%".$ss."%' OR db_items.item_path LIKE '%".$ss."%'";
		$cadbusca2="SELECT * FROM db_items_cats WHERE db_items_cats.cat_status='1' AND db_items_cats.cat_nom LIKE '%".$ss."%' OR db_items_cats.cat_des LIKE '%".$ss."%'";
	} elseif ($ssc>1) { //Advance Search AGINST - MATCH in FULLTEXT db
		$cadbusca="SELECT item_id, cat_id, item_cod, item_aliasurl, item_nom, item_des, item_img, MATCH (item_cod, item_nom, item_des, item_path) AGAINST ('".$ss."') AS Score FROM db_items WHERE item_status='1' AND MATCH (item_cod, item_nom, item_des, item_path) AGAINST ('".$ss."') ORDER BY Score DESC";
		$cadbusca2="SELECT cat_id, typ_id, cat_nom, cat_aliasurl, cat_des, cat_img, MATCH (cat_nom, cat_des) AGAINST ('".$ss."') AS Score FROM db_items_cats WHERE cat_status='1' AND MATCH (cat_nom, cat_des) AGAINST ('".$ss."') ORDER BY Score DESC";
}
$result=mysql_query($cadbusca);
$result2=mysql_query($cadbusca2);
$totalRows_search= mysql_num_rows($result);
$totalRows_search2= mysql_num_rows($result2);
echo "Results. ".$totalRows_search.'-'.$totalRows_search2;
$noresults=FALSE;
?>
<ul class="breadcrumb" style="border: 1px solid #ddd;">
	<li><a href="#">Search</a> <span class="divider">/</span></li>
	<li class="active"><?php echo '"'.$ss.'"'; ?></li>
</ul>
<!-- BEG VIEW RESULTS CATS -->
<div>
<?php 
if ($totalRows_search2>0) {
$noresults=TRUE;
while($row=mysql_fetch_object($result2)){
	$rid2=$row->cat_id;
	$ralias2=$row->cat_aliasurl;
	$rtyp2=$row->typ_id;
	$rnom2=$row->cat_nom;
	$rdes2link=$row->cat_des;
	$rdes2 = strip_tags(substr($rdes2link,0,200));
	$rimage2=$row->cat_img;

    $filename = $RAIZidbC.$rimage2;
	if (($rimage2)&&(file_exists($filename))) $rcatimg='<a class="pull-left" href="'.$RAIZidbC.$rimage2.'" rel="shadowbox[Results]" title="'.$rcodigo.'"><img src="'.$RAIZidbC.$rimage2.'" class="media-object img-polaroid img-ressi" /></a>';
	if($rtyp2==5){
		$rlinkc=$rdes2link;
		$rcatlink='<a href="'.$rlinkc.'" target="_blank">'.$rnom2.' <i class="icon-resize-full"></i></a>';
	}else{
		$rlinkc=$RAIZ.'category/'.$ralias2;
		$rcatlink='<a href="'.$rlinkc.'">'.$rnom2.'</a>';
	}
	
	$isView=verifyCatContHistory($rid2);
	if($isView){
?>
<div class="media reesc">
	<?php echo $rcatimg ?>
    <span class="pull-right res-trademark"><?php echo dtrademark($rid2,'image') ?></span>
	<div class="media-body">
		<h4 class="media-heading"><?php echo $rcatlink; ?></h4>
		<div><?php echo $rdes2 ?> ...</div>
	</div>
</div>
<?php }

} } ?>
</div>
<!-- END VIEW EWSULTS CATS -->
<!-- BEG VIEW RESULTS ITEMS -->
<div>
<?php 
if ($totalRows_search>0) {
$noresults=TRUE;
while($row=mysql_fetch_object($result)){
	//Item Detaills
	$rid=$row->item_id;
	$ralias=$row->item_aliasurl;
	$rcatid=$row->cat_id;
	$rcodigo=$row->item_cod;
	$rtitulo=$row->item_nom;
	$rdes=$row->item_des;
	$rdes = strip_tags(substr($rdes,0,200));
	$rimage=$row->item_img;
	$rcattyp=detRow('db_items_cats','cat_id',$rcatid);// Category Item Detaills

if($rcattyp["typ_id"]==6){
    $ritemimg='<a class="pull-left" href="'.$RAIZ.'frame.php?cod='.$rcodigo.'" rel="shadowbox[Results]; width=680; height=330" title="'.$rcodigo.'">
	<img src="'.$RAIZidbF_s.$rcodigo.".jpg".'" class="media-object img-polaroid img-ressf"/></a>';
	$rlink=$RAIZ.'category/'.$rcattyp['cat_aliasurl'];
	$ritemlink='<a href="'.$rlink.'">'.$rcodigo.'</a>'.' <small><a href="'.$rlink.'" class="text-success">'.$rcattyp['cat_nom'].'</a></small>';
}else{
    $ritemimg='<a class="pull-left" href="'.$RAIZidbP.$rimage.'" rel="shadowbox[Results]" title="'.$rcodigo.'">
	<img src="'.$RAIZidbP."t_".$rimage.'" class="media-object img-polaroid img-ressi"/></a>';
	$rlink=$RAIZ.'product/'.$ralias;
	$rlinkc=$RAIZ.'category/'.$rcattyp['cat_aliasurl'];
	$ritemlink='<a href="'.$rlink.'">'.$rcodigo.'</a>'.' <small><a href="'.$rlinkc.'" class="text-success">'.$rcattyp["cat_nom"].'</a></small>';
}

$isView=verifyCatContHistory($rcatid);
if($isView){
?>
<div class="media reesc">
	<?php echo $ritemimg ?>
    <span class="pull-right res-trademark"><?php echo dtrademark($rcattyp['cat_id'],'image') ?></span>
	<div class="media-body">
		<h4 class="media-heading"><?php echo $ritemlink; ?></h4>
		<div><?php echo $rdes ?> ...</div>
	</div>
</div>
<?php }
} } ?>
</div>
<!-- END VIEW EWSULTS ITEMS -->
<?php
if($noresults==FALSE){
	echo '<div class="alert"><button type="button" class="close" data-dismiss="alert">×</button><strong>Warning!</strong> No Find Results !</div>';
}
}else{
	echo '<div class="alert alert-error"><strong>Error!</strong> Must enter a search term.</div>';
} ?>
</div>