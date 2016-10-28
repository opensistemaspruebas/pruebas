<?php
	

// Registro del menú de WordPress
add_theme_support('nav-menus');
if (function_exists('register_nav_menus')) {
	register_nav_menus(
		array(
		  'main' => 'menu_header'
		)
	);
}
	

// Registro de sidebar
if (function_exists('register_sidebar')) {
	register_sidebar(
		array(
			'name' => 'Main Sidebar',
			'id' => 'sidebar-0',
			'description' => __('Sidebar Principal'),
			'class' => '',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
	

}


// Quitar del menú las entradas por defecto
function remove_default_post_type() {
	remove_menu_page('edit.php');
}
add_action('admin_menu','remove_default_post_type');


// Obtiene las etiquetas de un post
function get_atts($post) {
    return wp_get_post_terms(get_the_ID(), array('category', 'ambito_geografico'), array('fields'=>'ids'));
}


// Pinta los metas para el buscador
function add_search_meta() {
    
    $post_type = get_post_type();
    
    $types = array('publicacion', 'historia', 'taller');
    
    if (in_array($post_type, $types) && is_single()) : $p = get_post(get_the_ID()); $attrs = get_atts($p);
    	$post_content = '';
    	$authors = get_coauthors(get_the_ID());
    	$autores = [];
    	if (!empty($authors)) {
    		foreach ($authors as $author) {
				if (is_a($author, 'WP_User')) {
					$name = $author->data->display_name;
				} else {
					$name = $author->display_name;
				}
    			$autores[] = getCleanedString($name);
    		}
    	}
    	$destacada = get_post_meta($p->ID, 'destacada', true);
    	if ($post_type == 'publicacion') {
    		$abstract_destacado = get_post_meta($p->ID, 'abstract_destacado', true);
    		$abstract_contenido = get_post_meta($p->ID, 'abstract_contenido', true);
    		if (empty($abstract_destacado) && empty($abstract_contenido)) {
    			$post_content = strip_tags($p->post_content);
    		} else {
    			$post_content = strip_tags(get_post_meta($p->ID, 'abstract_destacado', true) . ' ' . get_post_meta($p->ID, 'abstract_contenido', true));
    		}
    		$fecha = get_post_meta($p->ID, 'publication_date', true);
    	} else {
    		$post_content = strip_tags($p->post_content);
    		$fecha = get_the_date('Y-m-d');
    	}
        ?>
        <meta name="wp_search" content="true"/>
        <meta name="wp_content" content="<?php echo htmlentities(str_replace(array("\r\n","\n"),'',strip_tags($post_content))); ?>"/>
        <meta name="wp_title" content="<?php echo htmlentities(str_replace(array("\r\n","\n"),'',strip_tags($p->post_title))); ?>"/>
        <meta name="wp_text_array" content="<?php echo implode($autores, ',');  ?>"/>
        <meta name="wp_double_array" content="<?php echo implode($attrs, ','); ?>"/>
        <meta name="wp_date" content="<?php echo $fecha; ?>"/>
        <meta name="wp_topic" content="<?php echo get_post_type(); /*if ($destacada) echo '_destacada';*/ ?>"/>
        <meta name="image_src" content="<?php echo str_replace('http://ec2-52-209-71-102.eu-west-1.compute.amazonaws.com', '', get_post_meta(get_the_ID(), 'imagenCard', true) ); ?>"/>
    <?php endif;
}
add_action('wp_head', 'add_search_meta', 100);


// Limpia cadenas de carácteres
function getCleanedString($cadena) {
	
	$cadena = strip_tags($cadena);
	$cadena = normaliza($cadena);
	$cadena = preg_replace("/[^a-zA-Z0-9]/", " ", $cadena);
	$cadena = preg_replace('/\s+/', ' ',$cadena);
	$cadena = trim($cadena);
	$cadena = strtolower($cadena);
	
	return $cadena;

}

// Normaliza cadenas de carácteres
function normaliza($cadena){
    
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
    
    return utf8_encode($cadena);
}


// Obtiene el id de un attachment por su url
function get_attachment_id_by_url($url) {
	$parsed_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );
	$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
	$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );
	if ( ! isset( $parsed_url[1] ) || empty( $parsed_url[1] ) || ( $this_host != $file_host ) ) {
		return;
	}
	global $wpdb;
	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parsed_url[1] ));
	return $attachment[0];
}


// Adapto menú a nuestros estilos
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
  function start_el ( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		$output .= $indent . '<li class="panel">';
		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
		$item_output = $args->before;
		$item_output .= '<a class="collapsed mr-sm" '. $attributes .'>';
		$item_output .= '<span class="hidden-xs">' . $title . '</span>';
		$item_output .= '<span class="visible-xs pl-lg">' . $title . '</span>';
		$item_output .= '</a>';
		$item_output .= '<a class="hidden" role="button" data-toggle="collapse" data-parent="#topmenu" data-target="#publish">';
        $item_output .= '<span>' . $title . '</span>';
        $item_output .= '</a>';
		$item_output .= $args->after;
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $output .= "</li>\n";
  }
}


// Formateo de cifras
function thousandsCurrencyFormat($num) {
	$x = round($num);
	$x_number_format = number_format($x);
	$x_array = explode(',', $x_number_format);
	$x_parts = array(' K', ' MM', ' B', ' T');
	$x_count_parts = count($x_array) - 1;
	$x_display = $x;
	$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? ',' . $x_array[1][0] : '');
	$x_display2 = $x_parts[$x_count_parts - 1];

	$values = array($x_display, $x_display2);

	return $values;
}


// Formateo de cifras con etiquetas
function thousandsCurrencyFormatCustom($num) {
	$x = round($num);
	$x_number_format = number_format($x);
	$x_array = explode(',', $x_number_format);
	$x_parts = array('K', 'MM', 'B', 'T');
	$x_count_parts = count($x_array) - 1;
	$x_display = $x;
	$x_display = '<span class="label">' . $x_array[0] . ((int) $x_array[1][0] !== 0 ? ',' . $x_array[1][0] : '') . '</span>';
	$x_display .= ' <span class="meter">' . $x_parts[$x_count_parts - 1] . '</span>';
	return $x_display;
}


function os_imprimir($array,$parar) {
	echo '<pre>';
	print_r($array);
	echo '</pre>';
	if($parar) {
		exit();
	}
}


function languages_list_header(){
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    ?>
	<div class="top hidden-xs">
        <div class="container">
            <div class="languages-menu">
                <label for="language-header" class="hidden"><?php _e('Idioma'); ?></label>
            	<div class="btn-group languages-buttons" data-toggle="buttons">
            		<?php $i = 1; ?>
            		<?php foreach ($languages as $l) : ?>
                		<a href="<?php echo $l['url']; ?>" class="btn btn-primary <?php if ($l['active']) echo 'active'; ?>"><?php echo strtoupper($l['code']); ?></a>
                		<?php $i++; ?>
                	<?php endforeach; ?>
            	</div>
            </div>
        </div>
    </div>
    <?php
}


function languages_list_header_responsive(){
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    ?>
	<div class="visible-xs">
	    <div class="languages-menu pb-lg pl-lg">
	    	<?php $i = 0; ?>
	    	<?php foreach ($languages as $l) : ?>
		    	<a href="<?php echo $l['url']; ?>" role="button" class="languages-mobile-button <?php if ($l['active']) echo 'active';?> <?php if ($i == 1) echo 'ml-lg'; ?>">
		    		<span class="language"><?php echo $l['native_name']; ?></span>
		    	</a>
		    	<?php $i++; ?>
	    	<?php endforeach; ?>
	    </div>
	</div>
    <?php
}

/* dgonzalez:new Rewrite for authors */
add_action( 'generate_rewrite_rules', 'add_rule_coauthors' );
function add_rule_coauthors() {
            global $wp_rewrite;
            $new_rules = array(
                'perfiles/(.+)$' => 'index.php?pagename=perfiles&coauthor=' . $wp_rewrite->preg_index(1)
            );
		error_log("paso por el rewrite ". print_r($new_rules,true));
            $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}

function add_coauthor_query_var($vars) {
	 $vars[] .= 'coauthor';
	 return $vars;
}
add_filter( 'query_vars', 'add_coauthor_query_var' );

/* Añade metadatos a los posts que se comparten en Facebook y Google+ */
function add_opengraph_meta() {
	global $post;

	if(!is_single())
		return;

	// Si es un tipo de post que vamos a compartir, incluimos los metadatos
	if($post->post_type == 'historia' || $post->post_type == 'publicacion') {
		// La imagen se obtiene de un campo diferente según el tipo de post
		$imagen = '';
		if($post->post_type == 'historia') {
			$imagenCard = get_post_meta($post->ID, 'imagenCard', true);
			$imagen = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCard));
			$description = get_the_excerpt();
		}
		if($post->post_type == 'publicacion') {
			$imagenCard = get_post_meta($post->ID, 'imagenCard', true);
			$imagen = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCard));
			$description = get_the_excerpt(); //poner mi custom field
		}


		?>

		<link rel="canonical" href="<?php echo get_permalink(); ?>">
	    <meta property="og:image" content="<?php echo $imagen; ?>">
	    <meta property="og:type" content="article">
	    <meta property="og:url" content="<?php echo get_permalink(); ?>">
	    <meta property="og:title" content="<?php the_title(); ?>">
	    <meta property="og:description" content="<?php echo $description; ?>">
	    <meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>">

	    <?php

	} else {
		return;
	}
}
add_action( 'wp_head', 'add_opengraph_meta', 5 );

function my_show_extra_profile_fields( $user ) { ?>
	<h3><?php _e("Campos adicionales"); ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="twitter"><?php _e("Cargo/Estudios de la persona"); ?></label></th>

			<td>
				<input type="text" name="cargo" id="cargo" value="<?php echo esc_attr( get_the_author_meta( 'cargo', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
	</table>
<?php }
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );


function my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, 'cargo', $_POST['cargo'] );
}
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );


function get_fecha_formateada($publication_date) {
	$meses = array(
		__("Enero", "os_cards_widget_json"), 
		__("Febrero", "os_cards_widget_json"), 
		__("Marzo", "os_cards_widget_json"), 
		__("Abril", "os_cards_widget_json"), 
		__("Mayo", "os_cards_widget_json"), 
		__("Junio", "os_cards_widget_json"), 
		__("Julio", "os_cards_widget_json"), 
		__("Agosto", "os_cards_widget_json"), 
		__("Septiembre", "os_cards_widget_json"), 
		__("Octubre", "os_cards_widget_json"), 
		__("Noviembre", "os_cards_widget_json"), 
		__("Diciembre", "os_cards_widget_json")
	);
	$format = "Y-m-d";
	$dateobj = DateTime::createFromFormat($format, $publication_date);
	return $dateobj->format('d') . ' ' . $meses[$dateobj->format('m') - 1] . ' ' . $dateobj->format('Y');
}