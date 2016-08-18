<?php

/*
    Plugin Name: OS Tool Type
    Plugin URI: http://www.opensistemas.com/
    Description: Crea el tipo de contenido 'Herramienta'
    Version: 1.0
    Author: Marta Oliver
    Author Email: moliver@opensistemas.com
    Plugin URI: http://www.opensistemas.com/
    Text Domain: os_tool_type
    License: GPLv2 
*/

if (!class_exists('ToolCustomType')) :
  
   class ToolCustomType {   
        
        var $post_type = "tool";
        
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
            load_plugin_textdomain('os_tool_type', false, $plugin_dir . "/languages");
        }


        function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Tools', 'os_tool_type'),
                    'singular_name' => __('Tool', 'os_tool_type'),
                    'add_new' => __('Add new', 'os_tool_type'),
                    'add_new_item' => __('Add new tool', 'os_tool_type'),
                    'new_item' => __('New tool', 'os_tool_type'),
                    'edit_item' => __('Edit tool', 'os_tool_type'),
                    'view_item' => __('View tool', 'os_tool_type'),
                    'parent_item_colon' => __(' ', 'os_tool_type'),
                    'search_items' => __('Search tools', 'os_tool_type'),
                    'not_found' => __('No tools found', 'os_tool_type'),
                    'not_found_in_trash' => __('No tools found in trash', 'os_tool_type'),
                    'menu_name' => __('Tools', 'os_tool_type')
                ),
                'capability_type' => 'post',
                'description' => __("This post type collects different tools", "os_tool_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'Tool'),
                'menu_icon' =>  'dashicons-exerpt-view',
                'supports' => array("title")
            ));
        }


        // Añade los meta-boxes al tipo de post tool
        function meta_boxes_add() {
        	add_meta_box("image" ,__("Image", "os_tool_type"),array(&$this, "image_meta_box_callback"),$this->post_type);
        	add_meta_box("data" ,__("Tool data", "os_tool_type"),array(&$this, "tool_data_meta_box_callback"),$this->post_type);        	
        }

        
        function image_meta_box_callback($post) {        	
            
            // Get WordPress' media upload URL
            $upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

            // See if there's a media id already saved as post meta
            $your_img_id = get_post_meta( $post->ID, 'image', true );

            // Get the image src
            $your_img_src = wp_get_attachment_image_src( $your_img_id, 'full' );

            // For convenience, see if the array is valid
            $you_have_img = is_array( $your_img_src );
            ?>

            <!-- Your image container, which can be manipulated with js -->
            <div class="custom-img-container">
                <?php if ( $you_have_img ) : ?>
                    <img src="<?php echo $your_img_src[0] ?>" alt="" style="max-width:100%;" />
                <?php endif; ?>
            </div>

            <!-- Your add & remove image links -->
            <p class="hide-if-no-js">
                <a class="upload-custom-img <?php if ( $you_have_img  ) { echo 'hidden'; } ?>" 
                   href="<?php echo $upload_link ?>">
                    <?php _e('Set custom image') ?>
                </a>
                <a class="delete-custom-img <?php if ( ! $you_have_img  ) { echo 'hidden'; } ?>" 
                  href="#">
                    <?php _e('Remove this image') ?>
                </a>
            </p>

            <!-- A hidden input to set and post the chosen image id -->
            <input class="image" name="image" type="hidden" value="<?php echo esc_attr( $your_img_id ); ?>"
            <?php
       
        }


        function tool_data_meta_box_callback($post) {
        	wp_nonce_field( basename(__FILE__), 'tool_data-nonce');        	
        	$title = get_post_meta($post->ID, 'title');
            $link = get_post_meta($post->ID, 'link');
        	$description = get_post_meta( $post->ID, 'description');
        	?>        	
            <p>
                <label for="title"><?php _e('Title', 'os_tool_type')?></label>
                <input type="text" name="title" id="title" value="<?php if ( isset($title) ) echo $title[0]; ?>" />
            </p>
            <p>
                <label for="link"><?php _e('Link', 'os_tool_type')?></label>
                <input type="text" name="link" id="title" value="<?php if ( isset($link) ) echo $link[0]; ?>" />
            </p>
            <label for="description"><?php _e('Description', 'os_tool_type')?></label>
            <?php 
            $settings = array(
                'media_buttons' => false,
                'wpautop' => false,
                'textarea_rows' => 4,
                'tinymce' => false,
                'quicktags' => array()
            ); 
            wp_editor($description[0], 'description', $settings); 
        }



        function meta_boxes_save($post_id) {        	
            if (isset($_POST['title'])) {
                update_post_meta($post_id, 'title', strip_tags($_POST['title']));
            }
            if (isset($_POST['link'])) {
                update_post_meta($post_id, 'link', strip_tags($_POST['link']));
            }
            if (isset($_POST['description'])) {
                update_post_meta( $post_id, 'description', strip_tags($_POST['description']));
            }
            if (isset($_POST['image'])) {
                update_post_meta( $post_id, 'image', strip_tags($_POST['image']));
            }
        }


        function register_admin_styles(){
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_style('tool-type-css', plugin_dir_url( __FILE__ ) . 'css/os_tool_type.css');               
            }
        }


        function register_admin_scripts() {
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_media();
                wp_register_script('os-tool-type-js', plugins_url('js/os_tool_type.js' , __FILE__), array('jquery'));
                wp_enqueue_script('os-tool-type-js');
            }
        }

    }

    $osTool = new ToolCustomType();


endif;