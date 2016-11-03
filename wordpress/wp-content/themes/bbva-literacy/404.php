<?php get_header(); ?>

<div class="contents">
	
	<?php the_content(); ?>
	<?php get_sidebar('sidebar-0'); ?>

</div>

<!--pagina principal error 404-->

<div class="general-content-text"><!--añadir bg-gray para fondo en gris -->
    <div class="container">
      <section class="mgb-50 mt-lg">
        <h1>Oops! Página no encontrada.</h1>
        <h2>Se ha producido un error 404.</h2>
        <p>Nunc dictum lorem nec lectus varius, eu porta tellus lobortis. Aliquam
           lectus nibh, placerat ac efficitur at, feugiat et sem. Pellentesque eu
            malesuada elit. Pellentesque fermentum quam magna, id gravida purus
            hendrerit ac. Vivamus turpis purus, ullamcorper ac nisi eu, commodo
            dapibus nibh. Aenean condimentum, dolor id tristique venenatis, nulla
            purus pulvinar nisl, vitae tincidunt nisl velit quis ipsum. Phasellus
            dapibus massa vitae magna faucibus, quis consequat sem fringilla. Ut est
            diam, semper id sapien a, ornare lacinia neque. Mauris eget justo dignissim,
            eleifend arcu id, aliquphpet est.
        </p>
      </section>
    </div>
</div>
<!--prefooter-->
   
<?php

the_widget(
                'os_prefooter_bbva', 
                array(
                	'color_fondo' => 'gris',
                    'menu_izquierdo' => 'sobre-educacion-financiera',
                    'menu_central' => 'en-el-mundo',
                    'menu_derecho' => 'enlaces-de-interes',
                    
                )
            );
?>
<?php get_footer(); ?>
