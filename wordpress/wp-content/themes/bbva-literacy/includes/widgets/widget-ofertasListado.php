<?php

/*
Plugin Name: Listado de ofertas
Description: El buscador general de "Encuentra tu trabajo"
Version: 1.0
Author: Marta Romero
Author URI: http://www.opensistemas.com/
*/


add_action("widgets_init", array('widget_listadoOfertas', 'register'));

class widget_listadoOfertas {
	
  function control(){
    echo 'Listado de Ofertas';
  }
  
  function widget($args){
	echo $before_widget;    
        ?>
        <section class="moduloContenido_ofertasListado"><div class="wrapperContent">
                    <h2 class="section_titulo">Empleo destacado en BBVA Provincial</h2>
                    <ul class="lista_ofertas">
                        <li class="item_01 first">
                            <article>
                                <h1 class="oferta_title"><a href="#">Administrador base de datos</a></h1>
                                <p class="oferta_descripcion">Posición temporal de 6 meses de duración Las principales funciones a desarrollar serán.
                                 -Data MIning. - Ejecutivo</p>
                                <ul class="oferta_detalles">
                                    <li><a href="#">Perfil financiero</a></li>
                                    <li class="last"><a href="#">Santander</a>, <a href="#">España</a></li>
                                </ul>     
                                <ul class="ofertas_redesShare">
                                    <li class="item_01"><a href="#" class="icon-social_FB"><span class="textoIconoOcultar">Facebook</span></a></li>
                                    <li class="item_02"><a href="#" class="icon-social_TW"><span class="textoIconoOcultar">Twitter</span></a></li>
                                    <li class="item_03"><a href="#" class="icon-social_IN"><span class="textoIconoOcultar">Linkedin</span></a></li>
                                    <li class="item_04 last"><a href="#" class="icon-social_GO"><span class="textoIconoOcultar">Google+</span></a></li>
                                </ul>
                                <p class="oferta_link"><a href="#" class="botonVerdeBorde icon-lapiz"><span class="textoIconoColocar">Inscribete</span></a></p>
                            </article>
                        </li>
                       <li class="item_02">
                            <article>
                                <h1 class="oferta_title"><a href="#">VP Corporate Finance</a></h1>
                                <p class="oferta_descripcion">La persona seleccionada se integrará en el equipo de M&A en BBVA Perú. 
                                Se encargará d ela práctica de M&A en</p>
                                <ul class="oferta_detalles">
                                    <li><a href="#">Perfil comunicación</a></li>
                                    <li class="last"><a href="#">Madrid</a>, <a href="#">España</a></li>
                                </ul>
                                 <ul class="ofertas_redesShare">
                                    <li class="item_01"><a href="#" class="icon-social_FB"><span class="textoIconoOcultar">Facebook</span></a></li>
                                    <li class="item_02"><a href="#" class="icon-social_TW"><span class="textoIconoOcultar">Twitter</span></a></li>
                                    <li class="item_03"><a href="#" class="icon-social_IN"><span class="textoIconoOcultar">Linkedin</span></a></li>
                                    <li class="item_04 last"><a href="#" class="icon-social_GO"><span class="textoIconoOcultar">Google+</span></a></li>
                                </ul>
                                <p class="oferta_link"><a href="#" class="botonVerdeBorde icon-lapiz"><span class="textoIconoColocar">Inscribete</span></a></p>
                            </article>
                        </li>
                        <li class="item_03 last">
                            <article>
                                <h1 class="oferta_title"><a href="#">Auditor Junior de Sistemas</a></h1>
                                <p class="oferta_descripcion">Buscamos Licenciados y Graduados en Ingeniería Informática, de Telecomunicacione e
                                Industriales así como</p>
                                <ul class="oferta_detalles">
                                    <li><a href="#">Perfil jurídico</a></li>
                                    <li class="last"><a href="#">Galicia</a>, <a href="#"> España</a></li>
                                </ul><ul class="ofertas_redesShare">
                                    <li class="item_01"><a href="#" class="icon-social_FB"><span class="textoIconoOcultar">Facebook</span></a></li>
                                    <li class="item_02"><a href="#" class="icon-social_TW"><span class="textoIconoOcultar">Twitter</span></a></li>
                                    <li class="item_03"><a href="#" class="icon-social_IN"><span class="textoIconoOcultar">Linkedin</span></a></li>
                                    <li class="item_04 last"><a href="#" class="icon-social_GO"><span class="textoIconoOcultar">Google+</span></a></li>
                                </ul>
                                <p class="oferta_link"><a href="#" class="botonVerdeBorde icon-lapiz"><span class="textoIconoColocar">Inscribete</span></a></p>
                            </article>
                        </li>
                    </ul>
                     <hr class="lineaColor lineaCorta" />
                     <p class="section_verTodos"><a href="#" class="icon-linkInterno"><em>Todos los empleos BBVA Provincial</em></a></p>
                 </div></section>
        <?php
    echo $after_widget;
  }
  
  function register(){
    register_sidebar_widget('Listado de Ofertas', array('widget_listadoOfertas', 'widget'));
    register_widget_control('Listado de Ofertas', array('widget_listadoOfertas', 'control'));
  }
}
?>