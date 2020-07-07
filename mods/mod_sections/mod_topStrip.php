<section id="nr_topStrip" class="row">
        <div class="container">
            <div class="row">
                <ul class="list-inline c-info fleft">
                    <li><a href="tel:123456789012"><i class="fa fa-phone"></i> 713-293-2735</a></li>
                    <li><a href="mailto:info@domain.com"><i class="fa fa-envelope-o"></i> info@ecuahomes.net</a></li>
                </ul>
                <ul class="list-inline lang fright">
                    <li class="<?php if($_SESSION['lang']=='en') echo 'active' ?> ">
						<a href="<?php echo $RAIZ ?>lang/en"><img src="<?php echo $RAIZa ?>images/flags/flag1.png" alt=""></a>
					</li>
                    <li class="<?php if($_SESSION['lang']=='es') echo 'active' ?>">
						<a href="<?php echo $RAIZ ?>lang/es"><img src="<?php echo $RAIZa ?>images/flags/flag5.png" alt=""></a>
					</li>
                </ul>
            </div>
        </div>
</section> <!--Top Strip-->