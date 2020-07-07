<?php
$iditemhide='-1';
if (isset($_GET['iditem'])) {$iditemhide = $_GET['iditem'];}
$query_RS_topprod = sprintf("SELECT * FROM db_items WHERE item_id <> %s AND item_status = '1' ORDER BY item_hits DESC LIMIT 8",
	GetSQLValueString($iditemhide, "int"));
$RS_topprod = mysql_query($query_RS_topprod) or die(mysql_error());
$row_RS_topprod = mysql_fetch_assoc($RS_topprod);
?>
<div class="panel panel-neutro">
	<div class="panel-heading">POPULAR PRODUCTS</div>
    <div class="panel-body">
    
    <ul class="nav nav-list" style="margin:0;">
	<?php do { ?>
		<li class="text-center">
			<a href="<?php echo $RAIZ?>product/<?php echo $row_RS_topprod['item_aliasurl']; ?>" class="thumbnail" style="background: #fff;">
			<div class="caption"><small><?php echo $row_RS_topprod['item_cod']; ?></small></div>
            <img src="<?php echo $RAIZidbP."t_".$row_RS_topprod['item_img']; ?>" alt="<?php echo $row_RS_topprod['item_nom']; ?>" style="max-width:100px;" class="img-rounded"/>
			</a>
		</li>
	<?php } while ($row_RS_topprod = mysql_fetch_assoc($RS_topprod)); ?>
	</ul>
    
    </div>
</div>

<?php mysql_free_result($RS_topprod);?>