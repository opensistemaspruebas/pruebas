<?php


/*

  Plugin Name: OS Header
  Plugin URI: http://www.opensistemas.com/
  Description: Crea un widget que muestra una cabecera con una imagen de fondo y un cuadro de texto.
  Author: Marta Oliver
  Author URI: http://www.opensistemas.com/
  Version: 0.1

*/


// Register OS_Header_Widget widget
function register_os_header_widget() {
  register_widget('OS_Header_Widget');
}
add_action('widgets_init', 'register_os_header_widget');


class OS_Header_Widget extends WP_Widget {

  var $image_field = 'image';  // the image field ID

  // Register widget with WordPress.
  public function __construct() {
    parent::__construct(
      'os_header_widget',
      __( 'OS Header Widget', 'os_header_widget'),
      array(
        'classname' => 'os_header_widget',
        'description' => __('Muestra una cabecera con una imagen de fondo y un cuadro de texto.', 'os_header_widget')
     )
   );
    load_plugin_textdomain('os_header_widget', false, basename( dirname( __FILE__)) . '/languages');
  }


  // Front-end display of widget.
  function widget($args, $instance) {
    
    extract($args);
    
    $instance = wp_parse_args((array) $instance, $this->defaults);
    
    echo $before_widget;
    
    $image = new WidgetImageField($this, $image_id);
    if(!empty($image_id)) {
    ?>
      <img src="<?php echo $image->get_image_src('thumbnail'); ?>" width="<?php echo $image->get_image_width('thumbnail'); ?>" height="<?php echo $image->get_image_height('thumbnail'); ?>" />
    <?php
    }

    ?>
    <p>Soy el header</p>
    <?php

    echo $after_widget;
  }


  // Back-end display of widget.
  function form($instance) {
    
    $instance = wp_parse_args((array) $instance, $this->defaults);

    $image_id = esc_attr(isset($instance[$this->image_field]) ? $instance[$this->image_field] : 0);
    $image = new WidgetImageField($this, $image_id);

    ?>
    <?php echo $image->get_widget_field(); ?>
    <p>
      <label for="<?php echo $this->get_field_id('box_title'); ?>"><?php _e('Título', 'os_header_widget'); ?>:</label>
      <input type="text" id="<?php echo $this->get_field_id('box_title'); ?>" name="<?php echo $this->get_field_name('box_title'); ?>" value="<?php echo esc_attr($instance['box_title']); ?>" class="widefat" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('box_text'); ?>"><?php _e('Texto', 'os_header_widget'); ?>:</label>
      <textarea class="widefat" rows="8" cols="16" id="<?php echo $this->get_field_id('box_text'); ?>" name="<?php echo $this->get_field_name('box_text'); ?>"><?php echo esc_attr($instance['box_text']); ?></textarea>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('link_title'); ?>"><?php _e('Título del enlace', 'os_header_widget'); ?>:</label>
      <input type="text" id="<?php echo $this->get_field_id('link_title'); ?>" name="<?php echo $this->get_field_name('link_title'); ?>" value="<?php echo esc_attr($instance['link_title']); ?>" class="widefat" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('link_url'); ?>"><?php _e('Url del enlace', 'os_header_widget'); ?>:</label>
      <input type="url" id="<?php echo $this->get_field_id('link_url'); ?>" name="<?php echo $this->get_field_name('link_url'); ?>" value="<?php echo esc_attr($instance['link_url']); ?>" class="widefat" />
    </p>
    <p>
      <input type="checkbox" id="<?php echo $this->get_field_id('link_target'); ?>" name="<?php echo $this->get_field_name('link_target'); ?>" <?php checked($instance['link_target'], 'on'); ?> class="widefat" />
      <label for="<?php echo $this->get_field_id('link_target'); ?>"><?php _e('Abrir en una nueva ventana', 'os_header_widget'); ?></label>
    </p>
    <?php
  
  }


  // Sanitize widget form values as they are saved.
  function update($new_instance, $old_instance) {

    $new_instance[$this->image_field] = intval(strip_tags($new_instance[$this->image_field]));
    $new_instance['box_title'] = strip_tags($new_instance['box_title']);
    $new_instance['box_text'] = strip_tags($new_instance['box_text']);
    $new_instance['link_title'] = strip_tags($new_instance['link_title']);
    $new_instance['link_url'] = strip_tags($new_instance['link_url']);
    $new_instance['link_target'] = strip_tags($new_instance['link_target']);

    return $new_instance;

  }

}