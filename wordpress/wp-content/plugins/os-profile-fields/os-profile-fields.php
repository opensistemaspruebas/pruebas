<?php
/*
  Plugin Name: OS Profile Fields
  Description: Filtros y acciones para personalizar los campos de perfil de usuario
  Version: 1.0
  Author: Carlos Mendoza
  Author URI: http://www.opensistemas.com/
 */

if (!class_exists('OSProfileFields')) :

    class OSProfileFields {
        private $name = "OS Profile Fields";

        static $uniqueObject = null;

        static function & getInstance() {

            if (null == OSProfileFields::$uniqueObject) {
                OSProfileFields::$uniqueObject = new OSProfileFields();
            }

            return OSProfileFields::$uniqueObject;
        }

        function __construct() {
            add_filter('user_contactmethods', array(&$this, 'contactMethods'));
            add_filter( 'coauthors_guest_authors_enabled', '__return_false' );
            add_action('show_user_profile', array(&$this, 'editProfile'), 9);
            add_action('edit_user_profile', array(&$this, 'editProfile'), 9);
            add_action('edit_user_profile', array(&$this, 'show_translation_options'), 9);
            add_action('personal_options_update', array(&$this, 'guardarDatos'), 9);
            add_action('edit_user_profile_update', array(&$this, 'guardarDatos'), 9);
            add_action('init', array(&$this, 'crear_cargo'));
            add_action('plugins_loaded', array(&$this, 'load_text_domain'));
            add_action('admin_menu', array(&$this, 'remover_menus'), 11);
            //comprueba que el email introducido al añadir un nuevo usuario no corresponde a ningún usuario con el mismo rol
            add_action( 'admin_footer', array(&$this, 'comprueba_usuario_unico'),11 );
            add_action( 'wp_ajax_usuario_unico', array(&$this, 'usuario_unico_callback'),11 );
            //No mostrar campo contraseña
            //add_filter( 'show_password_fields', function(){return false;});
            
            // Add a visual editor if the current user is an Author role or above and WordPress is v3.3+
            if (function_exists('wp_editor')) {
                // Don't sanitize the data for display in a textarea
                add_action('admin_init', array($this, 'save_filters'));

                // Load required JS
                add_action('admin_enqueue_scripts', array($this, 'load_javascript'), 10, 1);

                // Add content filters to the output of the description
                add_filter('get_the_author_description', 'wptexturize');
                add_filter('get_the_author_description', 'convert_chars');
                add_filter('get_the_author_description', 'wpautop');
            }
            // Display a message if the requires aren't met
            else {
                add_action('admin_notices', array($this, 'update_notice'));
            }
        }

        function contactMethods($method) {
            $profile_fields['twitter'] = 'Twitter';
            $profile_fields['linkedin'] = 'LinkedIn';
            return $profile_fields;
        }

        function editProfile($profileuser) {
            if (!current_user_can('edit_posts')){
                return;
            }
            /* @var $sitepress SitePress */
            global $sitepress;
            $cur_lang = $sitepress->get_current_language();

            $bbva_user = get_user_meta($profileuser->ID, 'bbva_user', true);
            $geolocation = get_user_meta($profileuser->ID, 'geolocation', true);
            $cargo = get_user_meta($profileuser->ID, 'cargo', true);
            $is_link_unit = get_user_meta($profileuser->ID, 'is_link_unit', true);
            $link_unit = get_user_meta($profileuser->ID, 'user_link_unit', true);
            $description = get_user_meta($profileuser->ID, 'description', true);
            $descriptionEng = get_user_meta($profileuser->ID, 'description_eng', true);
            $disable_author=get_user_meta($profileuser->data->ID, 'is_author_disabled', true);
            ?>
            <table class="form-table">
                <tbody>
                    <tr class="form-field form-required">
                        <th>
                            <label for="bbva_user"><?php _e("BBVA User", "cargo"); ?></label>
                        </th>
                        <td>
                            <input type="text" name="bbva_user" id="bbva_user" value="<?php echo $bbva_user; ?>"/>
                            <input type="hidden" name="admin_bar_front" id="admin_bar_front" value="1"/>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="disable_author"><?php _e("Author disabled", "cargo"); ?></label>
                        </th>
                        <td>
                            <p>
                            <label><input name="is_author_disabled" type="checkbox" value="1" <?php
                            if($disable_author):?>checked="checked"<?php endif?> />&nbsp;<?php
                            _e('Hide links to this Author', "cargo"); ?></label>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="geolocation"><?php _e("Geo Location", "cargo"); ?></label>
                        </th>
                        <td>
                            <?php
                            wp_dropdown_categories(array(
                                //'show_option_none' => " ",
                                'child_of' => icl_object_id(REGION_CATEGORY_ID, 'category', false, $cur_lang),
                                'taxonomy' => 'category',
                                'name' => 'geolocation',
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'selected' => icl_object_id($geolocation, 'category', false, $cur_lang),
                                'hierarchical' => false,
                                'show_count' => false, // Show # listings in parens
                                'hide_empty' => false, // Don't show businesses w/o listings
                            ));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="cargo"><?php _e("Position", "cargo"); ?></label>
                        </th>
                        <td>
                            <?php
                            wp_dropdown_categories(array(
                                'taxonomy' => 'cargo',
                                'name' => 'cargo',
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'selected' => icl_object_id($cargo, 'cargo', false, $cur_lang),
                                'hierarchical' => false,
                                'show_count' => false, // Show # listings in parens
                                'hide_empty' => false, // Don't show businesses w/o listings
                            ));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="link_unit"><?php _e("Link user to unit", "cargo"); ?></label>
                        </th>
                        <td>
                            <input name="is_link_unit" type="checkbox" value="1" <?php
                            if($is_link_unit):?>checked="checked"<?php endif?> />&nbsp;
                            <?php
                            wp_dropdown_categories(array(
                                'taxonomy' => 'unidad',
                                'name' => 'user_link_unit',
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'selected' => icl_object_id($link_unit, 'unidad', false, $cur_lang),
                                'hierarchical' => true,
                                'show_count' => false, // Show # listings in parens
                                'hide_empty' => false, // Don't show businesses w/o listings
                            ));

                            ?>
                            <label><?php _e('User replaces the unit in editing publications', "cargo"); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="description"><?php _e('Biographical Info'); ?></label></th>
                        <td>
                            <div  id="accordion">
                                <h3>Español</h3>
                                <div>
                                    <?php
                                    wp_editor($description, 'description');
                                    ?>
                                    <p class="description"><?php _e('Share a little biographical information to fill out your profile. This may be shown publicly.'); ?></p>
                                </div>
                                <h3>English</h3>
                                <div>
                                    <?php
                                    wp_editor($descriptionEng, 'description_eng');
                                    ?>
                                    <p class="description"><?php _e('Share a little biographical information to fill out your profile. This may be shown publicly.'); ?></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <script type="text/javascript">
                jQuery('document').ready(function(){
                    jQuery("#nickname").parent().parent().hide();
                    jQuery("#url").parent().parent().hide();
                    jQuery("#accordion").accordion({collapsible: true, heightStyle: "content"}); 
                    jQuery("#rolemanager_singleuser_fs").hide();
                    jQuery("#simple-local-avatar-ratings").parent().parent().hide();
                    jQuery("#pass1").parent().parent().parent().parent().hide();
                });
            </script>
            <?php
        }
        
        function show_translation_options($profileuser){
            global $current_user;
            if($current_user->data->ID == $profileuser->ID){
                return;
            }
            /* @var $sitepress SitePress */
            global $sitepress;
            $active_languages = $sitepress->get_active_languages();
            $default_language = $sitepress->get_default_language();
            $user_language = get_user_meta($profileuser->ID,'icl_admin_language',true);
            $settings = $sitepress->get_settings();
            if($settings['admin_default_language'] == '_default_'){
                $settings['admin_default_language'] = $default_language;
            }
            $lang_details = $sitepress->get_language_details($settings['admin_default_language']);
            $admin_default_language = $lang_details['display_name'];
            ?>
            <a name="wpml"></a>
            <h3><?php _e('WPML language settings','sitepress'); ?></h3>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th><?php _e('Select your language:', 'sitepress') ?></th>
                        <td>
                            <select name="icl_user_admin_language">
                            <option value=""<?php if($user_language==$settings['admin_default_language']) echo ' selected="selected"'?>><?php printf(__('Default admin language (currently %s)','sitepress'), $admin_default_language );?>&nbsp;</option>
                            <?php foreach($active_languages as $al):?>
                            <option value="<?php echo $al['code'] ?>"<?php if($user_language==$al['code']) echo ' selected="selected"'?>><?php echo $al['display_name']; if($sitepress->get_admin_language() != $al['code']) echo ' ('. $al['native_name'] .')'; ?>&nbsp;</option>
                            <?php endforeach; ?>
                            </select>
                            <span class="description"><?php _e('this will be your admin language and will also be used for translating comments.', 'sitepress'); ?></span>
                            <br />
                            <label><input type="checkbox" name="icl_admin_language_for_edit" value="1" <?php if(get_user_meta($profileuser->ID, 'icl_admin_language_for_edit', true)):?>checked="checked"<?php endif;?> />&nbsp;<?php _e('Set admin language as editing language.', 'sitepress'); ?></label>
                        </td>
                    </tr>
                    <?php //display "hidden languages block" only if user can "manage_options" 
                    if(current_user_can('manage_options')): ?>
                    <tr>
                        <th><?php _e('Hidden languages:', 'sitepress') ?></th>
                        <td>
                            <p>
                            <?php if(!empty($ettings['hidden_languages'])): ?>
                                <?php
                                 if(1 == count($settings['hidden_languages'])){
                                     printf(__('%s is currently hidden to visitors.', 'sitepress'),
                                        $active_languages[$settings['hidden_languages'][0]]['display_name']);
                                 }else{
                                     foreach($settings['hidden_languages'] as $l){
                                         $_hlngs[] = $active_languages[$l]['display_name'];
                                     }
                                     $hlangs = join(', ', $_hlngs);
                                     printf(__('%s are currently hidden to visitors.', 'sitepress'), $hlangs);
                                 }
                                ?>
                            <?php else: ?>
                            <?php _e('All languages are currently displayed. Choose what to do when site languages are hidden.', 'sitepress'); ?>
                            <?php endif; ?>
                            </p>
                            <p>
                            <label><input name="icl_show_hidden_languages" type="checkbox" value="1" <?php
                                if(get_user_meta($current_user->data->ID, 'icl_show_hidden_languages', true)):?>checked="checked"<?php endif?> />&nbsp;<?php
                                _e('Display hidden languages', 'sitepress'); ?></label>
                            </p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php
        }

        function guardarDatos($user_id) {
            if (isset($_POST['bbva_user']))
                update_user_meta($user_id, 'bbva_user', $_POST['bbva_user']);
            if (isset($_POST['geolocation']))
                update_user_meta($user_id, 'geolocation', $_POST['geolocation']);
            if (isset($_POST['cargo']))
                update_user_meta($user_id, 'cargo', $_POST['cargo']);

            update_user_meta($user_id,'is_link_unit',isset($_POST['is_link_unit']) ? intval($_POST['is_link_unit']) : 0);
            
            if (isset($_POST['user_link_unit'])){
                update_user_meta($user_id, 'user_link_unit', $_POST['user_link_unit']);
            }
            
            if (isset($_POST['description_eng']))
                update_user_meta($user_id, 'description_eng', $_POST['description_eng']);

            update_user_meta($user_id,'is_author_disabled',isset($_POST['is_author_disabled']) ? intval($_POST['is_author_disabled']) : 0);
            /**** idioma ****/
            global $current_user;
            if($user_id == $current_user->data->ID){
                return;
            }
            update_user_meta($user_id,'icl_admin_language',$_POST['icl_user_admin_language']);
            update_user_meta($user_id,'icl_show_hidden_languages',isset($_POST['icl_show_hidden_languages']) ? intval($_POST['icl_show_hidden_languages']) : 0);
            update_user_meta($user_id,'icl_admin_language_for_edit',isset($_POST['icl_admin_language_for_edit']) ?  intval($_POST['icl_admin_language_for_edit']) : 0);            
        }

        function crear_cargo() {
            register_taxonomy('cargo', 'publicacion', array(
                // Hierarchical taxonomy (like categories)
                'hierarchical' => false,
                'query_var' => true,
                // This array of options controls the labels displayed in the WordPress Admin UI
                'labels' => array(
                    'name' => __('Positions', 'cargo'),
                    'singular_name' => __('Position', 'cargo'),
                    'search_items' => __('Search Position', 'cargo'),
                    'all_items' => __('All Positions', 'cargo'),
                    'edit_item' => __('Edit Position', 'cargo'),
                    'update_item' => __('Update Position', 'cargo'),
                    'add_new_item' => __('Add New Position', 'cargo'),
                    'new_item_name' => __('New Position Name', 'cargo'),
                    'menu_name' => __('Job Positions', 'cargo'),
                ),
                // Control the slugs used for this taxonomy
                'rewrite' => array(
                    'slug' => 'cargo', // This controls the base slug that will display before each term
                    'with_front' => false, // Don't display the category base before "/locations/"
                    'hierarchical' => false // This will allow URL's like "/locations/boston/cambridge/"
                ),
            ));
        }
        
        static function getCargo($user_id){
            if (function_exists('get_cimyFields')) {
                get_cimyFieldValue($user_id, 'PROFESSION');
            } else {
                $cargo_id = get_user_meta($user_id, 'cargo', true);
                return get_term_by("id", icl_object_id($cargo_id, 'cargo', true), 'cargo')->name;
            }
        }

        public function load_javascript($hook) {

            // Contributor level user or higher required
            if (!current_user_can('edit_posts'))
                return;

            // Load JavaScript only on the profile and user edit pages 
            if ($hook == 'profile.php' || $hook == 'user-edit.php') {
                wp_enqueue_script('jquery-ui-accordion');
                wp_enqueue_style('jquery-ui-accordion-css', plugins_url('css/jquery-ui-accordion.css', __FILE__));
                wp_enqueue_script(
                        'visual-editor-biography', plugins_url('js/visual-editor-biography.js', __FILE__), array('jquery'), false, true
                );
            }
        }

        public function save_filters() {

            // Contributor level user or higher required
            if (!current_user_can('edit_posts'))
                return;

            remove_all_filters('pre_user_description');
        }

        public function update_notice() {

            // Notification is for administrators only
            if (!current_user_can('administrator'))
                return;
            ?>
            <div class="updated">
                <p>The <strong><?php echo $this->name; ?></strong> plugin requires WordPress 3.3 or higher. Update WordPress or <a href="<?php echo get_admin_url(null, 'plugins.php'); ?>">de-activate the plugin</a>.</p>
            </div>
            <?php
        }

        function load_text_domain() {
            $plugin_dir = basename(dirname(__FILE__));
            load_plugin_textdomain('cargo', false, $plugin_dir . "/languages");
        }
        
        function remover_menus(){
            /* @var $iwg_rolemanagement IWG_RoleManagement */
            global $iwg_rolemanagement;
            remove_submenu_page('users.php', $iwg_rolemanagement->capmanager->file_basename);
            remove_submenu_page('users.php', $iwg_rolemanagement->general->file_basename);
            remove_submenu_page('users.php', $iwg_rolemanagement->help->file_basename);
            remove_meta_box('tagsdiv-cargo', 'publicacion', 'normal');
            
        }
        
        function comprueba_usuario_unico() {
            ?>
            <script type="text/javascript" >
            jQuery(document).ready(function($) {

                jQuery("select[name=role]").change(function(){

                    var data = {
                            action: 'usuario_unico',
                            email: jQuery('input[name=email]').val(),
                            rol: jQuery('select[name=role] option:selected').val()
                    };

                    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                    $.post(ajaxurl, data, function(response) {
                            if (response > 0){
                                jQuery("<span id='error_span1' style='color:#dd3d36' class='description'> Existe un usuario con el mismo email y el mismo rol. </span>").insertAfter("select[name=role]");
                            }
                            else{
                                jQuery("span[id^=error_span]").remove();                    
                            }
                    });     
                });    

                jQuery("input[name=email]").bind("change load",function(){
                    var data = {
                            action: 'usuario_unico',
                            email: jQuery('input[name=email]').val(),
                            rol: jQuery('select[name=role] option:selected').val()
                    };

                    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                    $.post(ajaxurl, data, function(response) {
                            if (response > 0){
                                jQuery("<span id='error_span2' style='color:#dd3d36' class='description'> Existe un usuario con el mismo email y el mismo rol. </span>").insertAfter("input[name=email]");
                            }
                            else{
                                jQuery("span[id^=error_span]").remove();                    
                            }
                    });
                });

            });
            </script>
            <?php
        }
        
        function usuario_unico_callback() {
            global $wpdb; // this is how you get access to the database

            $email = $_POST['email'];
            $rol = $_POST['rol'];

            $args = array (
                'role'  =>  $rol,
                'search' =>  $email,
                'search_columns' =>  array('user_email'),
            );

            $user_query = new WP_User_Query( $args );

            echo $user_query->get_total();

            die(); // this is required to return a proper result
         }
        
    }

    new OSProfileFields;
endif;
?>
