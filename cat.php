<?php require('init.php');
$css['body']='cero';
include(RAIZf.'head.php');
include(RAIZf.'_topMin.php') ?>
<div class="container">
	<div>
            <?php include('_cat.php') ?>
			<div class="mb-4">
            <?php include(RAIZm.'mod_content/mod_recenViews.php') ?>
            </div>
			<div class="mb-4">
			<?php include(RAIZm.'mod_prods/mod_lastprod.php') ?>
			</div>
			<div class="mb-4">
			<?php include(RAIZm.'mod_prods/mod_topprod.php') ?>
			</div>
		</div>
	</div>
</div>
<?php include(RAIZf.'foot.php'); ?>