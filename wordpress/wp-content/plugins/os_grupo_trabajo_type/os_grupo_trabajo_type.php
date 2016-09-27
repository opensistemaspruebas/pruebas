<?php
/*
Plugin Name: OS Grupo de trabajo type
Plugin URI: http://www.opensistemas.com
Description: Crea el tipo de contenido 'Grupo de trabajo'
Version: 1.0
Author: Roberto Ojosnegros 
Author URI: http://www.opensistemas.com/
Author email: ropavon@opensistemas.com
Text Domain: os_grupo_trabajo_type
License: GPL2
*/

/* 
Copyright (C) 2016 ropavon

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

if (!class_exists('GrupoTrabajoCustomType')) :
  
   class GrupoTrabajoCustomType 
   {   
        var $post_type = "grupo-trabajo";

        
        function __construct() {
            add_action('init', array(&$this, 'create_post_type'));
            add_action('plugins_loaded', array(&$this, 'load_text_domain'), 10);
        }

        // Selecciona Dominio para la traducción
        function load_text_domain() {
            $plugin_dir = basename(dirname(__FILE__));
            load_plugin_textdomain('os_grupo_trabajo_type', false, $plugin_dir . "/languages");
        }

        function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Grupos de trabajo', 'os_grupo_trabajo_type'),
                    'singular_name' => __('Grupo de trabajo', 'os_grupo_trabajo_type'),
                    'add_new' => __('Añadir nuevo', 'os_grupo_trabajo_type'),
                    'add_new_item' => __('Añadir nuevo Grupo de trabajo', 'os_grupo_trabajo_type'),
                    'new_item' => __('Nuevo Grupo de trabajo', 'os_grupo_trabajo_type'),
                    'edit_item' => __('Editar Grupo de trabajo', 'os_grupo_trabajo_type'),
                    'view_item' => __('Ver Grupo de trabajo', 'os_grupo_trabajo_type'),
                    'parent_item_colon' => __(' ', 'os_grupo_trabajo_type'),
                    'search_items' => __('Buscar Grupos de trabajo', 'os_grupo_trabajo_type'),
                    'not_found' => __('No se han encontrado grupos de trabajo', 'os_grupo_trabajo_type'),
                    'not_found_in_trash' => __('No hay grupos de trabajo en la papelera', 'os_grupo_trabajo_type'),
                    'menu_name' => __('Grupos de trabajo', 'os_grupo_trabajo_type')
                ),
                'capability_type' => 'post',
                'description' => __("En este tipo de post se encuentran los grupos de trabajo", "os_grupo_trabajo_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'grupo-trabajo'),
                //'menu_position' => 4,
                'menu_icon' =>  'dashicons-groups',
                'supports' => array("title", "revisions"),
                )
            );
        }

    }

    $osGrupoTrabajo = new GrupoTrabajoCustomType();

endif;

?>
