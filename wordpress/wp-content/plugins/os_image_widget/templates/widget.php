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
<section class="block-image block-outstanding-image wow fadeInUp">
    <div class="image-section">
    	<img class="img-responsive" src="<?php echo wp_get_attachment_image_url($image_id, 'original'); ?>" alt="image title" />
        <div class="visible-xs triangle-down-right"></div>
    </div>
    <div class="container">
        <div class="block-content-center background-container">
            <div class="home-title-layer home-title-layer-one"></div>
            <div class="home-title-layer home-title-layer-two"></div>
            <h2><?php echo $title; ?></h2>
            <p><?php echo strip_tags($text); ?></p>
			<div class="container-button">
				<a <?php if ($new_window == "on") echo 'target="_blank"';?> href="<?php echo $link; ?>" class="btn btn-bbva-aqua"><?php echo $link_text; ?></a>
			</div>
        </div>
    </div>
</section>