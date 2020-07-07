<footer id="nr_footer" class="row">
        <div class="container">
            <div class="row goTop">
                <a href="#top"><i class="fa fa-angle-up"></i></a>
            </div>
            <div class="row twitterSlide">                
                <div class="owl-carousel twitterSlider">
                    <div class="item">
                        <i class="fab fa-twitter"></i><br>
                       <?php echo $lang[mod_twit][txt1] ?>
                    </div>
                    <div class="item">
                        <i class="fab fa-twitter"></i><br>
                        <?php echo $lang[mod_twit][txt2] ?>
                    </div>
                </div>
            </div>
            <div class="footerWidget row">
                <div class="col-sm-6 widget">
                    <div class="getInTouch_widget row">
                        <div class="widgetHeader row m0"><img src="<?php echo $RAIZa ?>images/whiteSquare.png" alt=""><?php echo $lang[t][cont] ?></div>        
                        <div class="row getInTouch_tab m0">
                            <ul class="nav nav-tabs nav-justified" role="tablist" id="getInTouch_tab">
                              <li role="presentation" class="active"><a href="#contactPhone" aria-controls="contactPhone" role="tab" data-toggle="tab"><i class="fa fa-phone"></i></a></li>
                              <li role="presentation"><a href="#contactEmail" aria-controls="contactEmail" role="tab" data-toggle="tab"><i class="fa fa-envelope"></i></a></li>
                              <li role="presentation"><a href="#contactHome" aria-controls="contactHome" role="tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                            </ul>

                            <div class="tab-content">
                              <div role="tabpanel" class="tab-pane active" id="contactPhone"><i class="fa fa-phone"></i> <?php echo $lang[t][cont_phone] ?> 713-293-2735</div>
                              <div role="tabpanel" class="tab-pane" id="contactEmail"><i class="fa fa-envelope"></i><?php echo $lang[t][cont_mail] ?> info@ecuahomes.net</div>
                              <div role="tabpanel" class="tab-pane" id="contactHome"><i class="fa fa-home"></i>10301 Northwest Freeway Suite # 401 Houston Texas 77092</div>
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="col-sm-6 widget">
                    <!--<div class="row flickrSlider">
                        <div class="widgetHeader row m0"><img src="<?php echo $RAIZa ?>images/whiteSquare.png" alt="">Flickr Gallery</div>        
                        <div class="row flickrSliderRow m0">
                            <div data-toggle="jsfg" data-tags="dogs" data-per-page="5" data-set-id="72157650377967655"></div>
                        </div>                        
                    </div>-->
					<div class="row flickrSlider">
						 <div class="widgetHeader row m0"><img src="<?php echo $RAIZa ?>images/whiteSquare.png" alt=""><?php echo $lang[t][loc] ?></div>        
                        <div class="row flickrSliderRow m0">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1730.9888713294858!2d-95.45785350070005!3d29.807187378740554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2sec!4v1520103021279" width="100%" height="185" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>                        
						

					</div>
                </div>
            </div>
            <div class="row copyrightRow">
                &copy; 2018 <a href="http://www.duotics.com/" target="_blank">DUOTICS</a>, Design and Development
            </div>
        </div>
    </footer>