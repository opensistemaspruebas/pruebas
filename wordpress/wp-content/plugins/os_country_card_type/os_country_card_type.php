<?php

/*
    Plugin Name: OS Country Card Type
    Plugin URI: http://www.opensistemas.com/
    Description: Crea el tipo de contenido 'Ficha de País'
    Version: 1.0
    Author: Marta Oliver
    Author Email: moliver@opensistemas.com
    Plugin URI: http://www.opensistemas.com/
    Text Domain: os_country_card_type
    License: GPLv2 
*/

if (!class_exists('CountryCardCustomType')) :
  
   class CountryCardCustomType {   
        
        var $post_type = "country-card";
        
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
            load_plugin_textdomain('os_country_card_type', false, $plugin_dir . "/languages");
        }


        function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Country Cards', 'os_country_card_type'),
                    'singular_name' => __('Country Card', 'os_country_card_type'),
                    'add_new' => __('Add new', 'os_country_card_type'),
                    'add_new_item' => __('Add new country card', 'os_country_card_type'),
                    'new_item' => __('New country card', 'os_country_card_type'),
                    'edit_item' => __('Edit country card', 'os_country_card_type'),
                    'view_item' => __('View country card', 'os_country_card_type'),
                    'parent_item_colon' => __(' ', 'os_country_card_type'),
                    'search_items' => __('Search country cards', 'os_country_card_type'),
                    'not_found' => __('No country cards found', 'os_country_card_type'),
                    'not_found_in_trash' => __('No country cards found in trash', 'os_country_card_type'),
                    'menu_name' => __('Country Cards', 'os_country_card_type')
                ),
                'capability_type' => 'post',
                'description' => __("This post type collects different country cards", "os_country_card_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'country-card'),
                'menu_icon' =>  'dashicons-exerpt-view',
                'supports' => array("title")
            ));
        }


        // Añade los meta-boxes al tipo de post country card
        function meta_boxes_add() {        	
        	add_meta_box("country-card-data" ,__("Country data", "os_country_card_type"),array(&$this, "country_data_meta_box_callback"),$this->post_type,"normal","high");
        	add_meta_box("social-media" ,__("Social Media", "os_country_card_type"),array(&$this, "social_media_meta_box_callback"),$this->post_type, "normal", "low");
        }


        function country_data_meta_box_callback($post) {
        	wp_nonce_field( basename( __FILE__ ), 'country_data-nonce');
        	$country_name = get_post_meta($post->ID, 'country-name');           
        	$country_information = get_post_meta($post->ID, 'country-information');
        	?>
            <p>
                <label for="country-name" class="country-name"><?php _e('Country name', 'os_country_card_type')?></label>
                <input type="text" name="country-name" id="country-name" value="<?php if ( isset($country_name) ) echo $country_name[0]; ?>" />
            </p>

            <label for="country-information" class="country-information"><?php _e('Country information', 'os_country_card_type' )?></label>
            <?php 
            $settings = array(
                'media_buttons' => false,
                'wpautop' => false,
                'textarea_rows' => 4,
                'tinymce' => false,
                'quicktags' => array()
            ); 
            wp_editor($country_information[0], 'country-information', $settings); 

            $offices = get_post_meta($post->ID, 'offices', true);

            $c = 0;

            if (!empty($offices)) :
            foreach ($offices as $office) :                
            ?>
            <div class="office-information">
                <h2><?php _e('Office information', 'os_country_card_type')?></h2>
                <?php if ($c > 0) : ?>
                <button id="delete-office-information" type="button">-</button>
                <?php endif; ?>
                <p>
                    <label for="offices[<?php echo $c; ?>][title]">
                        <?php _e('Office title', 'os_country_card_type')?>
                    </label>
                    <input type="text" name="offices[<?php echo $c; ?>][title]" value="<?php echo $office['title']; ?>" />

                    <label for="offices[<?php echo $c; ?>][address]">
                        <?php _e('Office address', 'os_country_card_type')?>
                    </label>
                    <input type="text" name="offices[<?php echo $c; ?>][address]" value="<?php echo $office['address']; ?>" />
                    
                    <label for="offices[<?php echo $c; ?>][phone]">
                        <?php _e('Office phone', 'os_country_card_type')?>
                    </label>
                    <input type="tel" name="offices[<?php echo $c; ?>][phone]" value="<?php echo $office['phone']; ?>" />
                    
                    <label for="offices[<?php echo $c; ?>][mail]">
                        <?php _e('Office mail', 'os_country_card_type')?>
                    </label>
                    <input type="email" name="offices[<?php echo $c; ?>][mail]" value="<?php echo $office['mail']; ?>" />
                    
                    <label for="offices[<?php echo $c; ?>][web]">
                        <?php _e('Office web', 'os_country_card_type')?>
                    </label>
                    <input type="url" name="offices[<?php echo $c; ?>][web]" value="<?php echo $office['web']; ?>" />


                    <label for="offices[<?php echo $c; ?>][textExtra]">
                        <?php _e('Extra text', 'os_country_card_type')?>
                    </label>                    
                    <input type="text" name="offices[<?php echo $c; ?>][textExtra]" value="<?php echo $office['textExtra']; ?>" />


                </p>
            </div>
            <?php
            $c++;
            endforeach;
            else :
                ?>
                <div class="office-information">
                    <h2><?php _e('Office information', 'os_country_card_type')?></h2>
                    <p>
                        <label for="offices[0][title]">
                            <?php _e('Office title', 'os_country_card_type')?>
                        </label>
                        <input type="text" name="offices[0][title]" value="" />                        
                        
                        <label for="offices[0][address]">
                            <?php _e('Office address', 'os_country_card_type')?>
                        </label>
                        <input type="text" name="offices[0][address]" value="" />                        
                        
                        <label for="offices[0][phone]">
                            <?php _e('Office phone', 'os_country_card_type')?>
                        </label>
                        <input type="tel" name="offices[0][phone]" value="" />                        
                        
                        <label for="offices[0][mail]">
                            <?php _e('Office mail', 'os_country_card_type')?>
                        </label>
                        <input type="email" name="offices[0][mail]" value="" />
                        
                        <label for="offices[0][web]">
                            <?php _e('Office web', 'os_country_card_type')?>
                        </label>
                        <input type="url" name="offices[0][web]" value="" />
                        
                        <label for ="offices[0][textExtra]">
                            <?php _e('Extra text', 'os_country_card_type')?>
                        </label>
                        <input type="text" name="offices[0][textExtra]">

                    </p>
                </div>
                <?php
            endif;

            ?>
            <p>
                <button id="add-office-information" type="button"><?php _e('Add office', 'os_country_card_type')?></button>
            </p>
            <?php

        }


        function social_media_meta_box_callback($post) {
        	wp_nonce_field( basename( __FILE__ ), 'social_media-nonce');
            $link_facebook = get_post_meta($post->ID, 'country-card-facebook-link');
            $link_twitter = get_post_meta($post->ID, 'country-card-twitter-link');
            $link_linkedin = get_post_meta($post->ID, 'country-card-linkedin-link');
            $link_google_plus = get_post_meta($post->ID, 'country-card-google-plus-link');
            $link_youtube = get_post_meta($post->ID, 'country-card-youtube-link');
	        ?>
	        <p>
                <label class="country-card-facebook-link" for="ccountry-card-facebook-link"><?php _e('Link to Facebook', 'os_country_card_type'); ?></label>
                <input class="widefat" id="country-card-facebook-link" name="country-card-facebook-link" type="url" value="<?php if ( isset($link_facebook) ) echo $link_facebook[0]; ?>" />
            </p>
            <p>
                <label class="country-card-twitter-link" for="country-card-twitter-link"><?php _e('Link to Twitter', 'os_country_card_type'); ?></label>
                <input class="widefat" id="country-card-twitter-link" name="country-card-twitter-link" type="url" value="<?php if ( isset($link_twitter) ) echo $link_twitter[0]; ?>" />
            </p>
            <p>
                <label class="country-card-linkedin-link" for="country-card-linkedin-link"><?php _e('Link to LinkedIn', 'os_country_card_type'); ?></label>
                <input class="widefat" id="country-card-linkedin-link" name="country-card-linkedin-link" type="url" value="<?php if ( isset($link_linkedin) ) echo $link_linkedin[0]; ?>" />
            </p>
            <p>
                <label class="country-card-google-plus-link" for="country-card-google-plus-link"><?php _e('Link to Google+', 'os_country_card_type'); ?></label>
                <input class="widefat" id="country-card-google-plus-link" name="country-card-google-plus-link" type="url" value="<?php if ( isset($link_google_plus) ) echo $link_google_plus[0]; ?>" />
            </p>
            <p>
                <label class="country-card-youtube-link" for="country-card-youtube-link"><?php _e('Link to YouTube', 'os_country_card_type'); ?></label>
                <input class="widefat" id="country-card-youtube-link" name="country-card-youtube-link" type="url" value="<?php if ( isset($link_youtube) ) echo $link_youtube[0]; ?>" />
            </p>
			<?php
        }


        function meta_boxes_save($post_id) {
            if (isset($_POST['country-name'])) {
                update_post_meta($post_id, 'country-name', strip_tags($_POST['country-name']));
            }
           
            if (isset($_POST['country-information'])) {
                update_post_meta($post_id, 'country-information', strip_tags($_POST['country-information']));
            }
            if (isset($_POST['offices'])) {
                $offices = $_POST['offices'];
                $new_offices = array();
                foreach ($offices as $office) {
                    if (!(empty($office['title']) && empty($office['address']) && empty($office['phone']) && empty($office['mail']) && empty($office['web']) && empty($office["textExtra"]))) {
                        array_push($new_offices, $office);
                    }
                }
                update_post_meta($post_id, 'offices', $new_offices);
            }
            if (isset($_POST['country-card-facebook-link'])) {
                update_post_meta($post_id, 'country-card-facebook-link', strip_tags($_POST['country-card-facebook-link']));
            }
            if (isset($_POST['country-card-twitter-link'])) {
                update_post_meta($post_id, 'country-card-twitter-link', strip_tags($_POST['country-card-twitter-link']));
            }
            if (isset($_POST['country-card-linkedin-link'])) {
                update_post_meta($post_id, 'country-card-linkedin-link', strip_tags($_POST['country-card-linkedin-link']));
            }
            if (isset($_POST['country-card-google-plus-link'])) {
                update_post_meta($post_id, 'country-card-google-plus-link', strip_tags($_POST['country-card-google-plus-link']));
            }
            if (isset($_POST['country-card-youtube-link'])) {
                update_post_meta($post_id, 'country-card-youtube-link', strip_tags($_POST['country-card-youtube-link']));
            }
        }


        function register_admin_styles(){
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_style('country card-type-css', plugin_dir_url( __FILE__ ) . 'css/os_country_card_type.css');               
            }
        }


        function register_admin_scripts() {
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_media();
                wp_register_script('os_country_card_type-js', plugins_url('js/os_country_card_type.js' , __FILE__), array('jquery'));           
                wp_enqueue_script('os_country_card_type-js');
            }
        }

    }

    $osProm = new CountryCardCustomType();

endif;