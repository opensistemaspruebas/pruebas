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
        <label for="term_meta[tituloModal]">Título de la ventana modal</label>
        <input type="text" name="term_meta[tituloModal]" id="term_meta[tituloModal]" value="">
    </div>
    <div class="form-field">
        <label for="term_meta[descripcionModal]">Descripción de la ventana modal</label>
        <input type="text" name="term_meta[descripcionModal]" id="term_meta[descripcionModal]" value="">
    </div>
    <div class="form-field">
        <label for="term_meta[descripURLmasInfo]">Descripción del enlace de la ventana modal</label>
        <input type="text" name="term_meta[descripURLmasInfo]" id="term_meta[descripURLmasInfo]" value="">
        <p class="description">Nombre descriptivo de la URL</p>
    </div>
    <div class="form-field">
        <label for="term_meta[URLmasInfo]">URL del enlace de la ventana modal</label>
        <input type="url" name="term_meta[URLmasInfo]" id="term_meta[URLmasInfo]" value="">
    </div>
    <div class="form-field">
        <label for="term_meta[descripURLpais]">Descripción del enlace del país</label>
        <input type="text" name="term_meta[descripURLpais]" id="term_meta[descripURLpais]" value="">
        <p class="description">Nombre descriptivo de la URL</p>
    </div>
    <div class="form-field">
        <label for="term_meta[URLpais]">URL del enlace del país</label>
        <input type="url" name="term_meta[URLpais]" id="term_meta[URLpais]" value="">
    </div>
    <div class="form-field">
        <label for="term_meta[descripURLaprenderMas]">Descripción del enlace aprender más</label>
        <input type="text" name="term_meta[descripURLaprenderMas]" id="term_meta[descripURLaprenderMas]" value="">
        <p class="description">Nombre descriptivo de la URL</p>
    </div>
    <div class="form-field">
        <label for="term_meta[URLaprenderMas]">URL del enlace aprender más</label>
        <input type="url" name="term_meta[URLaprenderMas]" id="term_meta[URLaprenderMas]" value="">
    </div>
    <div class="form-field">
        <label for="term_meta[tituloMicrofinanzas]">Título microfinanzas</label>
        <input type="text" name="term_meta[tituloMicrofinanzas]" id="term_meta[tituloMicrofinanzas]" value="">
    </div>
    <div class="form-field">
        <label for="term_meta[descripcionMicrofinanzas]">Descripción microfinanzas</label>
        <input type="text" name="term_meta[descripcionMicrofinanzas]" id="term_meta[descripcionMicrofinanzas]" value="">
    </div>
    <div class="form-field">
        <label for="term_meta[descripURLmicrofinanzasUno]">Descripción del enlace microfinanzas uno</label>
        <input type="text" name="term_meta[descripURLmicrofinanzasUno]" id="term_meta[descripURLmicrofinanzasUno]" value="">
        <p class="description">Nombre descriptivo de la URL</p>
    </div>
    <div class="form-field">
        <label for="term_meta[URLMicrofinanzasUno]">URL del enlace microfinanzas uno</label>
        <input type="url" name="term_meta[URLMicrofinanzasUno]" id="term_meta[URLMicrofinanzasUno]" value="">
    </div>
    <div class="form-field">
        <label for="term_meta[descripURLmicrofinanzasDos]">Descripción del enlace microfinanzas dos</label>
        <input type="text" name="term_meta[descripURLmicrofinanzasDos]" id="term_meta[descripURLmicrofinanzasDos]" value="">
        <p class="description">Nombre descriptivo de la URL</p>
    </div>
    <div class="form-field">
        <label for="term_meta[URLMicrofinanzasDos]">URL del enlace microfinanzas dos</label>
        <input type="url" name="term_meta[URLMicrofinanzasDos]" id="term_meta[URLMicrofinanzasDos]" value="">
    </div>

    <!--Elimina el campo descripcion que viene por defecto-->
    <style>.term-description-wrap{display:none !important;}</style>
    
    <?php

}
add_action('ambito_geografico_add_form_fields', 'ambito_geografico_add_new_meta_fields', 0, 2);



//Funcion para modificar campos
function ambito_geografico_edit_meta_fields($term){
    $t_id = $term->term_id;
 
    $term_meta = get_term_meta($t_id);

    ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[isoCode]">Código ISO del país</label>
            </th>
            <td>
                <input type="text" name="term_meta[isoCode]" id="term_meta[isoCode]" value="<?php echo esc_attr( $term_meta['isoCode'][0] ) ? esc_attr( $term_meta['isoCode'][0] ) : ''; ?>">
                <p class="description">Introduzca el código ISO que identifica al nuevo ámbito geográfico</p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[tituloModal]">Título de la ventana modal</label>
            </th>
            <td>
                <input type="text" name="term_meta[tituloModal]" id="term_meta[tituloModal]" value="<?php echo esc_attr( $term_meta['tituloModal'][0] ) ? esc_attr( $term_meta['tituloModal'][0] ) : ''; ?>">
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[descripcionModal]">Descripción de la ventana modal</label>
            </th>
            <td>
                <input type="text" name="term_meta[descripcionModal]" id="term_meta[descripcionModal]" value="<?php echo esc_attr( $term_meta['descripcionModal'][0] ) ? esc_attr( $term_meta['descripcionModal'][0] ) : ''; ?>">
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[descripURLmasInfo]">Descripción del enlace de la ventana modal</label>
            </th>
            <td>
                <input type="text" name="term_meta[descripURLmasInfo]" id="term_meta[descripURLmasInfo]" value="<?php echo esc_attr( $term_meta['descripURLmasInfo'][0] ) ? esc_attr( $term_meta['descripURLmasInfo'][0] ) : ''; ?>">
                <p class="description">Nombre descriptivo de la URL</p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[URLmasInfo]">URL del enlace de la ventana modal</label>
            </th>
            <td>
                <input type="url" name="term_meta[URLmasInfo]" id="term_meta[URLmasInfo]" value="<?php echo esc_attr( $term_meta['URLmasInfo'][0] ) ? esc_attr( $term_meta['URLmasInfo'][0] ) : ''; ?>">
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[descripURLpais]">Descripción del enlace del país</label>
            </th>
            <td>
                <input type="text" name="term_meta[descripURLpais]" id="term_meta[descripURLpais]" value="<?php echo esc_attr( $term_meta['descripURLpais'][0] ) ? esc_attr( $term_meta['descripURLpais'][0] ) : ''; ?>">
                <p class="description">Nombre descriptivo de la URL</p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[URLpais]">URL del enlace del país</label>
            </th>
            <td>
                <input type="url" name="term_meta[URLpais]" id="term_meta[URLpais]" value="<?php echo esc_attr( $term_meta['URLpais'][0] ) ? esc_attr( $term_meta['URLpais'][0] ) : ''; ?>">
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[descripURLaprenderMas]">Descripción del enlace aprender más</label>
            </th>
            <td>
                <input type="text" name="term_meta[descripURLaprenderMas]" id="term_meta[descripURLaprenderMas]" value="<?php echo esc_attr( $term_meta['descripURLaprenderMas'][0] ) ? esc_attr( $term_meta['descripURLaprenderMas'][0] ) : ''; ?>">
                <p class="description">Nombre descriptivo de la URL</p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[URLaprenderMas]">URL del enlace aprender más</label>
            </th>
            <td>
                <input type="url" name="term_meta[URLaprenderMas]" id="term_meta[URLaprenderMas]" value="<?php echo esc_attr( $term_meta['URLaprenderMas'][0] ) ? esc_attr( $term_meta['URLaprenderMas'][0] ) : ''; ?>">
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[tituloMicrofinanzas]">Título microfinanzas</label>
            </th>
            <td>
                <input type="text" name="term_meta[tituloMicrofinanzas]" id="term_meta[tituloMicrofinanzas]" value="<?php echo esc_attr( $term_meta['tituloMicrofinanzas'][0] ) ? esc_attr( $term_meta['tituloMicrofinanzas'][0] ) : ''; ?>">
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[descripcionMicrofinanzas]">Descripción microfinanzas</label>
            </th>
            <td>
                <input type="text" name="term_meta[descripcionMicrofinanzas]" id="term_meta[descripcionMicrofinanzas]" value="<?php echo esc_attr( $term_meta['descripcionMicrofinanzas'][0] ) ? esc_attr( $term_meta['descripcionMicrofinanzas'][0] ) : ''; ?>">
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[descripURLmicrofinanzasUno]">Descripción del enlace microfinanzas uno</label>
            </th>
            <td>
                <input type="text" name="term_meta[descripURLmicrofinanzasUno]" id="term_meta[descripURLmicrofinanzasUno]" value="<?php echo esc_attr( $term_meta['descripURLmicrofinanzasUno'][0] ) ? esc_attr( $term_meta['descripURLmicrofinanzasUno'][0] ) : ''; ?>">
                <p class="description">Nombre descriptivo de la URL</p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[URLMicrofinanzasUno]">URL del enlace microfinanzas uno</label>
            </th>
            <td>
                <input type="url" name="term_meta[URLMicrofinanzasUno]" id="term_meta[URLMicrofinanzasUno]" value="<?php echo esc_attr( $term_meta['URLMicrofinanzasUno'][0] ) ? esc_attr( $term_meta['URLMicrofinanzasUno'][0] ) : ''; ?>">
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[descripURLmicrofinanzasDos]">Descripción del enlace microfinanzas dos</label>
            </th>
            <td>
                <input type="text" name="term_meta[descripURLmicrofinanzasDos]" id="term_meta[descripURLmicrofinanzasDos]" value="<?php echo esc_attr( $term_meta['descripURLmicrofinanzasDos'][0] ) ? esc_attr( $term_meta['descripURLmicrofinanzasDos'][0] ) : ''; ?>">
                <p class="description">Nombre descriptivo de la URL</p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="term_meta[URLMicrofinanzasDos]">URL del enlace microfinanzas dos</label>
            </th>
            <td>
                <input type="url" name="term_meta[URLMicrofinanzasDos]" id="term_meta[URLMicrofinanzasDos]" value="<?php echo esc_attr( $term_meta['URLMicrofinanzasDos'][0] ) ? esc_attr( $term_meta['URLMicrofinanzasDos'][0] ) : ''; ?>">
            </td>
        </tr>
    <?php
}
add_action( 'ambito_geografico_edit_form_fields', 'ambito_geografico_edit_meta_fields', 0, 2 );



//Funcion para guardar los datos
function ambito_geografico_save_custom_meta( $term_id ) {

    if (isset($_POST['term_meta']['isoCode'])) {
        update_term_meta($term_id, "isoCode" , $_POST['term_meta']['isoCode']);
    }
    if (isset($_POST['term_meta']['tituloModal'])) {
        update_term_meta($term_id, "tituloModal" , $_POST['term_meta']['tituloModal']);
    }
    if (isset($_POST['term_meta']['descripcionModal'])) {
        update_term_meta($term_id, "descripcionModal" , $_POST['term_meta']['descripcionModal']);
    }
    if (isset($_POST['term_meta']['descripURLmasInfo'])) {
        update_term_meta($term_id, "descripURLmasInfo" , $_POST['term_meta']['descripURLmasInfo']);
    }
    if (isset($_POST['term_meta']['URLmasInfo'])) {
        update_term_meta($term_id, "URLmasInfo" , $_POST['term_meta']['URLmasInfo']);
    }
    if (isset($_POST['term_meta']['descripURLpais'])) {
        update_term_meta($term_id, "descripURLpais" , $_POST['term_meta']['descripURLpais']);
    }
    if (isset($_POST['term_meta']['URLpais'])) {
        update_term_meta($term_id, "URLpais" , $_POST['term_meta']['URLpais']);
    }
    if (isset($_POST['term_meta']['descripURLaprenderMas'])) {
        update_term_meta($term_id, "descripURLaprenderMas" , $_POST['term_meta']['descripURLaprenderMas']);
    }
    if (isset($_POST['term_meta']['URLaprenderMas'])) {
        update_term_meta($term_id, "URLaprenderMas" , $_POST['term_meta']['URLaprenderMas']);
    }
    if (isset($_POST['term_meta']['tituloMicrofinanzas'])) {
        update_term_meta($term_id, "tituloMicrofinanzas" , $_POST['term_meta']['tituloMicrofinanzas']);
    }
        if (isset($_POST['term_meta']['descripcionMicrofinanzas'])) {
        update_term_meta($term_id, "descripcionMicrofinanzas" , $_POST['term_meta']['descripcionMicrofinanzas']);
    }
    if (isset($_POST['term_meta']['descripURLmicrofinanzasUno'])) {
        update_term_meta($term_id, "descripURLmicrofinanzasUno" , $_POST['term_meta']['descripURLmicrofinanzasUno']);
    }
    if (isset($_POST['term_meta']['URLMicrofinanzasUno'])) {
        update_term_meta($term_id, "URLMicrofinanzasUno" , $_POST['term_meta']['URLMicrofinanzasUno']);
    }
    if (isset($_POST['term_meta']['descripURLmicrofinanzasDos'])) {
        update_term_meta($term_id, "descripURLmicrofinanzasDos" , $_POST['term_meta']['descripURLmicrofinanzasDos']);
    }
    if (isset($_POST['term_meta']['URLMicrofinanzasDos'])) {
        update_term_meta($term_id, "URLMicrofinanzasDos" , $_POST['term_meta']['URLMicrofinanzasDos']);
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

