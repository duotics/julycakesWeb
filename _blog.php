<?php
$c_url=vParam('c_url', $_GET['c_url'], $_POST['c_url']); //parametro enviado es el URL de db_items_type
$s=vParam('s', $_GET['s'], $_POST['s']); //parametro enviado es el URL de db_items_type
$page=vParam('page', $_GET['page'], $_POST['page']); //parametro enviado es el URL de db_items_type
if($c_url){
	$det=detRow('tbl_articles_cat','cat_url',$c_url);
	$img=$det[cat_img];
	$vImg=vImg('data/img/blogc/',$img,TRUE,'_t');
	if($vImg['s']) $styCover='style="background-image: url('.$RAIZ.'data/img/blogc/'.$det['cat_img'].'); background-size: cover; background-position: center;"';
	//$det_tit=$det['cat_nom'];
	$idCat=$det['cat_id'];
	$det_tit=getLangT('tbl_articles_cat','tit',$idCat,$_SESSION['lang']);
	$qParam=sprintf(" AND tbl_articles.cat_id=%s", SSQL($idCat,'int'));
}else{
	$det_tit='BLOG';
}
seoGoogleMetas($det_tit);
	
$qryT=sprintf('SELECT COUNT(*) as TR FROM tbl_articles WHERE status=1 %s ORDER BY art_id DESC',
	SSQL($qParam,''));
$RST=mysqli_query($conn,$qryT);
$dRST=mysqli_fetch_assoc($RST);
$trRST=$dRST['TR'];
if($trRST>0){
if((!$page)||($page==1)){
	$vFeat=TRUE;
}
$pages = new Paginator();
$pages->items_total = $trRST;
$pages->mid_range = 8;
$pages->paginate();
$qrya=sprintf('SELECT tbl_articles.art_id AS a_id, tbl_articles.art_url AS a_url, tbl_articles.image AS a_img, tbl_articles.dcreate as a_date, tbl_articles.hits as a_hits, tbl_articles_cat.cat_nom AS c_nom, tbl_articles_cat.cat_url AS c_url FROM tbl_articles 
LEFT JOIN tbl_articles_cat ON tbl_articles.cat_id=tbl_articles_cat.cat_id WHERE tbl_articles.status=1 %s ORDER BY tbl_articles.art_id DESC %s',
	SSQL($qParam,''),
	SSQL($pages->limit,''));
$RSa=mysqli_query($conn,$qrya) or die (mysqli_error($conn));
$dRSa=mysqli_fetch_assoc($RSa);
$tRSa=mysqli_num_rows($RSa);
}
?>

<section id="pageCover" class="row blogPage" <?php echo $styCover ?>>
        <div class="wrapper pageCover-b">
        <div class="row pageTitle"><?php echo $det_tit?></div>
        <div class="row pageBreadcrumbs">
            <ol class="breadcrumb">
				<li><a href="<?php echo $RAIZ?>"><?php echo $lang[t][home]?></a></li>
				<li><a href="<?php echo $RAIZ?>blog/">Blog</a></li>
				<li class="active"><?php echo $det_tit?></li>
            </ol>
        </div>
		</div>
    </section>

<div class="container" style="clear:both;">
	<div class="row">
		<div class="col-xs-12 col-md-9">
            <div style="margin-bottom: 40px">
	<?php if($tRSa>0){ ?>
    <div class="bcont-la">
    	<?php do{ ?>
        <?php $aUrl=$RAIZ.'a/'.$dRSa['a_url'];
		$cUrl=$RAIZ.'blog/'.$dRSa['c_url'];
		$aImg=vImg('data/img/blog/',$dRSa['a_img']);
		
		$aDes=getLangT('tbl_articles','des',$dRSa[a_id],$_SESSION['lang']);
		
		$aSdes=NULL;
		
		if(isset($aDes)){
			$aSdes=strip_tags($aDes);
			if(strlen($aSdes)>150){
				$aSdes=substr($aSdes,0,150).' <strong>...</strong>';
			}
		}
		$aIconF=null;
		if($vFeat) $aIconF='<i class="far fa-star"></i>';
		$aTit=getLangT('tbl_articles','title',$dRSa[a_id],$_SESSION['lang']);
		//echo 'a_id. '.$dRSa[a_id].'<br>';
		?>
		   
		   
		<div class="row">
                        <div class="row m0 blog">
                            <div class="row m0 blogInner">
                                <div class="col-sm-6 p0">
                                    <div class="row m0 blogDateTime">
                                        <i class="fa fa-calendar"></i> <?php echo date("l, d F Y", strtotime($dRSa['a_date'])) ?>
                                    </div>
                                    <div class="row m0 featureImg">
                                        <a href="<?php echo $aUrl ?>">
                                            <img src="<?php echo $aImg[n] ?>" alt="Faceted Search Has Landed" class="img-responsive">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6 p0">
                                    <div class="row m0 postExcerpts">
                                        <div class="row m0 postExcerptInner">
                                            <a href="<?php echo $aUrl ?>" class="postTitle row m0"><h4><?php echo $aIconF ?><?php echo $aTit ?></h4></a>
                                            <p><?php echo $aSdes ?></p>
                                            <a href="<?php echo $aUrl ?>" class="readMore"><?php echo $lang[t][readm]?></a>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        
                        
                                                
                    </div>
		<?php }while($dRSa=mysqli_fetch_assoc($RSa)); ?>
	</div>
				
	
	<div class="row paginationRow m0">
		<div class="paginationInner m0 row">
			<ul class="pagination fleft"><?php echo $pages->display_pages(); ?></ul>
		</div>
	</div>
    <?php mysqli_free_result($RSa); ?>
	<?php }else{ ?>
    <div class="well">
    <h4>No Articles Found !</h4>
    </div>
	<?php } ?>
	
</div>
		</div>
		<div class="col-xs-12 col-md-3">
		<?php include(RAIZf.'rightBlog.php');?>
        </div>
	</div>
</div>