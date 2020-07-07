<?php
$galls=array(
	array('dest'=>'pastel-62.jpg', 'nom'=>'Pastel DC Super Hero Girls'),
	array('dest'=>'pastel-61.jpg', 'nom'=>'Pastel Fortnite'),
	array('dest'=>'pastel-60.jpg', 'nom'=>'Pastel Mario Bross Tuberia'),
	array('dest'=>'pastel-59.jpg', 'nom'=>'Pastel GOKU Dragon Ball Z'),
	array('dest'=>'pastel-58.jpg', 'nom'=>'Pastel Años 80 Disco'),
	array('dest'=>'pastel-57.jpg', 'nom'=>'Pastel Baby Shower Niña'),
	array('dest'=>'pastel-56.jpg', 'nom'=>'Pastel Medico'),
	array('dest'=>'pastel-55.jpg', 'nom'=>'Pastel PAW PATROL'),
	array('dest'=>'pastel-54.jpg', 'nom'=>'Pastel Minions 2'),
	array('dest'=>'pastel-53.jpg', 'nom'=>'Pastel Unicornio Arcoiris'),
	array('dest'=>'pastel-52.jpg', 'nom'=>'Pastel Graduación JDENTIST'),
	array('dest'=>'pastel-51.jpg', 'nom'=>'Pastel Corazones Enamorados'),
	array('dest'=>'pastel-50.jpg', 'nom'=>'Pastel DOCTORA'),
	array('dest'=>'pastel-49.jpg', 'nom'=>'Pastel NORDICA'),
	array('dest'=>'pastel-48.jpg', 'nom'=>'Pastel ONCE Disney'),
	array('dest'=>'pastel-47.jpg', 'nom'=>'Pastel Maquillaje DANIELA'),
	array('dest'=>'pastel-46.jpg', 'nom'=>'Pastel estilo, Adi Klinghofer'),
	array('dest'=>'pastel-45.jpg', 'nom'=>'Pastel Técnico Internet'),
	array('dest'=>'pastel-44.jpg', 'nom'=>'Pastel COCO'),
	array('dest'=>'pastel-43.jpg', 'nom'=>'Pastel Dinosaurio'),
	array('dest'=>'pastel-42.jpg', 'nom'=>'Pastel Avengers'),
	array('dest'=>'pastel-41.jpg', 'nom'=>'Pastel Fantasía Infantil'),
	array('dest'=>'pastel-40.jpg', 'nom'=>'Pastel Doctora'),
	array('dest'=>'pastel-39.jpg', 'nom'=>'Pastel Ingeniero'),
	array('dest'=>'pastel-38.jpg', 'nom'=>'Pastel Bob Esponja - Merengue'),
	array('dest'=>'pastel-37.jpg', 'nom'=>'Pastel Nutella'),
	array('dest'=>'pastel-36.jpg', 'nom'=>'Pastel Paw Patrol Sky'),
	array('dest'=>'pastel-35.jpg', 'nom'=>'Pastel Angry Birds Star Wars 2'),
	array('dest'=>'pastel-34.jpg', 'nom'=>'Pastel Moto Harley Davidson'),
	array('dest'=>'pastel-33.jpg', 'nom'=>'Pastel BajoTerra'),
	array('dest'=>'pastel-32.jpg', 'nom'=>'Pastel Real Madrid CR7'),
	array('dest'=>'pastel-31.jpg', 'nom'=>'Pastel Maquillaje MAC'),
	array('dest'=>'pastel-30.jpg', 'nom'=>'Pastel Maquillaje con Cartera'),
	array('dest'=>'pastel-29.jpg', 'nom'=>'Pastel Unicornio'),
	array('dest'=>'pastel-28.jpg', 'nom'=>'Pastel Cumpleaños'),
	array('dest'=>'pastel-27.jpg', 'nom'=>'Pastel Pokemón'),
	array('dest'=>'pastel-26.jpg', 'nom'=>'Pastel Corona Princesa Sophia'),
	array('dest'=>'pastel-25.jpg', 'nom'=>'Pastel Navidad'),
	array('dest'=>'pastel-24.jpg', 'nom'=>'Pastel Cars'),
	array('dest'=>'pastel-23.jpg', 'nom'=>'Pastel Calzado Gucci'),
	array('dest'=>'pastel-22.jpg', 'nom'=>'Pastel Motocross HONDA'),
	array('dest'=>'pastel-21.jpg', 'nom'=>'Pastel Despedida de Soltera'),
	array('dest'=>'pastel-20.jpg', 'nom'=>'Pastel Soy Luna'),
	array('dest'=>'pastel-19.jpg', 'nom'=>'Pastel Peppa Pig & George'),
	array('dest'=>'pastel-18.jpg', 'nom'=>'Pastel Mario Bross'),
	array('dest'=>'pastel-17.jpg', 'nom'=>'Pastel Boda Torre eiffel'),
	array('dest'=>'pastel-16.jpg', 'nom'=>'Pastel Minions Mini'),
	array('dest'=>'pastel-15.jpg', 'nom'=>'Pastel Angry Birds'),
	array('dest'=>'pastel-14.jpg', 'nom'=>'Pastel Camion de Bomberos'),
	array('dest'=>'pastel-13.jpg', 'nom'=>'Pastel Bus Cuenca'),
	array('dest'=>'pastel-12.jpg', 'nom'=>'Pastel Perry el Ornitorrinco'),
	array('dest'=>'pastel-11.jpg', 'nom'=>'Pastel M&M'),
	array('dest'=>'pastel-10.jpg', 'nom'=>'Pastel Boda'),
	array('dest'=>'pastel-09.jpg', 'nom'=>'Pastel Winnie Pooh'),
	array('dest'=>'pastel-08.jpg', 'nom'=>'Pastel Minecraft'),
	array('dest'=>'pastel-07.jpg', 'nom'=>'Pastel Camisa Día del Padre'),
	array('dest'=>'pastel-06.jpg', 'nom'=>'Pastel Baby Shower'),
	array('dest'=>'pastel-05.jpg', 'nom'=>'Pastel Castillo'),
	array('dest'=>'pastel-04.jpg', 'nom'=>'Pastel Primera Comunión'),
	array('dest'=>'pastel-03.jpg', 'nom'=>'Pastel Dinosaurios'),
	array('dest'=>'pastel-02.jpg', 'nom'=>'Pastel Bailarina'),
	array('dest'=>'pastel-01.jpg', 'nom'=>'Pastel Minions')
);
include('_head.php');
include('_topMin.php');
?>
<div class="container">
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
		<li class="breadcrumb-item active">Galería Pasteles</li>
	</ul>
   	<div class="card card-primary">
    	<h1 class="card-header text-primary">
			GALERÍA PASTELES <i class="fas fa-birthday-cake fa-lg fa-fw"></i>
			<small class="float-right text-secondary">Pedidos <i class="fab fa-whatsapp fa-lg fa-fw"></i> <span class="badge badge-danger">0995235042</span> <sup>WhatsApp</sup></small>
		</h1>
		<div class="card-body">
   			<div class="row">
   			<?php foreach($galls as $val){ ?>
   				<div class="col-xs-6 col-md-3 animated fadeIn mb-4">
				<a data-fancybox="gallery" href="data/prods/<?php echo $val[dest] ?>" class="card prod-card">
				<img src="data/prods/t_<?php echo $val[dest] ?>" alt="<?php echo $val[nom] ?>" class="card-img-top">
				<div class="card-body">
					<h5 class="card-title text-center"><?php echo $val[nom] ?></h5>
				</div>
				</a>
				</div>
   			<?php } ?>
   			</div>
   			
    	</div>
    </div>
    <?php include('mods/mod_buttons.php') ?>
</div>
<?php include('_bottom.php') ?>
<?php include('_foot.php') ?>