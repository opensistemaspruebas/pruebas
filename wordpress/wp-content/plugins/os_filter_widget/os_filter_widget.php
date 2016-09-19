<?php

/*
	Plugin Name: OS Filter Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que busca publicaciones y filtra por etiquetas.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_filter_widget
*/


if (!class_exists('OS_Filter_Widget')) :

	class OS_Filter_Widget extends WP_Widget {


	    function __construct() {
	        parent::__construct(
	        	'os_filter_widget',
	        	__('OS Filter Widget', 'os_filter_widget'),
	        	array(
	            	'description' => __('Widget que busca publicaciones y filtra por etiquetas', 'os_filter_widget')
	        	)
	        );
	        wp_register_script('os_filter_widget_js', plugins_url('js/os_filter_widget_min.js' , __FILE__), array('jquery'));
	        $translation_array = array(
				'no_results' => __('No results found', 'os_filter_widget'),
				'more_results' => __('More', 'os_filter_widget'),
				'sort_by_asc_date' => __('Older', 'os_filter_widget'),
				'sort_by_desc_date' => __('Recents', 'os_filter_widget'),
				'sort_by_popular' => __('Popular', 'os_filter_widget'),
				'ajaxurl' => admin_url('admin-ajax.php'),
				
			);
			wp_localize_script('os_filter_widget_js', 'object_name', $translation_array);
            wp_enqueue_script('os_filter_widget_js');
        }


	    public function widget($args, $instance) {

	    	echo $args['before_widget'];

	    	$categories = get_terms(
				array(
					"taxonomy" => array("post_tag", "category"),
					"hide_empty" => false,
					"fields" => "names"
				)
			);

			$authors = get_users(
				array(
					'fields' => array(
						'display_name'
					),
					'who' => 'authors'
				)
			);

	    	$countries = get_terms(
				array(
					"taxonomy" => array("ambito_geografico"),
					"hide_empty" => false,
					"fields" => "names"
				)
			);

			echo $args['before_title']; 
			_e('Filtros', 'os_filter_widget');
			echo $args['after_title']; 
			
			?>
			<form action="#" method="get" name="form_filter" id="form_filter">
				<label for="inputText" class="assistive-text hidden"><?php _e('Texto', 'os_filter_widget'); ?></label>
				<input type="text" class="field" name="inputText" id="inputText">
				<div id="caja_seleccion">
					<ul id="seleccion" name="seleccion"></ul>
				</div>
				<input type="submit" name="submitButton" id="submitButton" value="<?php _e('Buscar', 'os_filter_widget'); ?>">
				<input type="hidden" name="size" id="size" value="7">
				<input type="hidden" name="start" id="start" value="0">
				<input type="hidden" name="inputSortBy" id="inputSortBy" value="date desc">
				<div id="caja_categorias" id="caja_categorias" style="display: none;">
					<h2><?php _e('Categorías', 'os_filter_widget'); ?> <span class="num">(<?php echo wp_count_terms("category"); ?>)</span></h2>
					<?php if (!empty($categories)) : ?>
					<ul id="categorias" name="categorias">
						<?php foreach ($categories as $category) : ?>
							<li class="categoria" data-name="<?php echo $category; ?>" style="display: none;"><a href="#"><?php echo $category; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>

				<div id="caja_autores" id="caja_autores" style="display: none;">
					<h2><?php _e('Autores', 'os_filter_widget'); ?> <span class="num">(<?php echo count($authors); ?>)</span></h2>
					<?php if (!empty($authors)) : ?>
					<ul id="autores" name="autores">
						<?php foreach ($authors as $author) : ?>
							<li class="autor" data-name="<?php echo $author->display_name; ?>" style="display: none;"><a href="#"><?php echo $author->display_name; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
				<div id="caja_paises" id="caja_paises" style="display: none;">
					<h2><?php _e('Ámbito geográfico', 'os_filter_widget'); ?> <span class="num">(<?php echo wp_count_terms("ambito_geografico"); ?>)</span></h2>
					<?php if (!empty($countries)) : ?>
					<ul id="paises" name="paises">
						<?php foreach ($countries as $country) : ?>
							<li class="pais" data-name="<?php echo $country; ?>"><a href="#"><?php echo $country; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
			</form>
			<div id="sortLinks"></div>
			<div id="results"></div>			
			<div id="moreLink"></div>
			<?php

			echo $args['after_widget'];
	    }


	    public function form($instance) {
	        ?>
	        <p><?php _e('Este widget no tiene parámetros configurables.', 'os_filter_widget'); ?></p>
	        <?php
	    }


	    function update($new_instance, $old_instance) {
	    	return $new_instance;
	    }

	}

	function os_filter_widget() {
	    register_widget('os_filter_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_filter_widget');


endif;


class JSONPost {

    private static function saveInfo($name,$info,$post=false){
        $debug = false;
        $path = '/var/www/bbvaLiteracy/wp-content/_json/';
        if($post){
            $path .= '_publicaciones/';
        }
        if (!is_dir($path)) {
            mkdir($path,0777,true);
        }
        $path .= $name.'.json';
        if($debug){
            echo "Guardamos ".$name."\r\n";
        }
        if(!file_put_contents($path,json_encode($info))) {
            echo 'Error generando JSON del artículo';
            exit();
        }
    }

    private function get_words($sentence, $count = 55) {
        preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
        return $matches[0];
    }

    public static function savePost($post_id){

    	//error_log("+++ paso por aqui +++");
    	//error_log($post_id);

        $os_query = new WP_Query('p=' . $post_id . '&post_type=publicacion');

        $res = array();
        while ($os_query->have_posts()) : $os_query->the_post();

        	error_log("bucle");

            /*$content_partial = 'content';
            if(isset($_POST['layout_type'])){
                if($_POST['layout_type'] == 'v2'){
                    $content_partial = 'v2-content';
                }
                if($_POST['layout_type'] == 'v3'){
                    $content_partial = 'v3-content';
                }
                if($_POST['layout_type'] == 'v3-simple'){
                    $content_partial = 'v3-content';
                    global $forse_hide_element_read_more;
                    global $forse_hide_element_date;
                    $forse_hide_element_read_more = true;
                    $forse_hide_element_date = true;
                }
                if(in_array($_POST['template_type'], array('page-masonry-condensed-facebook', 'page-masonry-simple-facebook'))){
                    global $facebook_likes;
                    $facebook_likes = true;
                }
                if($_POST['template_type'] == 'page-masonry-condensed-fixed-height'){
                    global $forse_fixed_height;
                    $forse_fixed_height = true;
                }
                if($_POST['template_type'] == 'page-masonry-condensed-with-author'){
                    global $show_author_face;
                    $show_author_face = true;
                }
            }
            $res['body'] = os_load_template_part( $content_partial, get_post_format() );*/
            $res['cats'] = wp_get_post_terms($post_id, array('category', 'ambito_geografico'));
            JSONPost::saveInfo($post_id,$res,true);
        endwhile;
    }

    public static function regen(){
        $args = array(
            'post_type' =>  'publicacion',
            'numberposts' => -1,
            'fields' => 'ids'
        );
        $postslist = get_posts( $args );
        foreach($postslist as $id){
            JSONPost::savePost($id,false,false);
        }
    }
}

add_action('save_post', array(JSONPost, 'savePost'));