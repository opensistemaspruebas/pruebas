<?php
/**
 * Plugin Name: OS Custom Search
 * Plugin URI: http://www.opensistemas.com/
 * Description: Buscador para publicaciones, historias y talleres.
 * Version: 1.0
 * Author: Marta Oliver
 * Author URI: http://www.opensistemas.com/
 * Text Domain: os_custom_search
 */


function print_buscador() {
	echo '<div class="componente_BUSCADORgeneral" id="buscadorGeneralExtensible" style=""> 
          <form action="/resultados.html" method="get" data-ajax="false">
            <fieldset>
                <label xml:lang="es" for="inpbuscar_general" lang="es">Buscar</label>
                <input style="width: 176px;" data-role="none" id="inpbuscar_general" class="text" xml:lang="es" placeholder="_Escribe aquí tu busqueda" title="Search" name="q" lang="es" type="text">
                <input data-role="none" id="btnbuscar_general" value="Buscar" xml:lang="es" name="btnbuscar_general" lang="es" type="submit">
            </fieldset>
           </form>
          </div>';
}