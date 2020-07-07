<?php //BRANDS
$qryB=sprintf('SELECT * FROM db_items_brands WHERE status=1 AND url<>"var"  ORDER BY name ASC');
$RSb=mysql_query($qryB) or die (mysql_error());
$dRSb=mysql_fetch_assoc($RSb);
?>
<div class="slickSlider">
<?php do{ ?>
	<div style="margin:0px 1px;" class="text-center">
		<a href="<?php echo $RAIZ.'brand/'.$dRSb['url']; ?>">
			<img class="img-thumbnail" src="<?php echo $RAIZi.'brand/t_'.$dRSb['img'] ?>" style="max-height:100px;"/>
		</a>
	</div>
	<?php }while($dRSb=mysql_fetch_assoc($RSb)); ?>
</div>
<?php mysql_free_result($RSb); ?>