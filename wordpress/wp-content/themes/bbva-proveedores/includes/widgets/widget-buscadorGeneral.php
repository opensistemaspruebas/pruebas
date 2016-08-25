<?php

/*
Plugin Name: Buscador General de Ofertas
Description: El buscador general de "Encuentra tu trabajo"
Version: 1.0
Author: Marta Romero
Author URI: http://www.opensistemas.com/
*/

add_action("widgets_init", array('widget_buscadorGeneral', 'register'));

class widget_buscadorGeneral {
  function control(){
    echo 'Buscador general';
  }
  
  function widget($args){
	echo $before_widget;    
        ?>
        <aside id="main_buscadorGeneral" class="moduloContenido_buscadorGeneral"><div class="wrapperContent">
                <h2 class="section_textoDestacado">Encuentra <strong>tu futuro</strong></h2>
                <form>
                 <fieldset class="col31">
                    <label lang="es" xml:lang="es" for="buscarGeneral_inputQue">¿Qué puesto buscas?</label>
                    <input id="buscarGeneral_inputQue" type="text" lang="es" name="buscarGeneral_inputPuesto" title="¿Qué puesto buscas?" xml:lang="es" class="blur">
                  </fieldset>
                  <fieldset class="col32">  
                    <label lang="es" xml:lang="es" for="buscarGeneral_selectPais2">Seleccionar pais:</label>
                    <select name="buscarGeneral_selectPais2" id="buscarGeneral_selectPais2" type="text">
                        <option value="">Seleccionar País</option>
                        <option  value="Spain" >España</option>
                        <option  value="Venezuela" >Venezuela</option>
                        <option  value="Peru" >Peru</option>
                        <option  value="USA" >USA</option>
                    </select>
                  </fieldset> 
                  <div class="col33">  
                    <button type="submit" id="btn_buscar" value="buscar" class="botonVerde">Buscar</button>
                  </div>
                </form>
         </div></aside>
        <?php
    echo $after_widget;
  }
  
  function register(){
    register_sidebar_widget('Buscador Personalizado', array('Widget_buscadorGeneral', 'widget'));
    register_widget_control('Buscador Personalizado', array('Widget_buscadorGeneral', 'control'));
  }
}
?>