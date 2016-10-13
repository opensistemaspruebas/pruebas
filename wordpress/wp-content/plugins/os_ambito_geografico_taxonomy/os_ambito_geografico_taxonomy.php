<?php

/*
	Plugin Name: OS Ámbito Geográfico Taxonomy
	Plugin URI: https://www.opensistemas.com/
	Description: Crea la taxonomía 'ámbito geográfico'.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_ambito_geografico_taxonomy
*/


function create_ambito_geografico_taxonomy(){

    // Set the name of the taxonomy
    $taxonomy = 'ambito_geografico';
    // Set the post types for the taxonomy
    $object_type = 'post';
    
    // Populate our array of names for our taxonomy
    $labels = array(
        'name'               => __('Ámbito geográfico', 'os_ambito_geografico_taxonomy'),
        'singular_name'      => __('Ámbito geográfico', 'os_ambito_geografico_taxonomy'),
        'search_items'       => __('Buscar ámbitos geográficos', 'os_ambito_geografico_taxonomy'),
        'all_items'          => __('Todos', 'os_ambito_geografico_taxonomy'),
        'parent_item'        => __('Superior', 'os_ambito_geografico_taxonomy'),
        'parent_item_colon'  => __('Superior:', 'os_ambito_geografico_taxonomy'),
        'update_item'        => __('Actualizar ámbito geográfico', 'os_ambito_geografico_taxonomy'),
        'edit_item'          => __('Editar ámbito geográfico', 'os_ambito_geografico_taxonomy'),
        'add_new_item'       => __('Añadir nuevo ámbito geográfico', 'os_ambito_geografico_taxonomy'), 
        'new_item_name'      => __('Nuevo ámbito geográfico', 'os_ambito_geografico_taxonomy'),
        'menu_name'          => __('Ámbitos geográficos', 'os_ambito_geografico_taxonomy'),
    );
    
    // Define arguments to be used 
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'           => true,
        'how_in_nav_menus'  => true,
        'public'            => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'ambito-geografico')
    );
    
    // Call the register_taxonomy function
    register_taxonomy($taxonomy, $object_type, $args); 

}
add_action( 'init', 'create_ambito_geografico_taxonomy', 0 );


//Funcion para añadir campos
function ambito_geografico_add_new_meta_fields(){
    ?>
    <div class="form-field">
        <label for="term_meta[isoCode]">Código ISO del país</label>
        <input type="text" name="term_meta[isoCode]" id="term_meta[isoCode]" value="">
        <p class="description">Introduzca el código ISO que identifica al nuevo ámbito geográfico</p>
    </div>
    <div class="form-field">
        <label for="term_meta[descripcion]">Descripción del enlace</label>
        <input type="text" name="term_meta[descripcion]" id="term_meta[descripcion]" value="">
        <p class="description">Nombre descriptivo de la URL</p>
    </div>
    <div class="form-field">
        <label for="term_meta[link]">Link de la web</label>
        <input type="url" name="term_meta[link]" id="term_meta[link]" value="">
        <p class="description">URL de la página del país</p>
    </div>

    <!--Elimina el campo descripcion que viene por defecto-->
    <style>.term-description-wrap{display:none !important;}</style>
    
    <?php

}
add_action('ambito_geografico_add_form_fields', 'ambito_geografico_add_new_meta_fields', 0, 2);



//Funcion para modificar campos
function ambito_geografico_edit_meta_fields($term){
    $t_id = $term->term_id;
 
    $term_meta = get_option("ambito_geografico_$t_id");
    ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[isoCode]">Código ISO del país</label>
            </th>
            <td>
                <input type="text" name="term_meta[isoCode]" id="term_meta[isoCode]" value="<?php echo esc_attr( $term_meta['isoCode'] ) ? esc_attr( $term_meta['isoCode'] ) : ''; ?>">
                <p class="description">Introduzca el código ISO que identifica al nuevo ámbito geográfico</p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[descripcion]">Descripción del enlace</label>
            </th>
            <td>
                <input type="text" name="term_meta[descripcion]" id="term_meta[descripcion]" value="<?php echo esc_attr( $term_meta['descripcion'] ) ? esc_attr( $term_meta['descripcion'] ) : ''; ?>">
                <p class="description">Nombre descriptivo de la URL</p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[link]">Link de la web</label>
            </th>
            <td>
                <input type="url" name="term_meta[link]" id="term_meta[link]" value="<?php echo esc_attr( $term_meta['link'] ) ? esc_attr( $term_meta['link'] ) : ''; ?>">
                <p class="description">URL de la página del país</p>
            </td>
        </tr>
    <?php
}
add_action( 'ambito_geografico_edit_form_fields', 'ambito_geografico_edit_meta_fields', 0, 2 );



//Funcion para guardar los datos
function ambito_geografico_save_custom_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "ambito_geografico_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        update_option( "ambito_geografico_$t_id", $term_meta );
    }
}  
add_action( 'edited_ambito_geografico', 'ambito_geografico_save_custom_meta', 0, 2 );  
add_action( 'create_ambito_geografico', 'ambito_geografico_save_custom_meta', 0, 2 );



//Eliminar el campo descripcion que viene por defecto
add_action( "ambito_geografico_edit_form", function( $tag, $taxonomy ){ 

    ?><style>.term-description-wrap{display:none !important;}</style><?php
}, 0, 2 );


add_filter('manage_edit-ambito_geografico_columns', function ( $columns ) {

    if( isset( $columns['description'] ) )
        unset( $columns['description'] );   

    return $columns;
} );

