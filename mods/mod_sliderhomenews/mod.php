<?php
//LAST ARTICLE IN CAT NEWS
$query_RSa0 = sprintf("SELECT * FROM tbl_articles WHERE cat_id = %s ORDER BY art_id DESC LIMIT 1",
GetSQLValueString("7", "int"));
$RSa0 = mysql_query($query_RSa0) or die(mysql_error());
$row_RSa0 = mysql_fetch_assoc($RSa0);
$totalRows_RSa0 = mysql_num_rows($RSa0);
//LAST ARTICLE IN CAT LEARNING
$query_RSa1 = sprintf("SELECT * FROM tbl_articles WHERE cat_id = %s ORDER BY art_id DESC LIMIT 1",
GetSQLValueString("3", "int"));
$RSa1 = mysql_query($query_RSa1) or die(mysql_error());
$row_RSa1 = mysql_fetch_assoc($RSa1);
$totalRows_RSa1 = mysql_num_rows($RSa1);
//LAST ARTICLE IN CAT SPECIALS
$query_RSa2 = sprintf("SELECT * FROM tbl_articles WHERE cat_id = %s ORDER BY art_id DESC LIMIT 1",
GetSQLValueString("2", "int"));
$RSa2 = mysql_query($query_RSa2) or die(mysql_error());
$row_RSa2 = mysql_fetch_assoc($RSa2);
$totalRows_RSa2 = mysql_num_rows($RSa2);

//PROD MOST POPULAR
$query_RSp1 = sprintf("SELECT * FROM db_items WHERE item_status = %s ORDER BY item_hits DESC LIMIT 1",
GetSQLValueString("1", "int"));
$RSp1 = mysql_query($query_RSp1) or die(mysql_error());
$row_RSp1 = mysql_fetch_assoc($RSp1);
$totalRows_RSp1 = mysql_num_rows($RSp1);

//RANDOM PRODUCT
$query_RSp2 = sprintf("SELECT * FROM db_items WHERE item_status = %s AND item_id<>%s AND item_img<>'' ORDER BY RAND() LIMIT 1;",
GetSQLValueString("1", "int"),
GetSQLValueString($row_RSp1['item_id'], "int"));
$RSp2 = mysql_query($query_RSp2) or die(mysql_error());
$row_RSp2 = mysql_fetch_assoc($RSp2);
$totalRows_RSp2 = mysql_num_rows($RSp2);

//PROD NUEVO
$query_RS_p3 = sprintf("SELECT * FROM db_items WHERE item_status = %s ORDER BY item_id DESC LIMIT 1",
GetSQLValueString("1", "int"));
$RS_p3 = mysql_query($query_RS_p3) or die(mysql_error());
$row_RS_p3 = mysql_fetch_assoc($RS_p3);
$totalRows_RS_p3 = mysql_num_rows($RS_p3);

$btnView='<span class="btn btn-default"><i class="fa fa-eye"></i> View</span>';

$RAIZidb_art=$RAIZidb.'articles/';
$RAIZidb_item=$RAIZi.'items/';

mysql_free_result($RSa1);
mysql_free_result($RSa2);
mysql_free_result($RSp1);
mysql_free_result($RSp2);
?>
<div style="margin-bottom:10px;">
<div id="myCarousel2" class="carousel slide carousel-home" data-ride="carousel">
	<!--
    <ol class="carousel-indicators">
		<li data-target="#myCarousel2" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel2" data-slide-to="1"></li>
		<li data-target="#myCarousel2" data-slide-to="2"></li>
		<li data-target="#myCarousel2" data-slide-to="3"></li>
		<li data-target="#myCarousel2" data-slide-to="4"></li>
	</ol>
    -->
	<!-- Carousel items -->
	<div class="carousel-inner text-center">
		<!-- EVENT -->
        <div class="item item-slider-mod">
        <a href="<?php echo $RAIZ.'special/'.$row_RSa2['art_url'] ?>">
        	<div class="panel panel-default panel-carousel">
            <div class="panel-heading"><span class="label label-danger"><i class="fa fa-star-o"></i> PROMO</span>
			<?php echo $row_RSa2['title'] ?></div>
        	<div class="panel-body">
            <img src="<?php echo $RAIZidb_art.$row_RSa2['image'] ?>"  alt="<?php echo $row_RSa2['title'] ?>" class="carousel-slide-img"/>
            </div>
            </div>
        </a>
        </div>
        <div class="active item item-slider-mod">
        <a href="<?php echo $RAIZ ?>center/event">
        	<div class="panel panel-default panel-carousel">
            <div class="panel-heading"><span class="label label-danger"><i class="fa fa-star-o"></i> News</span>
			<?php echo $row_RSa0['title'] ?></div>
        	<div class="panel-body">
            <img src="<?php echo $RAIZidb_art.$row_RSa0['image'] ?>"  alt="<?php echo $row_RSa0['title'] ?>" class="carousel-slide-img"/>
            </div>
           </div>
        </a>
        </div>
        <!--LEARNING-->
        <!--
        <div class="item item-slider-mod">
        <a href="<?php echo $RAIZ ?>center/learning">
        	<div class="panel panel-default panel-carousel">
            <div class="panel-heading"><span class="label label-danger"><i class="fa fa-star-o"></i> Learning</span>
			<?php echo $row_RSa1['title'] ?></div>
        	<div class="panel-body">
            <img src="<?php echo $RAIZidb_art.$row_RSa1['image'] ?>"  alt="<?php echo $row_RSa1['title'] ?>" class="carousel-slide-img"/>
            </div>
           </div>
        </a>
        </div>
        -->
        <!-- PROD NUEVO -->
        <div class="item item-slider-mod">
        <a href="<?php echo $RAIZ ?>product/<?php echo $row_RS_p3['item_aliasurl'] ?>">
        	<div class="panel panel-default panel-carousel">
            <div class="panel-heading"><span class="label label-danger"><i class="fa fa-star-o"></i> NEW</span> 
			<?php echo $row_RS_p3['item_nom'] ?></div>
        	<div class="panel-body">
            <img src="<?php echo $RAIZidb_item.$row_RS_p3['item_img'] ?>"  alt="<?php echo $row_RS_p3['item_cod'] ?>" class="carousel-slide-img"/>
            </div>
            </div>
        </a>
        </div>
        <!-- PROD POPULAR -->
		<div class="item item-slider-mod">
        <a href="<?php echo $RAIZ ?>product/<?php echo $row_RSp1['item_aliasurl'] ?>">
        	<div class="panel panel-default panel-carousel">
            <div class="panel-heading"><span class="label label-danger"><i class="fa fa-star-o"></i> POPULAR</span> 
			<?php echo $row_RSp1['item_nom'] ?></div>
        	<div class="panel-body">
            <img src="<?php echo $RAIZidb_item.$row_RSp1['item_img'] ?>" alt="<?php echo $row_RSp1['item_cod'] ?>" class="carousel-slide-img"/>
            </div>
            </div>
        </a>
        </div>
        <!-- PROD RANDOM -->
		<!--
        <div class="item item-slider-mod">
        <a href="<?php echo $RAIZ ?>product/<?php echo $row_RSp2['item_aliasurl'] ?>">
        	<div class="panel panel-default" style="margin-bottom:0px;">
            <div class="panel-heading"><?php echo $row_RSp2['item_nom'] ?></div>
        	<div class="panel-body text-center">
            <img src="<?php echo $RAIZidb_item.$row_RSp2['item_img'] ?>"  alt="<?php echo $row_RSp2['item_cod'] ?>" class="carousel-slide-img"/>
            </div>
            </div>
        </a>
        </div>
        -->
	</div>    
    <!-- Controls -->
  <a class="left carousel-control" href="#myCarousel2" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#myCarousel2" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
    
</div>
</div>