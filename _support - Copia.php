<?php
$qryLI=sprintf("SELECT db_items.item_id AS sID, CONCAT(db_items_brands.name,' ',db_items_type.typNom,' ',db_items.item_nom) AS sVAL 
FROM db_items_type_vs
LEFT JOIN db_items 
ON db_items_type_vs.item_id=db_items.item_id
LEFT JOIN db_items_type
ON db_items_type_vs.typID=db_items_type.typID
LEFT JOIN db_items_brands 
ON db_items.brand_id=db_items_brands.id
WHERE db_items.item_status=1");
$RSli = mysql_query($qryLI) or die(mysql_error());

$dataf=$_SESSION['dataf'];

$fPS['PN']=$dataf['txtPN'];
$fPS['SN']=$dataf['txtSN'];
$fPS['MS']=$dataf['txtMS'];
$cfPS=count($dataf['txtPN']);

?>
<div class="well contGen" >
	<div><?php sysmsg(); ?></div>
    <div class="bcont-tit">
    <a href="#" class="bcont-titm">Technical Support</a>
    <img src="<?php echo $RAIZi ?>struct/page-support-003.jpg" class="pull-right">
    <div style="padding:20px">

    <p class="lead">Welcome to Technical Support Center<br>
    Call Us Direct 305-882-0120 <br>
    Skype <i class="fa fa-skype fa-lg"></i> mercoframesonline</p>
    </div>
    </div>
    <div>
    
    </div>
        <div style="clear:both"></div>    
		<form name="contact_form" action="<?php echo $RAIZs ?>fnc/mail3.php" method="post">
          <input name="txtType" type="hidden" id="txtType" value="asupport" />
			<div class="row">
            	<div class="col-sm-6">
                <div class="panel panel-primary">
            	<div class="panel-heading">
                	<h4 class="panel-title"><span class="label label-default pull-right">Step <strong>1/3</strong></span> Contact information</h4>
                </div>
                <div class="panel-body">
                <fieldset>
            <div class="form-group">
				<input name="txtCompany" type="text" class="form-control" id="inputIcon" placeholder="Company" value="<?php echo $dataf['txtCompany']?>">
			</div>
            <div class="form-group">
				<input name="txtName" type="text" class="form-control" id="inputIcon2" placeholder="Name" value="<?php echo $dataf['txtName']?>" required/>
			</div>
            <div class="form-group">
				<input name="txtMail" type="text" class="form-control" id="inputIcon3" placeholder="Email" value="<?php echo $dataf['txtMail']?>" required/>
			</div>
			<div class="form-group">
				<input name="txtPhone" type="text" class="form-control" id="inputIcon" placeholder="Phone" value="<?php echo $dataf['txtPhone']?>">
			</div>
            
            </fieldset>
                </div>
            </div>
                </div>
                <div class="col-sm-6">
                <div class="panel panel-primary">
            	<div class="panel-heading">
                <h4 class="panel-title"><span class="label label-default pull-right">Step <strong>2/3</strong></span> Location information</h4>
                </div>
                <div class="panel-body">
                <fieldset>
            	<div class="control-group">
                	<div class="form-group">
                    	<input name="txtAdress" type="text" class="form-control" id="txtAdress" placeholder="Address" value="<?php echo $dataf['txtAdress']?>">
                    </div>
                    <div class="form-group">
                    	<input name="txtCity" type="text" class="form-control" id="txtCity" placeholder="City" value="<?php echo $dataf['txtCity']?>">
                    </div>
                    <div class="form-group">
                    	<input name="txtState" type="text" class="form-control" id="txtState" placeholder="State" value="<?php echo $dataf['txtState']?>">
                    </div>
                    <div class="form-group">
                    	<input name="txtZipcode" type="text" class="form-control" id="txtZipcode" placeholder="ZIP" value="<?php echo $dataf['txtZipcode']?>">
                    </div>
                    <div class="form-group">
                    	<input name="txtCountry" type="text" class="form-control" id="txtCountry" placeholder="Country" value="<?php echo $dataf['txtCountry']?>">
                    </div>
                </div>
			</fieldset>
                </div>
            </div>
                </div>
            </div>
            
            <div class="panel panel-danger">
            	<div class="panel-heading">
                	<h4 class="panel-title"><span class="label label-default pull-right">Step <strong>3/3</strong></span> Support Detaills</h4>
                </div>
                <div class="panel-body">
                <fieldset class="form-horizontal">
                <div class="form-group">
                	<label class="control-label col-sm-3">Invoice</label>
                    <div class="col-sm-9">
                    	<input type="number" name="txtInv" placeholder="N°" value="<?php echo $dataf['txtInv']?>" class="form-control" required/>
                    </div>
                </div>
                <div class="form-group">
                	<label class="control-label col-sm-3">Date of purchase</label>
                    <div class="col-sm-9">
                    	<input type="date" name="txtDP" placeholder="N°" value="<?php echo $dataf['txtDP']?>" class="form-control"/>
                    </div>
                </div>
                <script type="text/javascript">
				function btncPLC_rem(id){
					if($(".cLPc").length>1){
						$( "#spp_"+id ).remove();
					}else{
						alert("Must submit at least 1 product");
					}
				}
$(document).on('ready', function(){			
	$( "#addProdS" ).click(function() {
  		var countCLPc;
		countCLPc = $(".cLPc").length;
		countCLPc++;
		if(countCLPc<=4){
		$('#cLP').append(
    $('<div class="col-sm-6 cLPc" id="spp_'+countCLPc+'">').append(
		$('<div class="thumbnail">').append(
        	$('<input>').attr('type','text').attr('name','txtPN[]').attr('class','form-control').attr('placeholder','Product Name').attr('required','required').add(
        	$('<input>').attr('type','text').attr('name','txtSN[]').attr('class','form-control').attr('placeholder','Serial Number').attr('required','required').add(
        	$('<textarea>').attr('name','txtMS[]').attr('class','form-control').attr('placeholder','What seems to be the problem?').attr('required','required').add(
			$('<a>').attr('rel',countCLPc).attr('class','btn btn-default btn-xs btn-block').attr('onclick','btncPLC_rem('+countCLPc+')').append("Remove"
	)))))));
		}else alert('Max 4 Items Support');
	});
});
</script>
                <div class="well well-sm" style="padding:0; border:1px solid #fff;">
                
                
      <div style="border-bottom:1px solid #ccc; background:#fff">
      <a id="addProdS" class="btn btn-default btn-sm">
      <i class="fa fa-plus fa-lg"></i> Add Product</a>
    </div>          
	<div style="padding:10px;">
    <div class="row" id="cLP">
  
<?php if($rfPS>0){ ?>
<?php for ($rfPS=0; $rfPS<$cfPS; $rfPS++) {
	$ifPS=$rfPS+1;
?>
	<div class="col-sm-6 cLPc" id="spp_<?php echo $ifPS ?>">
    <div class="thumbnail">
      <input type="text" name="txtPN[]" placeholder="Product Name" value="<?php echo $fPS['PN'][$rfPS]?>" class="form-control" required/>
      <input type="text" name="txtSN[]" placeholder="Serial Number" value="<?php echo $fPS['SN'][$rfPS]?>" class="form-control" required/>
      <textarea name="txtMS[]" class="form-control" placeholder="What seems to be the problem?" required><?php echo $fPS['MS'][$rfPS]?></textarea>
      <a class="btn btn-default btn-xs btn-block" onClick="btncPLC_rem(<?php echo $ifPS?>)">Remove</a>
    </div>
  </div>
<?php } ?>
<?php }else{ ?>
	<div class="col-sm-6 cLPc" id="spp_1">
    <div class="thumbnail">
      <input type="text" name="txtPN[]" placeholder="Product Name" class="form-control" required/>
      <input type="text" name="txtSN[]" placeholder="Serial Number" class="form-control" required/>
      <textarea name="txtMS[]" class="form-control" placeholder="What seems to be the problem?" required></textarea>
      <a class="btn btn-default btn-xs btn-block" onClick="btncPLC_rem(1)">Remove</a>
    </div>
  </div>
<?php }	?>
</div>
	</div>
                
                </div>
                <div class="form-group">
                	<label class="control-label col-sm-3">Aditional Comments</label>
                    <div class="col-sm-9">
                    <textarea name="txtMessage" rows="3" class="form-control" id="txtMessage" placeholder="Message" required><?php echo $dataf['txtMessage']?></textarea>
                    </div>
                </div>
				</fieldset>
                
                <div class="well well-sm" style="margin-bottom:0px;">
          <div class="row">
          	<div class="col-sm-6">
            <div class="form-group text-center">
            <br>
           	<input name="input" type="checkbox" required/> Accept <a href="<?php echo $RAIZ?>data/about" target="_blank">Terms and Conditions</a>
            <br>
            <small class="text-muted">You IP. <?php echo getRealIP() ?></small>
            </div>
            </div>
            <div class="col-sm-6">
            <div class="text-center">
			<div class="g-recaptcha" data-sitekey="6LcCKfsSAAAAAJGiZGUZSiFyM8UjgCRLP5C_WAjY"></div>
		</div>
        	</div>
          </div>
          
          
            </div>
            
                </div>
                <div class="panel-footer">
                <button type="submit" class="btn btn-large btn-block btn-danger">
                <i class="fa fa-envelope fa-lg"></i> &nbsp;&nbsp; Send Technical Support
                </button>
                </div>
            </div>
          
		
            
            
        </form>
</div>