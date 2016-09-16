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

<!-- banner simple -->
<article class="block-image block-image_know-us wow fadeInUp">
    <img src="<?php echo wp_get_attachment_image_url($image_id, 'original'); ?>" alt="image title" />
    <div class="film-grey"></div>
    <div class="block-content-center">
        <div class="container text-default">
            <h2 class="title"><?php echo $title; ?></h2>
            <p><?php echo wpautop($text); ?></p>
            <button type="button" class="btn-rounded-orange-border" onclick="window.location.href='<?php echo $link; ?>'"><?php echo $link_text; ?></button>
        </div>
    </div>
</article>
<!-- EO banner simple -->