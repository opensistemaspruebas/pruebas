<?php

/*
	Plugin Name: OS Report Type
	Plugin URI: https://www.opensistemas.com/
	Description: Crea el tipo de contenido 'publicación'.
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_report_type
*/


function load_text_domain_report() {
  load_plugin_textdomain('os_report_type', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'load_text_domain_report', 10);


function report_post_type() {
  $labels = array(
    'name'                => _x('Reports', 'post type general name', 'os_report_type'),
    'singular_name'       => _x('Report', 'post type singular name', 'os_report_type'),
    'menu_name'           => __('Reports', 'os_report_type'),
    'parent_item_colon'   => __('Parent Reports:', 'os_report_type'),
    'all_items'           => __('All Reports', 'os_report_type'),
    'view_item'           => __('View Report', 'os_report_type'),
    'add_new_item'        => __('Add New Report', 'os_report_type'),
    'add_new'             => __('Add New', 'os_report_type'),
    'edit_item'           => __('Edit Report', 'os_report_type'),
    'update_item'         => __('Update Report', 'os_report_type'),
    'search_items'        => __('Search Reports', 'os_report_type'),
    'not_found'           => __('Not reports found.', 'os_report_type'),
    'not_found_in_trash'  => __('Not reports found in Trash.', 'os_report_type'),
  );
  $args = array(
      'labels'             => $labels,
      'description'        => __( 'Description.', 'os_report_type'),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array('slug' => 'report'),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => null,
      'menu_icon'          => 'dashicons-welcome-write-blog',
      'supports'           => array('title', 'author', 'thumbnail', 'excerpt'),
      'taxonomies'         => array('category', 'post_tag', 'country')
  );
  register_post_type('report', $args );
}
add_action('init', 'report_post_type', 0);


function register_admin_scripts() {
    global $typenow, $post;
    
    if ($typenow == $post->post_type) {
      wp_enqueue_media();
      wp_register_script('os_report_type-js', plugins_url('js/os_report_type_min.js' , __FILE__), array('jquery'));           
      $translation_array = array(
        'choose_logo' => __('Choose logo', 'os_report_type')
      );
      wp_localize_script( 'os_report_type-js', 'object_name', $translation_array );
      wp_enqueue_script('os_report_type-js');
    }
}
add_action('admin_enqueue_scripts', 'register_admin_scripts');


function report_meta_boxes() {
  add_meta_box('report_pdf', __('PDF report', 'os_report_type'), 'meta_box_report_pdf', 'report', 'normal', 'low');
  add_meta_box('report_source', __('Source', 'os_report_type'), 'meta_box_report_source', 'report', 'normal', 'low');
}
add_action('add_meta_boxes', 'report_meta_boxes');


function meta_box_report_pdf() {
  
  global $post;
  
  wp_nonce_field(basename(__FILE__), 'meta_box_report_pdf-nonce');
  
  $pdf = get_post_meta($post->ID, 'pdf', true);
  
  ?>
  <p>
    <label for="pdf"><?php _e('Document', 'os_report_type'); ?></label>
    <input class="widefat" id="pdf" name="pdf" type="text" value="<?php if (isset($pdf)) echo $pdf; ?>" readonly="readonly"/>
  </p>
  <p>
    <input id="upload_pdf" name="upload_pdf" type="button" value="<?php _e('Explore/Upload', 'os_report_type'); ?>" />
  </p>
  <?php
}


function meta_box_report_source() {
  
  global $post;
  
  wp_nonce_field(basename(__FILE__), 'meta_box_report_source-nonce');
  
  $source_name = get_post_meta($post->ID, 'source_name', true);
  $source_url = get_post_meta($post->ID, 'source_url', true);
  $logo = get_post_meta($post->ID, 'source_logo', true);
  $publication_date = get_post_meta($post->ID, 'publication_date', true);
  $type = get_post_meta($post->ID, 'type', true);
  $geographical_area = get_post_meta($post->ID, 'geographical_area', true);
  $target_audiences = get_post_meta($post->ID, 'target_audiences', true);
  $number_of_pages = get_post_meta($post->ID, 'number_of_pages', true);
  $jel_code = get_post_meta($post->ID, 'jel_code', true);
  $edition = get_post_meta($post->ID, 'edition', true);
  $editorial = get_post_meta($post->ID, 'editorial', true);
  ?>
  
  <p>
    <label for="source_name"><?php _e('Name', 'os_report_type'); ?></label>
    <input type="text" name="source_name" value="<?php echo $source_name; ?>" class="widefat" />
  </p>
  <p>
    <label for="source_url"><?php _e('URL', 'os_report_type'); ?></label>
    <input type="link" name="source_url" value="<?php echo $source_url; ?>" class="widefat" />
  </p>
  <p>
    <label for="source_logo"><?php _e('Logo', 'os_report_type'); ?></label>
    <input class="widefat" id="source_logo" name="source_logo" type="text" value="<?php if (!empty($logo)) echo $logo; ?>" readonly="readonly"/>
    <img id="show_logo" draggable="false" alt="" name="show_logo" width="100%" src="<?php if (!empty($logo)) echo esc_attr($logo); ?>" style="<?php if (empty($logo)) echo "display: none;"; ?>">
    <input id="upload_logo" name="upload_logo" type="button" value="<?php _e('Explore/Upload', 'os_report_type'); ?>" />
  </p>
  <p>
    <label for="publication_date"><?php _e('Publication date', 'os_report_type'); ?></label>
    <input type="date" name="publication_date" value="<?php echo $publication_date; ?>" class="widefat" />
  </p>
  <p>
    <label for="type"><?php _e('Type', 'os_report_type'); ?></label>
    <input type="text" name="type" value="<?php echo $type; ?>" class="widefat" />
  </p>
  <p>
    <label for="geographical_area"><?php _e('Geographical area', 'os_report_type'); ?></label>
    <select name="geographical_area" class="widefat">
      <?php  
        $countries = get_terms('country', array('hide_empty' => false));
        foreach ($countries as $country) {
          $selected = ($country->term_id == $geographical_area) ? 'selected="selected"' : '';
          ?><option <?php echo $selected; ?> value="<?php echo $country->term_id; ?>"><?php echo $country->name; ?></option><?php
        }
      ?>
    </select>
  </p>
  <p>
    <label for="target_audiences"><?php _e('Target audiences', 'os_report_type'); ?></label>
    <input type="text" name="target_audiences" value="<?php echo $target_audiences; ?>" class="widefat" />
  </p>
  <p>
    <label for="number_of_pages"><?php _e('Number of pages', 'os_report_type'); ?></label>
    <input type="number" name="number_of_pages" value="<?php echo $number_of_pages; ?>" class="widefat" />
  </p>
  <p>
    <label for="jel_code"><?php _e('JEL code', 'os_report_type'); ?></label>
    <input type="text" name="jel_code" value="<?php echo $jel_code; ?>" class="widefat" />
  </p>
  <p>
    <label for="edition"><?php _e('Edition', 'os_report_type'); ?></label>
    <input type="text" name="edition" value="<?php echo $edition; ?>" class="widefat" />
  </p>
  <p>
    <label for="editorial"><?php _e('Editorial', 'os_report_type'); ?></label>
    <input type="text" name="editorial" value="<?php echo $editorial; ?>" class="widefat" />
  </p>
  <?php
}


function meta_boxes_save($post_id) {
  if (isset($_POST['source_name'])) {
    update_post_meta($post_id, 'source_name', strip_tags($_POST['source_name']));
  }
  if (isset($_POST['source_url'])) {
   update_post_meta($post_id, 'source_url', strip_tags($_POST['source_url']));
  }
  if (isset($_POST['source_logo'])) {
   update_post_meta($post_id, 'source_logo', strip_tags($_POST['source_logo']));
  }
  if (isset($_POST['publication_date'])) {
    update_post_meta($post_id, 'publication_date', strip_tags($_POST['publication_date']));
  }
  if (isset($_POST['type'])) {
    update_post_meta($post_id, 'type', strip_tags($_POST['type']));
  }
  if (isset($_POST['geographical_area'])) {
   update_post_meta($post_id, 'geographical_area', strip_tags($_POST['geographical_area']));
  }
  if (isset($_POST['target_audiences'])) {
    update_post_meta($post_id, 'target_audiences', strip_tags($_POST['target_audiences']));
  }
  if (isset($_POST['number_of_pages'])) {
   update_post_meta($post_id, 'number_of_pages', strip_tags($_POST['number_of_pages']));
  }
  if (isset($_POST['jel_code'])) {
    update_post_meta($post_id, 'jel_code', strip_tags($_POST['jel_code']));
  }
  if (isset($_POST['edition'])) {
   update_post_meta($post_id, 'edition', strip_tags($_POST['edition']));
  }
  if (isset($_POST['editorial'])) {
    update_post_meta($post_id, 'editorial', strip_tags($_POST['editorial']));
  }
  if (isset($_POST['pdf'])) {
    update_post_meta($post_id, 'pdf', strip_tags($_POST['pdf']));
  }
}
add_action('save_post', "meta_boxes_save");