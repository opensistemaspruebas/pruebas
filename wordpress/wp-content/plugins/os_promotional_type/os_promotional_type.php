<?php

/*
    Plugin Name: OS Promotional Type
    Plugin URI: http://www.opensistemas.com/
    Description: Crea el tipo de contenido 'Promocional'
    Version: 1.0
    Author: Marta Oliver
    Author Email: moliver@opensistemas.com
    Plugin URI: http://www.opensistemas.com/
    Text Domain: os_promotional_type
    License: GPLv2 
*/

if (!class_exists('PromCustomType')) :
  
   class PromCustomType {   
        
        var $post_type = "promotional";
        
        function __construct() {
            add_action('init', array(&$this, 'create_post_type'));
            add_action('add_meta_boxes', array(&$this, 'meta_boxes_add'));
            add_action('save_post', array(&$this, "meta_boxes_save"));
            add_action('admin_print_styles', array(&$this,'register_admin_styles'));
            add_action('admin_enqueue_scripts', array(&$this, 'register_admin_scripts'));
            add_action('plugins_loaded', array(&$this, 'load_text_domain'), 10);
        }


        // Selecciona el dominio para la traducción
        function load_text_domain() {
            $plugin_dir = basename(dirname(__FILE__));
            load_plugin_textdomain('os_promotional_type', false, $plugin_dir . "/languages");
        }


        function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Promotionals', 'os_promotional_type'),
                    'singular_name' => __('Promotional', 'os_promotional_type'),
                    'add_new' => __('Add new', 'os_promotional_type'),
                    'add_new_item' => __('Add new promotional', 'os_promotional_type'),
                    'new_item' => __('New promotional', 'os_promotional_type'),
                    'edit_item' => __('Edit promotional', 'os_promotional_type'),
                    'view_item' => __('View promotional', 'os_promotional_type'),
                    'parent_item_colon' => __(' ', 'os_promotional_type'),
                    'search_items' => __('Search promotionals', 'os_promotional_type'),
                    'not_found' => __('No promotionals found', 'os_promotional_type'),
                    'not_found_in_trash' => __('No promotionals found in trash', 'os_promotional_type'),
                    'menu_name' => __('Promotionals', 'os_promotional_type')
                ),
                'capability_type' => 'post',
                'description' => __("This post type collects different promotional", "os_promotional_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'Promotional'),
                'menu_icon' =>  'dashicons-exerpt-view',
                'supports' => array("title")
            ));
        }


        // Añade los meta-boxes al tipo de post promotional
        function meta_boxes_add() {
        	add_meta_box("image" ,__("Image", "os_promotional_type"),array(&$this, "iv_meta_box_callback"),$this->post_type,"side","low");
        	add_meta_box("prom-data" ,__("Highlighted data", "os_promotional_type"),array(&$this, "high_data_meta_box_callback"),$this->post_type);
        	add_meta_box("link-list" ,__("Link to page", "os_promotional_type"),array(&$this, "link_list_meta_box_callback"),$this->post_type);
        }

        
        function iv_meta_box_callback($post) {
        	wp_nonce_field(basename(__FILE__), 'iv-nonce');
        	$image = get_post_meta( $post->ID, 'image');
        	?>
        	<p>
                <label for="image"><?php _e('Explore or upload an image', 'os_promotional_type'); ?></label>
            </p>
            <p>
                <input class="widefat" id="image" name="image" type="text" value="<?php if (isset($image)) echo $image[0]; ?>" readonly="readonly"/>
            </p>
            <p>
                <img src="<?php echo esc_attr($image[0]); ?>" style='max-height:100px;' > 
            </p>
            <p>
                <input id="upload_image" name="upload_image" type="button" value="<?php _e('Explore/Upload', 'os_promotional_type'); ?>" />
            </p>
        	<?php
        }


        function high_data_meta_box_callback($post) {
        	wp_nonce_field( basename( __FILE__ ), 'high_data-nonce');
        	$heading = get_post_meta( $post->ID, 'heading');
        	$title = get_post_meta( $post->ID, 'title');
        	$body = get_post_meta( $post->ID, 'body');
        	?>
        	<p>
                <label for="heading" class="prom-field-name"><?php _e('Heading', 'os_promotional_type' )?></label>
                <input type="text" name="heading" id="heading" value="<?php if ( isset($heading) ) echo $heading[0]; ?>" />
            </p>
            <p>
                <label for="title" class="prom-field-name"><?php _e('Title', 'os_promotional_type')?></label>
                <input type="text" name="title" id="title" value="<?php if ( isset($title) ) echo $title[0]; ?>" />
            </p>
            <label for="body" class="prom-field-name"><?php _e('Body', 'os_promotional_type' )?></label>
            <?php 
            $settings = array(
                'media_buttons' => false,
                'wpautop' => false,
                'textarea_rows' => 4,
                'tinymce' => false,
                'quicktags' => array()
            ); 
            wp_editor($body[0], 'body', $settings); 
        }


        function link_list_meta_box_callback($post) {
        	wp_nonce_field( basename( __FILE__ ), 'link_list-nonce');
        	$link_text = get_post_meta( $post->ID, 'prom-link-text');
        	$linked_page = get_post_meta( $post->ID, 'prom-linked-page');
        	$dropdown_args = array(
                'post_type' => 'page',
                'name' => 'prom-linked-page',
                'sort_column' => 'menu_order, post_title',
                'selected' =>  empty($linked_page) ? 0 : $linked_page[0],
                'echo' => 0,
	        );
	        //Dropdown of pages
	        $pages_list = wp_dropdown_pages( $dropdown_args );
	        ?>
	        <p>
				<label class="prom-field-name" for="prom-link-text"><?php _e('Text', 'os_promotional_type'); ?></label>
				<input class="widefat" id="prom-link-text" name="prom-link-text" type="text" value="<?php if ( isset($link_text) ) echo $link_text[0]; ?>" />
			</p>
	        <p class="int-link">
				<label class="prom-field-name" for="prom-linked-page"><?php _e('Page', 'os_promotional_type'); ?></label>
				<?php echo $pages_list ?>
			</p>
			<?php
        }


        function meta_boxes_save($post_id) {
        	if (isset($_POST['image'])) {
                update_post_meta($post_id, 'image', strip_tags($_POST['image']));
            }
        	if (isset($_POST[ 'prom-link-text'])) {
                update_post_meta( $post_id, 'prom-link-text', strip_tags($_POST['prom-link-text']));
            }
            if (isset($_POST['prom-linked-page'])) {
                update_post_meta($post_id, 'prom-linked-page', strip_tags($_POST['prom-linked-page']));
            }
        	if (isset($_POST['heading'])) {
                update_post_meta( $post_id, 'heading', strip_tags($_POST['heading']));
            }
            if (isset($_POST['title'])) {
                update_post_meta($post_id, 'title', strip_tags($_POST['title']));
            }
            if (isset($_POST['body'])) {
                update_post_meta( $post_id, 'body', strip_tags($_POST['body']));
            }
        }


        function register_admin_styles(){
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_style('promotional-type-css', plugin_dir_url( __FILE__ ) . 'css/os_promotional_type.css');               
            }
        }


        function register_admin_scripts() {
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_media();
                wp_register_script('os-promotionals-js', plugins_url('js/os-promotional.js' , __FILE__), array('jquery'));           
                wp_enqueue_script('os-promotionals-js');
            }
        }

    }

    $osProm = new PromCustomType();

endif;