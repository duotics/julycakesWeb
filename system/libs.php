<script async src="https://www.googletagmanager.com/gtag/js?id=UA-110226850-6"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-110226850-6');
</script>
<!--jQuery, Bootstrap and other vendor JS-->
<script src="<?php echo $RAIZa ?>js/jquery-2.1.3.min.js"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js"></script>-->
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="<?php echo $RAIZa ?>js/bootstrap.min.js"></script>
<script src="<?php echo $RAIZa ?>vendors/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script src="<?php echo $RAIZa ?>vendors/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script src="<?php echo $RAIZa ?>vendors/owl.carousel/js/owl.carousel.min.js"></script>
<script src="<?php echo $RAIZa ?>vendors/nicescroll/jquery.nicescroll.js"></script>
<!--
<script src="<?php echo $RAIZa ?>vendors/js-flickr-gallery/js/js-flickr-gallery.min.js"></script>
<script src="<?php echo $RAIZa ?>vendors/lightbox/js/lightbox.min.js"></script>
-->
<!-- Add fancyBox JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>
<!--
<script src="<?php echo $RAIZa ?>plugins/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
<script src="<?php echo $RAIZa ?>plugins/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<script src="<?php echo $RAIZa ?>plugins/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script src="<?php echo $RAIZa ?>plugins/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script src="<?php echo $RAIZa ?>plugins/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
-->
<script>
	$(document).ready(function() {
		$(".fancybox").fancybox();
		$(".various").fancybox({ maxWidth	: 800,		maxHeight	: 600, fitToView	: false, width		: '70%',	height		: '70%', autoSize	: false,	closeClick	: false, openEffect	: 'none',	closeEffect	: 'none' });
		$(".fancyfull").fancybox({ width		: '85%',	height		: '85%' });
		$(".fancybox-thumb").fancybox({ prevEffect : 'none', nextEffect : 'none', helpers : { title : { type: 'outside' }, thumbs : { width	: 50, height : 50 }}});
	});
</script>
<!--Isotope-->
<script src="<?php echo $RAIZa ?>vendors/isotope/isotope-custom.js"></script>
<!--Construction JS-->
<script src="<?php echo $RAIZa ?>js/construction.js"></script>
<!--<script src="<?php echo $RAIZa ?>js/google-map.js"></script>-->
<!--<script src="<?php echo $RAIZa ?>js/contact.js"></script>-->
<script>
var RAIZ='<?php echo $RAIZ ?>';
var RAIZc='<?php echo $RAIZc ?>';
</script>