<?php

/*
    Plugin Name: LY Event Type
    Plugin URI: http://www.opensistemas.com/
    Description: Creates the content type 'Event'
    Version: 1.0
    Author: Roberto Moreno
    Author Email: rmoreno@opensistemas.com
    Plugin URI: http://www.opensistemas.com/
    Text Domain: ly_event_type
    License: GPLv2 
*/

if (!class_exists('EventCustomType')) :
  
   class EventCustomType {   
        
        var $post_type = "event";
        
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
            load_plugin_textdomain('ly_event_type', false, $plugin_dir . "/languages");
        }


        function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Event', 'ly_event_type'),
                    'singular_name' => __('Event', 'ly_event_type'),
                    'add_new' => __('Add new event', 'ly_event_type'),
                    'add_new_item' => __('Add new event', 'ly_event_type'),
                    'new_item' => __('New event', 'ly_event_type'),
                    'edit_item' => __('Edit event', 'ly_event_type'),
                    'view_item' => __('View event', 'ly_event_type'),
                    'parent_item_colon' => __(' ', 'ly_event_type'),
                    'search_items' => __('Search events', 'ly_event_type'),
                    'not_found' => __('No events found', 'ly_event_type'),
                    'not_found_in_trash' => __('No events found in trash', 'ly_event_type'),
                    'menu_name' => __('Events', 'ly_event_type')
                ),
                'capability_type' => 'post',
                'description' => __("This post type collects different events", "ly_event_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'Event'),
                'menu_icon' =>  'dashicons-exerpt-view',
                'supports' => array("title")
            ));
        }


        // Añade los meta-boxes al tipo de post tool
        function meta_boxes_add() {

            add_meta_box("event-data" ,__("Event data", "ly_event_type"),array(&$this, "event_data_meta_box_callback"),$this->post_type);
            add_meta_box("programme-data" ,__("Programme data", "ly_event_type"),array(&$this, "programme_data_meta_box_callback"),$this->post_type);
            add_meta_box("speaker-data" ,__("Speaker data", "ly_event_type"),array(&$this, "speaker_data_meta_box_callback"),$this->post_type);
            add_meta_box("image" ,__("Image event", "ly_event_type"),array(&$this, "image_meta_box_callback"),$this->post_type);            
        }


        function event_data_meta_box_callback($post) {

            wp_nonce_field( basename(__FILE__), 'event-nonce');         
            
            $highlights = get_post_meta($post->ID, 'highlights');
            $topics = get_post_meta($post->ID, 'topics');
            $year = get_post_meta( $post->ID, 'year');
            $city = get_post_meta( $post->ID, 'city');
            $specificContact = get_post_meta( $post->ID, 'specificContact');
            ?>          
            <p>
                <label for="highlights"><?php _e('Highlights', 'ly_event_type')?></label>
                <input type="text" name="highlights" id="highlights" value="<?php if ( isset($highlights) ) echo $highlights[0]; ?>" />
            </p>
            <p>
                <label for="topics"><?php _e('Topics', 'ly_event_type')?></label>
                <input type="text" name="topics" id="topics" value="<?php if ( isset($topics) ) echo $topics[0]; ?>" />
            </p>
            <p>
                <label for="year"><?php _e('Year', 'ly_event_type')?></label>
                <input type="text" name="year" id="year" value="<?php if ( isset($year) ) echo $year[0]; ?>" />
            </p>
            <p>
                <label for="city"><?php _e('City', 'ly_event_type')?></label>
                <input type="text" name="city" id="city" value="<?php if ( isset($city) ) echo $city[0]; ?>" />
            </p>
            <p>
                <label for="specificContact"><?php _e('Specific Contact', 'ly_event_type')?></label>
                <input type="text" name="specificContact" id="specificContact" value="<?php if ( isset($specificContact) ) echo $specificContact[0]; ?>" />
            </p>
            <?php
        }


        function programme_data_meta_box_callback($post) {

            wp_nonce_field( basename(__FILE__), 'proramme-nonce');         
            
            $title = get_post_meta($post->ID, 'title');
            $hour = get_post_meta($post->ID, 'topics');
            $speaker = get_post_meta( $post->ID, 'year');
            $description = get_post_meta( $post->ID, 'city');
            ?>          
            <p>
                <label for="title"><?php _e('Title', 'ly_event_type')?></label>
                <input type="text" name="title" id="title" value="<?php if ( isset($title) ) echo $title[0]; ?>" />
            </p>
            <p>
                <label for="hour"><?php _e('Hour', 'ly_event_type')?></label>
                <input type="text" name="hour" id="hour" value="<?php if ( isset($hour) ) echo $hour[0]; ?>" />
            </p>
            <p>
                <label for="speaker"><?php _e('Speaker', 'ly_event_type')?></label>
                <input type="text" name="speaker" id="speaker" value="<?php if ( isset($speaker) ) echo $speaker[0]; ?>" />
            </p>
            <label for="description" class="description"><?php _e('Description', 'ly_event_type' )?></label>
            <?php 
            $settings = array(
                'media_buttons' => false,
                'wpautop' => false,
                'textarea_rows' => 4,
                'tinymce' => false,
                'quicktags' => array()
            );
            wp_editor($description[0], 'description-information', $settings); 
            ?>
        
            <?php
        }

        function speaker_data_meta_box_callback($post) {

            wp_nonce_field( basename(__FILE__), 'speaker-nonce');         
            
            $name = get_post_meta($post->ID, 'name');
            $photo = get_post_meta($post->ID, 'topics');
            $bio = get_post_meta( $post->ID, 'year');
            ?>          
            <p>
                <label for="name"><?php _e('Name', 'ly_event_type')?></label>
                <input type="text" name="name" id="name" value="<?php if ( isset($name) ) echo $name[0]; ?>" />
            </p>
            <p>
                <label for="photo"><?php _e('Photo', 'ly_event_type')?></label>
                <input type="text" name="photo" id="photo" value="<?php if ( isset($photo) ) echo $photo[0]; ?>" />
            </p>
            <label for="bio" class="bio"><?php _e('Bio', 'ly_event_type' )?></label>
            <?php 
            $settings = array(
                'media_buttons' => false,
                'wpautop' => false,
                'textarea_rows' => 4,
                'tinymce' => false,
                'quicktags' => array()
            );
            wp_editor($bio[0], 'bio-information', $settings); 
            ?>
            <?php
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
                    <img src="<?php echo $your_img_src[0] ?>" alt="" style="max-width:50%;" />
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



        function meta_boxes_save($post_id) {            
            if (isset($_POST['name'])) {
                update_post_meta($post_id, 'name', strip_tags($_POST['name']));
            }
            if (isset($_POST['birthdate'])) {
                update_post_meta($post_id, 'birthdate', strip_tags($_POST['birthdate']));
            }
            if (isset($_POST['placeBirth'])) {
                update_post_meta( $post_id, 'placeBirth', strip_tags($_POST['placeBirth']));
            }
            if (isset($_POST['bio'])) {
                update_post_meta( $post_id, 'bio', strip_tags($_POST['bio']));
            }
            if (isset($_POST['relatedWork'])) {
                update_post_meta( $post_id, 'relatedWork', strip_tags($_POST['relatedWork']));
            }
        }


        function register_admin_styles(){
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_style('ly-event-type-css', plugin_dir_url( __FILE__ ) . 'css/ly_event_type.css');               
            }
        }


        function register_admin_scripts() {
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_media();
                wp_register_script('ly-event-type-js', plugins_url('js/ly_event_type.js' , __FILE__), array('jquery'));
                wp_enqueue_script('ly-event-type-js');
            }
        }

    }

    $lyEvent = new EventCustomType();


endif;