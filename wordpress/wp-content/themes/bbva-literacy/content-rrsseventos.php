<?php 
	$post_title = the_title('','',false);
	$blog_title = get_bloginfo('name');
	$permalink = get_permalink();
	$summary = get_post_meta(get_the_ID(), 'evento_descripcion_corta', true);
	$title_encoded = urlencode( html_entity_decode($blog_title . ' | ' . the_title('','',false)));
	$title = $blog_title . ' | ' . $post_title; 
?>

<div class="share-rrss-section mt-md">
    <p class="hidden-xs share-in"><?php _e('Compartir en'); ?></p>
    <div class="card-icon">
        <a class="icon icon-twitter bbva-icon-twitter-circle mr-xs" title="<?php echo $title; ?>" href="https://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo $title_encoded; ?>" target="popup" onclick="window.open('https://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo $title_encoded; ?>','name','width=600,height=500')"></a>
    </div>
    <div class="card-icon">
        <a class="icon icon-facebook bbva-icon-facebook-circle mr-xs" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>" target="popup" onclick="window.open(this.href,'name','width=600,height=500')"></a>
    </div>
    <div class="card-icon">
        <a class="icon icon-googleplus bbva-icon-google-plus-circle mr-xs" title="<?php echo $title; ?>" href="https://plus.google.com/share?url=<?php echo $permalink; ?>" target="popup" onclick="window.open('https://plus.google.com/share?url=<?php echo $permalink; ?>','name','width=600,height=500')"></a>
    </div>
    <div class="card-icon">
        <a class="icon icon-linkedin bbva-icon-linkedin-circle mr-xs" title="<?php echo $title; ?>" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo $title_encoded; ?>&summary=<?php echo $summary; ?>&source=<?php echo urlencode( html_entity_decode($blog_title)); ?>" target="popup" onclick="window.open(this.href,'name','width=520,height=570')"></a>
    </div>
</div>