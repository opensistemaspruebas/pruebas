<?php

/*
    Plugin Name: OS Author Type
    Plugin URI: http://www.opensistemas.com/
    Description: Creates the content type 'Author'
    Version: 1.0
    Author: Roberto Moreno
    Author Email: rmoreno@opensistemas.com
    Plugin URI: http://www.opensistemas.com/
    Text Domain: os_author_type
    License: GPLv2 
*/

/*if (!class_exists('AuthorCustomType')) :
  
   class AuthorCustomType {   
        
        var $post_type = "author";
        
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
            load_plugin_textdomain('os_author_type', false, $plugin_dir . "/languages");
        }


        function create_post_type() {
            register_post_type($this->post_type, array(
                'labels' => array(
                    'name' => __('Author', 'os_author_type'),
                    'singular_name' => __('Author', 'os_author_type'),
                    'add_new' => __('Add new author', 'os_author_type'),
                    'add_new_item' => __('Add new author', 'os_author_type'),
                    'new_item' => __('New author', 'os_author_type'),
                    'edit_item' => __('Edit author', 'os_author_type'),
                    'view_item' => __('View author', 'os_author_type'),
                    'parent_item_colon' => __(' ', 'os_author_type'),
                    'search_items' => __('Search authors', 'os_author_type'),
                    'not_found' => __('No authors found', 'os_author_type'),
                    'not_found_in_trash' => __('No authors found in trash', 'os_author_type'),
                    'menu_name' => __('Authors', 'os_author_type')
                ),
                'capability_type' => 'post',
                'description' => __("This post type collects different authors", "os_author_type"),
                'public' => true,
                'show_ui' => true,
                'hierarchical' => false,
                'has_archive' => true,
                'rewrite' => array('slug' => 'Author'),
                'menu_icon' =>  'dashicons-exerpt-view',
                'supports' => array("title")
            ));
        }


        // Añade los meta-boxes al tipo de post tool
        function meta_boxes_add() {

            add_meta_box("data" ,__("Author data", "os_author_type"),array(&$this, "author_data_meta_box_callback"),$this->post_type);
            add_meta_box("image" ,__("Image author", "os_author_type"),array(&$this, "image_meta_box_callback"),$this->post_type);            
        }


        function author_data_meta_box_callback($post) {

            wp_nonce_field(basename(__FILE__), 'author-nonce');         
            
            $name = get_post_meta($post->ID, 'name');
            $birthdate = get_post_meta($post->ID, 'birthdate');
            $placeBirth = get_post_meta($post->ID, 'placeBirth');
            $bio = get_post_meta($post->ID, 'bio');
            $relatedWork = get_post_meta($post->ID, 'relatedWork');
            ?>          
            <p>
                <label for="name"><?php _e('Name', 'os_author_type')?></label>
                <input type="text" name="name" id="name" value="<?php if (isset($name) ) echo $name[0]; ?>" />
            </p>
            <p>
                <label for="birthdate"><?php _e('Birthdate', 'os_author_type')?></label>
                <input type="date" name="birthdate" id="birthdate" value="<?php if (isset($birthdate) ) echo $birthdate[0]; ?>" />
            </p>
            <p>
                <label for="placeBirth"><?php _e('Place birth', 'os_author_type')?></label>
                <input type="text" name="placeBirth" id="placeBirth" value="<?php if (isset($placeBirth) ) echo $placeBirth[0]; ?>" />
            </p>
            <label for="bio" class="bio"><?php _e('Bio', 'os_author_type' )?></label>
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
            <p>
                <label for="relatedWork"><?php _e('Related Work', 'os_author_type')?></label>
                <input type="text" name="relatedWork" id="relatedWork" value="<?php if (isset($relatedWork) ) echo $relatedWork[0]; ?>" />
            </p>
            <?php
        }


        
        function image_meta_box_callback($post) {           
            
            // Get WordPress' media upload URL
            $upload_link = esc_url(get_upload_iframe_src('image', $post->ID));

            // See if there's a media id already saved as post meta
            $your_img_id = get_post_meta($post->ID, 'image', true );

            // Get the image src
            $your_img_src = wp_get_attachment_image_src($your_img_id, 'full' );

            // For convenience, see if the array is valid
            $you_have_img = is_array($your_img_src );
            ?>

            <!-- Your image container, which can be manipulated with js -->
            <div class="custom-img-container">
                <?php if ($you_have_img ) : ?>
                    <img src="<?php echo $your_img_src[0] ?>" alt="" style="max-width:50%;" />
                <?php endif; ?>
            </div>

            <!-- Your add & remove image links -->
            <p class="hide-if-no-js">
                <a class="upload-custom-img <?php if ($you_have_img  ) { echo 'hidden'; } ?>" 
                   href="<?php echo $upload_link ?>">
                    <?php _e('Set custom image') ?>
                </a>
                <a class="delete-custom-img <?php if (! $you_have_img  ) { echo 'hidden'; } ?>" 
                  href="#">
                    <?php _e('Remove this image') ?>
                </a>
            </p>

            <!-- A hidden input to set and post the chosen image id -->
            <input class="image" name="image" type="hidden" value="<?php echo esc_attr($your_img_id ); ?>"
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
                update_post_meta($post_id, 'placeBirth', strip_tags($_POST['placeBirth']));
            }
            if (isset($_POST['bio'])) {
                update_post_meta($post_id, 'bio', strip_tags($_POST['bio']));
            }
            if (isset($_POST['relatedWork'])) {
                update_post_meta($post_id, 'relatedWork', strip_tags($_POST['relatedWork']));
            }
        }


        function register_admin_styles(){
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_style('os-author-type-css', plugin_dir_url(__FILE__ ) . 'css/os_author_type.css');               
            }
        }


        function register_admin_scripts() {
            global $typenow;
            if ($typenow == $this->post_type) {
                wp_enqueue_media();
                wp_register_script('os-author-type-js', plugins_url('js/os_author_type.js' , __FILE__), array('jquery'));
                wp_enqueue_script('os-author-type-js');
            }
        }

    }

    $osAuthor = new AuthorCustomType();


endif;*/


function custom_author_profile_fields($user) {
    if ($user->has_cap('author')) {
        ?>
        <table class="form-table">   
            <tr>
                <th>
                    <label for="author_location"><?php _e('Fecha de nacimiento'); ?></label>
                </th>
                <td>
                    <input type="date" name="author_birthdate" id="author_birthdate" value="<?php echo esc_attr(get_the_author_meta('author_birthdate', $user->ID)); ?>" class="regular-text" />
                    <span class="description"><?php _e('Fecha de nacimiento del autor.', 'os_author_type'); ?></span>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="author_placeofbirth"><?php _e('Lugar de nacimiento'); ?></label>
                </th>
                <td>
                    <input type="text" name="author_placeofbirth" id="author_placeofbirth" value="<?php echo esc_attr(get_the_author_meta('author_placeofbirth', $user->ID)); ?>" class="regular-text" />
                    <span class="description"><?php _e('Lugar de nacimiento del autor.', 'os_author_type'); ?></span>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="author_relatedworks"><?php _e('Trabajos relacionados'); ?></label>
                </th>
                <td>
                    <input type="text" name="author_relatedworks" id="author_relatedworks" value="<?php echo esc_attr(get_the_author_meta('author_relatedworks', $user->ID)); ?>" class="regular-text" />
                    <span class="description"><?php _e('Trabajos relacionados del autor.', 'os_author_type'); ?></span>
                </td>
            </tr>
        </table>
        <?php
    }
}
add_action('show_user_profile', 'custom_author_profile_fields');
add_action('edit_user_profile', 'custom_author_profile_fields');


/*add_action('personal_options_update', 'save_extra_social_links' );
add_action('edit_user_profile_update', 'save_extra_social_links' );

function save_extra_social_links($user_id )
{
    update_user_meta($user_id,'facebook_profile', sanitize_text_field($_POST['facebook_profile']));
    update_user_meta($user_id,'twitter_profile', sanitize_text_field($_POST['twitter_profile']));
    update_user_meta($user_id,'google_profile', sanitize_text_field($_POST['google_profile']));
}*/