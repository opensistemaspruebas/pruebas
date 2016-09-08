<?php
/**
 * Default widget template.
 *
 * Copy this template to /os_image_widget/widget.php in your theme or
 * child theme to make edits.
 *
 * @package   SimpleImageWidget
 * @copyright Copyright (c) 2015 Cedaro, LLC
 * @license   GPL-2.0+
 * @since     4.0.0
 */
?>

<section class="moduloContenido_carruselPromocionalHeader">
    <div class="carruselPromocional">
        <ul class="tabs_contentHorizontal">
            <li class="tab_box" id="promo_01">
            	<?php if (!empty($image_id)) : ?>
                <figure class="moduloCarrusel_boxImagen" style="background-image: url('<?php echo wp_get_attachment_image_url($image_id); ?>');">
                	<img src="<?php echo wp_get_attachment_image_url($image_id); ?>">
                </figure>
                <?php endif; ?>
                <div class="wrapperContent">
                    <div class="moduloCarrusel_boxTexto promoTipo_botonVerde">
                    	<?php if (!empty($title)) : ?>
                        <p class="fotoInfo_titulo"><?php echo $title; ?></p>
                    	<?php endif; ?>
                    	<?php if (!empty($text)) : ?>
                        <?php echo wpautop($text); ?>
                    	<?php endif; ?>
                    	<?php if ( ! empty( $link_text ) ) : ?>
                        <p class="fotoInfo_link">
                        	<?php
                        		echo $text_link_open;
								echo $link_text;
								echo $text_link_close;
                        	?>
                        </p>
                    	<?php endif; ?>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</section>