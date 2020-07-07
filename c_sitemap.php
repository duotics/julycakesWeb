<?php
$query_RS_menu_cats0 = "SELECT cat_id, typ_id, cat_nom, cat_aliasurl, cat_des FROM db_items_cats WHERE cat_id_parent = 0";
$RS_menu_cats0 = mysql_query($query_RS_menu_cats0) or die(mysql_error());
$row_RS_menu_cats0 = mysql_fetch_assoc($RS_menu_cats0);
$totalRows_RS_menu_cats0 = mysql_num_rows($RS_menu_cats0);
?>
<div class="well">
<h1 class="text-error">Sitemap</h1>
<ul>
	<li><a href="<?php echo $RAIZ ?>">Home</a></li>
	<li><a href="<?php echo $RAIZ ?>center/special">Special</a></li>
	<li><a href="<?php echo $RAIZ ?>center/learning">Learning Center</a></li>
    <li><a href="<?php echo $RAIZ ?>center/news">Learning Center</a></li>
    <li><a href="<?php echo $RAIZ ?>center/videos">Videos</a></li>
<?php do { //BEG DO-WHILE 001?>
    <li><?php echo fnc_typlink($row_RS_menu_cats0['cat_id'], $row_RS_menu_cats0['cat_nom'], $row_RS_menu_cats0['cat_aliasurl'],$row_RS_menu_cats0['cat_des'], $row_RS_menu_cats0['typ_id']);?>
	<?php
	$query_RS_menu_catsX = "SELECT cat_id, typ_id, cat_nom, cat_aliasurl, cat_des FROM db_items_cats WHERE cat_id_parent =".$row_RS_menu_cats0['cat_id'];
	$RS_menu_catsX = mysql_query($query_RS_menu_catsX, $conn) or die(NULL);
	$row_RS_menu_catsX = mysql_fetch_assoc($RS_menu_catsX);
	$totalRows_RS_menu_catsX = mysql_num_rows($RS_menu_catsX); ?>
	<?php if($totalRows_RS_menu_catsX>0) { //BEG IF 001?>
	<ul>
	<?php do { //BEG DO-WHILE 002?>
		<?php if($row_RS_menu_catsX['cat_nom']){ //BEG IF 002?>
            <li><?php echo fnc_typlink($row_RS_menu_catsX['cat_id'], $row_RS_menu_catsX['cat_nom'], $row_RS_menu_catsX['cat_aliasurl'], $row_RS_menu_catsX['cat_des'], $row_RS_menu_catsX['typ_id']); ?>
            
		<?php } //END IF 002 ?>
		<?php $query_RS_menu_catsY = "SELECT cat_id, typ_id, cat_nom, cat_aliasurl, cat_des FROM db_items_cats WHERE cat_id_parent =".$row_RS_menu_catsX['cat_id'];
		$RS_menu_catsY = mysql_query($query_RS_menu_catsY, $conn) or die(NULL);
		$row_RS_menu_catsY = mysql_fetch_assoc($RS_menu_catsY);
		$totalRows_RS_menu_catsY = mysql_num_rows($RS_menu_catsY);?>
        
		<?php if($totalRows_RS_menu_catsY>0){ //BEG IF 003?>
		<ul>
		<?php do { //BEN DO-WHILE 003 ?>
			<?php if($row_RS_menu_catsY['cat_nom']){ //BEG IF 004?>
            	<li><?php echo fnc_typlink($row_RS_menu_catsY['cat_id'], $row_RS_menu_catsY['cat_nom'], $row_RS_menu_catsY['cat_aliasurl'], $row_RS_menu_catsY['cat_des'], $row_RS_menu_catsY['typ_id']);?></li>
			<?php } //END IF 004?>
		<?php }while ($row_RS_menu_catsY = mysql_fetch_assoc($RS_menu_catsY)); //END DO-WHILE 003?>
		</ul></li>
		<?php } //END IF 003?>
	<?php } while ($row_RS_menu_catsX = mysql_fetch_assoc($RS_menu_catsX)); //END DO-WHILE 002?>
	</ul></li>
<?php } //END IF 001?>
<?php } while ($row_RS_menu_cats0 = mysql_fetch_assoc($RS_menu_cats0)); //END DO-WHILE 001?>
<li><a href="<?php echo $RAIZ ?>contact.php">Contact</a></li>
</ul>
</div>