<div class="wrap">

<h2><?php _e('Site Social Networks', 'os_redes_plugin') ?></h2>

<form method="post" action="options.php" novalidate="novalidate">
        <!--input type="hidden" name="action" value="os_redes_save" /-->
    <?php settings_fields( 'os-social-footer' ); ?>         

    <p><?php _e('Los siguientes enlaces aparecerán en el footer de la página', 'os_redes_plugin') ?></p>

    <h3>Twitter</h3>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><?php _e('URL de la cuenta', 'os_redes_plugin') ?></th>
        <td><input class="widefat" type="text" name="twitter-url" value="<?php echo get_option('twitter-url'); ?>" /></td>
        </tr>
    </table>

    <h3>Youtube</h3>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><?php _e('URL del canal', 'os_redes_plugin') ?></th>
        <td><input class="widefat" type="text" name="youtube-url" value="<?php echo get_option('youtube-url'); ?>" /></td>
        </tr>
    </table>

    <h3>Facebook</h3>
   <table class="form-table">
       <tr valign="top">
       <th scope="row"><?php _e('URL de la página', 'os_redes_plugin') ?></th>
       <td><input class="widefat" type="text" name="facebook-url" value="<?php echo get_option('facebook-url'); ?>" /></td>
       </tr>
   </table>
    
    <?php submit_button(); ?>

</form>

</div>