<?php

/*
Plugin Name: Carrousel Promocional 
Description: Carrousel promocional con imagenes
Version: 1.0
Author: Marta Romero
Author URI: http://www.opensistemas.com/
*/

add_action("widgets_init", array('widget_carrouselPromocional', 'register'));

class widget_carrouselPromocional {
	
  function control(){
    echo 'Carrousel promocional';
  }
  
  function widget($args){
	echo $before_widget;    
        ?>
        <section id="main_carruselPromocional" class="moduloContenido_carruselPromocionalHeader">
                <div class="carruselPromocional">
                    <ul class="tabs_contentHorizontal">
                        <li class="tab_box" id="promo_01">
                            <figure><img src="images/imagesEjemplo/headerCarrouselPromocional_1.png" alt="Conoce BBVA" title="Conoce BBVA"></figure>
                            <div class="wrapperContent">
                                <div class="fotoInfo_container">
                                    <p class="fotoInfo_titulo">Conoce BBVA Provincial</p>
                                    <p class="fotoInfo_link"><a title="" href="#" class="botonVerde">Conocenos de cerca</a></p>
                                </div>
                            </div>
                        </li>
                        <li class="tab_box" id="promo_02" style="display:none;">
                            <figure><img src="images/imagesEjemplo/headerCarrouselPromocional_2.png" alt="Presentacion corporativa" title="Presentacion corporativa"></figure>
                            <div class="wrapperContent">
                                <div class="fotoInfo_container">
                                    <p class="fotoInfo_titulo">Presentación Corporativa BBVA</p>
                                    <p class="fotoInfo_texto">25 de Julio de 2013 </p>
                                    <p class="fotoInfo_link"><a title="" href="#" class="icon-linkInterno"><span class="textoIconoColocar">Conoce nuestra agenda</span></a></p>
                                </div>
                            </div>
                        </li>
                        <li class="tab_box" id="promo_03" style="display:none;">
                            <figure><img src="images/imagesEjemplo/headerCarrouselPromocional_3.png" alt="Presentacion corporativa" title="Presentacion corporativa"></figure>
                            <div class="wrapperContent">
                                <div class="fotoInfo_container">
                                    <p class="fotoInfo_titulo">Bienvenido a BBVA Provincial</p>
                                    <p class="fotoInfo_texto">Forma parte de una empresa innovadora dentro del sector de la banca</p>
                                    <p class="fotoInfo_link"><a title="" href="#" class="botonVerde">Ingresa tu CV</a></p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <span class="clear"></span>
                    <div class="wrapperContent">
                        <ul class="tabs_menuHorizontal">
                            <li class="tab_boton active" id="promo_01">Conoce BBVA Provincia</li>
                            <li class="tab_boton" id="promo_02">Próximo Foro de empleo</li>
                            <li class="tab_boton" id="promo_03">Empleo internacional</li>
                        </ul>
                    </div>
               </div>
            </section>
        <?php
    echo $after_widget;
  }
  
  function register(){
    register_sidebar_widget('Carrousel promocional', array('widget_carrouselPromocional', 'widget'));
    register_widget_control('Carrousel promocional', array('widget_carrouselPromocional', 'control'));
  }
}
?>