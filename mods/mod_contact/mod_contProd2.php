<div class="panel panel-warning panel-Y" style="margin-bottom: 40px">
	<div class="panel-heading">GET A QUOTE?</div>
	<div class="panel-body">
	
		<div class="row m0 commentForm" style="margin: 0">
		<form class="row m0" id="contactForm" method="post" name="contact" action="<?php echo $RAIZs ?>fnc/mail3.php" style="padding: 0;">
			<fieldset>
			<input name="txtRef" type="hidden" id="txtRef" value="<?php echo $idI ?>" />
			<input name="txtType" type="hidden" id="txtType" value="askItem" />
			<input name="human" type="hidden" id="human" value="yes" />
			</fieldset>
			<div class="col-sm-6 p0 commenterInfoInputs">
				<div class="row m0">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control" name="txtName" id="name"  placeholder="Name" value="<?php echo $dataf['txtName']?>">
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						<input type="email" class="form-control" name="txtMail" id="email" placeholder="e-mail" value="<?php echo $dataf['txtMail']?>">
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>
						<input type="text"  name="txtPhone" id="phone" class="form-control" placeholder="phone" value="<?php echo $dataf['txtPhone']?>">
					</div>
					<div class="input-group">
						<textarea placeholder="Message" name="txtMessage" id="message" class="form-control"><?php echo $dataf['txtMessage']?></textarea>
					</div>
					<div class="form-group">
							<label class="control-label col-sm-4">How Do you Know about us?</label>
							<div class="col-sm-8"><?php genSelect('ContactKnow', detRowGSel('tbl_types','typ_cod','typ_nom','typ_ref','ContactKnow',TRUE), $dataf['ContactKnow'], 'form-control', NULL, NULL, NULL, TRUE, NULL, "Please Select an Option"); ?></div>
					</div>

				</div>
			</div>
			<div class="col-sm-6 p0">
				<div class="row m0">                                        
					<div class="panel panel-default">
						<div class="panel-heading text-center"><small><?php echo $dRS['i_nom'] ?></small></div>
						<div class="panel-body text-center"><img src="<?php echo $RAIZd.'img/item/t_'.$dRS['i_img'] ?>"/></div>
					</div>
					<div class="input-group">
						<div class="g-recaptcha" data-sitekey="6LezEFEUAAAAAPjjK2IbmnsWa2_Gp-BXl7HrDRu-"></div>
					</div>
					<button class="btn btn-default" type="submit"><i class="fa fa-envelope fa-lg"></i> send message</button>
				</div>
			</div>
		</form>
		</div>
		
	</div>
</div>