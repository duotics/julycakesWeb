<div class="well contGen">
<?php
$ss=$_GET['ss'];
$sort=$_GET['s'];

switch($sort){
	case "top":
		$qsort=" ORDER BY db_items.item_hits DESC";
		break;
	default:
		$qsort=" ORDER BY db_items.item_id DESC";
}

if ($ss<>''){// IF STRING SEARCH EXITS
	$sse=explode(" ",$ss); //Divide Search string each " " (space)
	$ssc=count($sse); //Count Number of words in ssq **************** OJO OJO Aqui es para establecer el numero de cadenas para search con like o against ************
	/****************************************************************************************/
	if ($ssc==1) { //Search with Like
		//echo '<p>1 Param</p>';
		$ssq='%'.$ss.'%';
		$qryA=sprintf("SELECT 
db_items.item_id AS i_id, db_items.item_aliasurl AS i_url, 
db_items.item_cod AS i_cod, db_items.item_nom AS i_nom, db_items.item_des AS i_des, 
db_items.item_hits AS i_hits, db_items.item_date AS i_date,  
db_items.item_date AS i_date, db_items.item_img AS i_img, db_items.item_status AS i_stat, 
db_items_brands.id AS b_id, db_items_brands.url AS b_url, 
db_items_brands.name AS b_nom, 
db_items_brands.img AS b_img, db_items_brands.status AS b_stat, 
db_items_type.typID AS c_id, db_items_type.typUrl AS c_url, 
db_items_type.typNom AS c_nom,  db_items_type.typImg AS c_img, db_items_type.typEst AS c_stat 
FROM db_items 
LEFT JOIN db_items_type_vs 
ON db_items.item_id = db_items_type_vs.item_id 
LEFT JOIN db_items_type 
ON db_items_type_vs.typID=db_items_type.typID 
LEFT JOIN db_items_brands
ON db_items.brand_id = db_items_brands.id
WHERE 
(db_items.item_status=1 AND db_items_type.typEst=1 AND db_items_brands.status=1) 
AND 
(db_items.item_cod LIKE %s OR db_items.item_nom LIKE %s OR db_items.item_des LIKE %s OR
db_items_brands.name LIKE %s OR db_items_type.typNom LIKE %s) %s LIMIT 250",
		GetSQLValueString($ssq,'text'),
		GetSQLValueString($ssq,'text'),
		GetSQLValueString($ssq,'text'),
		GetSQLValueString($ssq,'text'),
		GetSQLValueString($ssq,'text'),
		GetSQLValueString($qsort,''));
		//$cadbusca2="SELECT * FROM db_items_type WHERE db_items_type.typEst='1' AND db_items_type.typNom LIKE '%".$ss."%' OR db_items_type.typDes LIKE '%".$ss."%'";
	} elseif ($ssc>1) { //Advance Search AGINST - MATCH in FULLTEXT db
		//echo '<p>Multi Param</p>';
		$qryA=sprintf('SELECT 
db_items.item_id AS i_id, db_items.item_aliasurl AS i_url, 
db_items.item_cod AS i_cod, db_items.item_nom AS i_nom, db_items.item_des AS i_des, 
db_items.item_hits AS i_hits, db_items.item_date AS i_date,  
db_items.item_date AS i_date, db_items.item_img AS i_img, db_items.item_status AS i_stat, 
db_items_brands.id AS b_id, db_items_brands.url AS b_url, 
db_items_brands.name AS b_nom, 
db_items_brands.img AS b_img, db_items_brands.status AS b_stat, 
db_items_type.typID AS c_id, db_items_type.typUrl AS c_url, 
db_items_type.typNom AS c_nom,  db_items_type.typImg AS c_img, db_items_type.typEst AS c_stat , 
MATCH (db_items.item_cod, db_items.item_nom, db_items.item_des, db_items.item_aliasurl, db_items.item_path, db_items.item_ref) AGAINST (%s) AS Score FROM db_items 
LEFT JOIN db_items_type_vs 
ON db_items.item_id = db_items_type_vs.item_id 
LEFT JOIN db_items_type 
ON db_items_type_vs.typID=db_items_type.typID 
LEFT JOIN db_items_brands
ON db_items.brand_id = db_items_brands.id
WHERE item_status="1" AND MATCH (db_items.item_cod, db_items.item_nom, db_items.item_des, db_items.item_aliasurl, db_items.item_path, db_items.item_ref) AGAINST (%s) ORDER BY Score DESC LIMIT 250',
GetSQLValueString($ss,'text'),
GetSQLValueString($ss,'text'));
		
}
//echo $qryA.'<hr>'.mysql_error();
$RSi=mysql_query($qryA);
$dRSi=mysql_fetch_assoc($RSi);
//$RSi2=mysql_query($cadbusca2);
$trRSi= mysql_num_rows($RSi);
//$trS2= mysql_num_rows($RSi2);
$noRSis=FALSE;
?>
<div class="row">
	<div class="col-sm-8">
    <span class="pull-right label label-default" style="margin:10px;">Results <strong><?php echo $trRSi+$trS2 ?></strong></span>
    <ul class="breadcrumb">
		<li><a href="<?php echo $RAIZ ?>">home</a></li>
		<li class="active">Search <span class="text-warning"><strong><?php echo $ss ?></strong></span></li>
	</ul>
    </div>
    <div class="col-sm-4 text-right">
    <form class="form-inline">
		<div class="form-group" style="padding-left:10px">
        	<label><i class="fa fa-sort fa-lg text-muted"></i> Sorted By</label>
            <select class="form-control input-sm" id="selSort">
                <option value="new" <?php if($sort=='new') echo 'selected' ?>>Newest Arrivals</option>
                <option value="top" <?php if($sort=='top') echo 'selected' ?>>Most Popular</option>
            </select>
        </div>
    </form>
    </div>
</div>


<!-- BEG VIEW RESULTS ITEMS -->
<div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#selSort').change(function(){
			var url=RAIZ+'search.php?ss='+'<?php echo $ss?>'+'&s='+$('#selSort').val();
			location.href=url;
		});
	});
</script>
<?php 
if($trRSi>0) { //BEG $trRSi>0
$noRSis=TRUE;
do{
	//echo '<small><span class="label label-default">'.$dRSi['Score'].'</span></small>';
	$dRSi_des = strip_tags(substr($dRSi['i_des'],0,225)).' <strong>...</strong>';
	$dRSi_imgi=vImg('images/items/',$dRSi['i_img']);
	$dRSi_imgb=vImg('images/brand/',$dRSi['b_img']);
	$link_i=$RAIZ.'p/'.$dRSi['c_url'].'/'.$dRSi['i_url'];
	$link_c=$RAIZ.'c/'.$dRSi['c_url'];
	$link_b=$RAIZ.'brand/'.$dRSi['b_url'];
	$infoNP=NULL;
	if(vrfNew($dRSi['i_date'],120)) $infoNP='<span class="label label-danger"><i class="fa fa-star"></i> New Product</span>';
?>
<div class="media media-search">
  <div class="media-left">
    <a href="<?php echo $link_i ?>">
      <img class="media-object img-md" src="<?php echo $dRSi_imgi['t'] ?>">
    </a>
  </div>
  <div class="media-body">
    <h4 class="media-heading">
    	<a href="<?php echo $link_i ?>"><?php echo $dRSi['i_nom'] ?></a> 
    	<a href="<?php echo $link_c ?>"><small><?php echo $dRSi['c_nom'] ?></small></a>
    </h4>
	  <div>
	  <?php echo $infoNP ?>
	  <span class="label label-default">Code</span> <span class="label label-default"><?php echo $dRSi['i_cod'] ?></span> 
      <span class="label label-default">Hits <?php echo $dRSi['i_hits'] ?></span>
	  </div>
    <p class="hidden-xs" style="padding:10px 10px 0 0;"><?php echo $dRSi_des ?> <a href="<?php echo $link_i ?>"><small>Read More</small></a></p>
  </div>
  <div class="media-right">
    <a href="<?php echo $link_b ?>">
      <img class="media-object thumbnail img-sm" src="<?php echo $dRSi_imgb['t'] ?>">
    </a>
  </div>
</div>

<?php
}while($dRSi=mysql_fetch_assoc($RSi));
}//END $trRSi>0 ?>
</div>
<!-- END VIEW EWSULTS ITEMS -->
<!-- ***************************************************** -->
<!-- ***************************************************** -->
<?php
if($noRSis==FALSE){
	echo '<div class="alert"><button type="button" class="close" data-dismiss="alert">×</button><strong>Warning!</strong> No Find Results !</div>';
}
}else{
	echo '<div class="alert alert-error"><strong>Error!</strong> Must enter a search term.</div>';
} ?>
</div>