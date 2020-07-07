<?php require_once('../../init.php');
$id=vparam('id',$_GET['id'],$_POST['id'],FALSE);
$resp=vparam('resp',$_GET['resp'],$_POST['resp'],FALSE);
$detC=detRow('tbl_contact_data','md5(idData)',$id);
$detTR=detRow('tbl_types','typ_cod',$detC['ContactKnow']);
$idm=$detC['idMail'];
$detM=detRow('tbl_contact_mail','idMail',$idm);
$banRef=FALSE;//Verifica si existe una Referencia para mostrarla en el mensaje, una referencia es cuando el mensaje se hace basado en un producto, articulo, específico.
?>
<?php
$param['tit']='Contact us';
$param['bg']=$RAIZa."img/mail/mail_head_bg-F01.jpg";
include(RAIZs."msgs/_fraTop.php") ?>
<?php if($detM){
$idR=$detC['id_ref'];
if($idR){
	$typR=$detC['type'];
	switch ($typR) {
    case "askItem":
        $detR=detRow('db_items','item_id',$idR);
		if($detR){
			$banRef=TRUE;
			$detRF['tit']=$detR['item_nom'];
			$detRF['cod']=$detR['item_cod'];
			$detRF['link']=$RAIZ.'p/mail/'.$detR['item_aliasurl'];
			$detRF['img']=$detR['item_img'];
			$detRFi=vImg('data/img/item/',$detRF['img']);
		}
        break;
    case "askPage":
        $detR=detRow('tbl_articles','art_id',$idR);
		if($detR){
			$banRef=TRUE;
			$detRF['tit']=$detR['title'];
			$detRF['link']=$RAIZ.'a/'.$detR['art_url'];
			$detRF['img']=$detR['image'];
			$detRFi=vImg('data/img/blog/',$detRF['img']);
		}
        break;
    default:
        $banRef=FALSE;
	}
}

?>
<style type="text/css">
td{ padding:5px;}
.cero{ padding:0px !important;}
</style>
<div>
<table style="width:100%;" bgcolor="#EEEEEE" cellpadding="0" cellspacing="0">
    <?php if($resp==TRUE){ ?>
    <tr>
    	<td colspan="2" style="text-align:center; background:#fff; padding:10px;">
        <h2>Our Team, reply you message quickly</h2>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <?php
		if($banRef==TRUE){ 
			$valColSpan=1;
		?>
		<td>
        <div style="margin:5px; background:#FFF; padding:7px; text-align:center; border-right: 5px solid #ddd;">
			<a href="<?php echo $detRF['link'] ?>" style="text-decoration:none; color:#2b2b2b" target="_blank">
           	<div>
				<span style="font-size:125%"><?php echo $detRF['tit'] ?></span><br>
                <span style="font-size:90%; color:#666"><?php echo $detRF['cod'] ?></span>
            </div>
            <div>
            	<img src="<?php echo $detRFi['t'] ?>" alt="<?php echo $detRF['tit'] ?>" style="width:inherit;max-width:100%;height:auto;"/>
            </div>
            <div style="margin-top:5px; font-size:70%; background:#eee; color:#333; padding:5px 0; border:1px solid #ddd;"><?php echo $detRF['link'] ?></div>
        	</a>
        </div>
		</td>
        <?php }else{ $valColSpan=2; } ?>
        <td colspan="<?php echo $valColSpan ?>" style="padding:0">
        <table style="width:100%" cellpadding="4" cellspacing="1">
        
        <?php if(($detC['name'])||($detC['company'])){ ?>
        <tr style="font-size:125%;">
            <td style="width:25%; background:#ccc; color:#666">Name / Company</td>
            <td style="width:75%" bgcolor="#FFFFFF"><strong><?php echo $detC['name']; ?></strong>. <?php echo $detC['company']; ?></td>
        </tr><?php } ?>
        <?php if($detM['mail']){ ?>
        <tr style="font-size:125%;">
            <td style="background:#ccc; color:#666">E-Mail</td>
            <td bgcolor="#FFFFFF"><?php echo $detM['mail'] ?></td>
        </tr><?php } ?>
        <?php if(($detC['phone1'])||($detC['phone2'])){ ?>
        <tr>
            <td>Telefono</td>
            <td bgcolor="#FFFFFF"><?php echo $detC['phone1']; ?><br><?php echo $detC['phone2']; ?></td>
        </tr><?php } ?>
        <?php if(($detC['country'])||($detC['state'])||($detC['state'])||($detC['city'])||($detC['zip'])){ ?>
        <tr>
            <td>Location</td>
            <td bgcolor="#FFFFFF">
            <?php
            if($detC['country']){ ?>
            <span style="background:#ddd; color:#555; padding:2px 5px;">Country <strong><?php echo $detC['country']?></strong></span>&nbsp;
            <?php }
            if($detC['state']){ ?>
            <span style="background:#ddd; color:#555; padding:2px 5px;">State <strong><?php echo $detC['state']?></strong></span>&nbsp;
            <?php }
            if($detC['city']){ ?>
            <span style="background:#ddd; color:#555; padding:2px 5px;">City <strong><?php echo $detC['city']?></strong></span>&nbsp;
            <?php }
            if($detC['zip']){ ?>
            <span style="background:#ddd; color:#555; padding:2px 5px;">ZIP <strong><?php echo $detC['zip']?></strong></span>&nbsp;
            <?php } ?>
        </tr><?php } ?>
        <?php if($detC['address']){ ?>
        <tr>
            <td>Address</td>
            <td bgcolor="#FFFFFF"><?php echo $detC['address']; ?></td>
        </tr><?php } ?>
        <?php if($detC['message']){ ?>
        <tr>
            <td>Message</td>
            <td bgcolor="#FFFFFF">
            <div style="padding:7px; color:#2b2b2b; font-size:125%;"><?php echo $detC['message'] ?></div>
            </td>
        </tr><?php } ?>
        <tr>
            <td>Referred</td>
            <td bgcolor="#FFFFFF"><?php echo $detTR['typ_nom']; ?></td>
        </tr>
        <tr>
            <td>Date</td>
            <td bgcolor="#FFFFFF"><?php echo $detC['date']; ?></td>
        </tr>
        </table>
        </td>
    </tr>
</table>
</div>
<?php }else{ ?>
	<div style="padding: 15px 0; text-align: center"><h2>Data Not Found!</h2><h4 style="font-weight: normal">Please contact <strong>webmaster@mercoframes.net</strong></h4></div>
<?php } ?>
<?php include(RAIZs."msgs/_fraBottom.php") ?>