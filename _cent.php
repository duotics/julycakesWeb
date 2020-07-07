<?php
$c_url=vParam('c_url', $_GET['c_url'], $_POST['c_url']); //parametro enviado es el URL de db_items_type
$detCat=detRow('tbl_articles_cat','cat_url',$c_url);
$idCat=$detCat['cat_id'];
//ARTICULO PRINCIPAL [1]
$qryaP=sprintf('SELECT * FROM tbl_articles WHERE cat_id=%s AND status=1 ORDER BY art_id DESC LIMIT 1',
GetSQLValueString($idCat,'int'));
$RSaP=mysql_query($qryaP);
$row_RSaP=mysql_fetch_assoc($RSaP);
$tr_RSaP=mysql_num_rows($RSaP);

//ARTICULOS SECUNDARIOS [2]
$qryaS=sprintf('SELECT * FROM tbl_articles WHERE cat_id=%s AND status=1 ORDER BY art_id DESC LIMIT 1,2',
GetSQLValueString($idCat,'int'));
$RSaS=mysql_query($qryaS);
$row_RSaS=mysql_fetch_assoc($RSaS);
$tr_RSaS=mysql_num_rows($RSaS);

//ARTICULOS TERCIARIOS [3]
$qryaT=sprintf('SELECT * FROM tbl_articles WHERE cat_id=%s AND status=1 ORDER BY art_id DESC LIMIT 3,3',
GetSQLValueString($idCat,'int'));
$RSaT=mysql_query($qryaT);
$row_RSaT=mysql_fetch_assoc($RSaT);
$tr_RSaT=mysql_num_rows($RSaT);

//ARTICULOS CUATERNARIOS [50]
$qryaC=sprintf('SELECT * FROM tbl_articles WHERE cat_id=%s AND status=1 ORDER BY art_id DESC LIMIT 6,44',
GetSQLValueString($idCat,'int'));
$RSaC=mysql_query($qryaC);
$row_RSaC=mysql_fetch_assoc($RSaC);
$tr_RSaC=mysql_num_rows($RSaC);



?>
<div class="well well-sm" style="background:#FFF">
	<div class="">
    <h1><small>BLOG</small> <?php echo $detCat['cat_nom'] ?> <?php echo $detCat['cat_icon'] ?></h1>
    </div>
    <hr>
    <div class="row">
    	<div class="col-sm-8">
			<?php if($tr_RSaP>0){ ?>
            <?php $apUrl=$RAIZ.$detCat['cat_url'].'/'.$row_RSaP['art_url'];
			$apImg=$RAIZidb.'articles/'.$row_RSaP['image']; ?>
            <div class="panel panel-primary">
            	<div class="panel-heading"><span class="pull-right label label-danger">NEW</span>
				<a href="<?php echo $apUrl ?>" style="color:#FFFFFF">
                <h3 class="panel-title"><?php echo $row_RSaP['title']?></h3>
                </a></div>
                <div class="panel-body text-center" style="overflow:hidden">
                	<a href="<?php echo $apUrl ?>">
                    <img src="<?php echo $apImg ?>" style="max-height:500px">
                    </a>
                </div>
                <div class="panel-footer">
                <span class="pull-right label label-default"><?php echo $row_RSaP['dcreate'] ?></span>
                <span class="pull-right label label-default">Views <?php echo $row_RSaP['hits'] ?></span>
                <div class="btn-group">
                	<a href="<?php echo $apUrl ?>" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> View Article</a>
                    <a href="<?php echo $apUrl ?>#comments" class="btn btn-default btn-sm"><i class="fa fa-comments"></i> Comments</a>
                </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="col-sm-4">
        <?php if($tr_RSaS>0){ ?>
		<?php do{ ?>
        <?php
        $asUrl=$RAIZ.$detCat['cat_url'].'/'.$row_RSaS['art_url'];
		$asImg=$RAIZidb.'articles/t_'.$row_RSaS['image'];
		?>
        <div class="panel panel-info">
        	<div class="panel-heading">
			<a href="<?php echo $asUrl ?>" style="color:#FFFFFF">
			<?php echo $row_RSaS['title']?>
            </a>
            </div>
            <div class="panel-body text-center">
            <a href="<?php echo $asUrl ?>">
            <img src="<?php echo $asImg ?>" class="img-responsive">
            </a>
            
            <span class="label label-default"><?php echo $row_RSaS['dcreate'] ?></span>
            <span class="label label-default">Views <?php echo $row_RSaS['hits'] ?></span>
            
            </div>
            <div class="panel-footer">
            <div class="btn-group">
                	<a href="<?php echo $asUrl ?>" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> View Article</a>
                    <a href="<?php echo $asUrl ?>#comments" class="btn btn-default btn-sm"><i class="fa fa-comments"></i> Comments</a>
                </div>
            </div>
        </div>
		<?php }while($row_RSaS = mysql_fetch_assoc($RSaS)); ?>
        <?php } ?>
        </div>
	</div>

    <?php if($tr_RSaT>0){ ?>
    <div class="row">
	<?php do{ ?>
    <?php
	$atUrl= $RAIZ.$detCat['cat_url'].'/'.$row_RSaT['art_url'];
	$atImg=$RAIZidb.'articles/t_'.$row_RSaT['image'];
	?>
		<div class="col-sm-4">
			<div class="panel panel-default">
            	<div class="panel-heading"><small><?php echo $row_RSaT['title']?></small></div>
                <div class="panel-body" style="overflow:hidden;">
                <a href="<?php echo $atUrl ?>">
                	<img src="<?php echo $atImg ?>" class="img-responsive" style="height:150px; margin: 0 auto;">
              	</a>
                <span class="label label-default"><?php echo $row_RSaT['dcreate'] ?></span>
            <span class="label label-default">Views <?php echo $row_RSaT['hits'] ?></span>
                </div>
            	<div class="panel-footer">
                
                <div class="btn-group">
                	<a href="<?php echo $atUrl ?>" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> View Article</a>
                    <a href="<?php echo $atUrl ?>#comments" class="btn btn-default btn-xs"><i class="fa fa-comments"></i> Comments</a>
                </div>
                
                </div>
            </div>
			
            </div>
    <?php }while($row_RSaT = mysql_fetch_assoc($RSaT)); ?>
	</div>

    <?php } ?>
    <?php if($tr_RSaC>0){ ?>
    <div class="panel panel-default">
    	<div class="panel-heading"><h3 class="panel-title">More <?php echo $detCat['cat_nom'] ?></h3></div>
        <div class="panel-body">
        
        <div class="row">
			<?php $contMorArt=0; ?>
			<?php do{ ?>
            <?php $acUrl=$RAIZ.$detCat['cat_url'].'/'.$row_RSaC['art_url'];
			$acImg=$RAIZidb.'articles/t_'.$row_RSaC['image'];
			?>
            <div class="col-sm-6">
              
              <div class="panel panel-default">
              <div class="panel-body">
              <div class="media">
  <a class="pull-left" href="<?php echo $acUrl ?>">
    <img src="<?php echo $acImg ?>" style="width:120px; height:90px" class="media-object">
  </a>
  <div class="media-body">
    <span class="label label-default"><?php echo $row_RSaC['dcreate'] ?></span>
    <small><?php echo $row_RSaC['title']?></small>
    <br>
    
	<div class="btn-group">
        <a href="<?php echo $acUrl ?>" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> View Article</a>
        <a href="<?php echo $acUrl ?>#comments" class="btn btn-default btn-xs"><i class="fa fa-comments"></i> Comments</a>
    </div>
	
  </div>
</div>
              </div>
              </div>


            </div>
            <?php $contMorArt++;
			if($contMorArt==2){
				$contMorArt=0;
				echo '<div class="clearfix"></div>';
			}
			?>
            <?php }while($row_RSaC = mysql_fetch_assoc($RSaC)); ?>
		</div>
        
        </div>
        
    </div>
    <?php } ?>
</div>
<?php
mysql_free_result($RSaP);
mysql_free_result($RSaS);
mysql_free_result($RSaT);
?>