<?php 
	$post_title = the_title('','',false);
	$blog_title = get_bloginfo('name');
	$permalink = get_permalink();
	$summary = get_the_excerpt('','',false);
	$title_encoded = urlencode( html_entity_decode($blog_title . ' | ' . the_title('','',false)));
	$title = $blog_title . ' | ' . $post_title;
?>


<div class="share-rrss-section col-sm-4 col-sm-offset-3">
  <p class="mr-xs"><?php _e('Compartir en','os_historia_type'); ?></p>  
  	<div class="card-icon">
      	<a title="<?php echo $title; ?>" href="https://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo $title_encoded; ?>" target="popup" onclick="window.open('https://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo $title_encoded; ?>','name','width=600,height=500')">
      		<span class="icon icon-twitter bbva-icon-twitter-circle mr-xs"></span>
      	</a>
  	</div>
  
  	<div class="card-icon">
  		<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>" target="popup" onclick="window.open(this.href,'name','width=600,height=500')">
    		<span class="icon icon-facebook bbva-icon-facebook-circle mr-xs"></span>
    	</a>
  	</div>
  
  	<div class="card-icon">
  		<a title="<?php echo $title; ?>" href="https://plus.google.com/share?url=<?php echo $permalink; ?>" target="popup" onclick="window.open('https://plus.google.com/share?url=<?php echo $permalink; ?>','name','width=600,height=500')">
      		<span class="icon icon-googleplus bbva-icon-google-plus-circle mr-xs"></span>
      	</a>
  	</div>
  
  	<!--div class="card-icon">
      	<span class="icon icon-pinterest bbva-icon-facebook_link mr-xs"></span>
  	</div-->
  
  	<div class="card-icon">
  		<a title="<?php echo $title; ?>" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo $title_encoded; ?>&summary=<?php echo $summary; ?>&source=<?php echo urlencode( html_entity_decode($blog_title)); ?>" target="popup" onclick="window.open(this.href,'name','width=520,height=570')">
      		<span class="icon icon-linkedin bbva-icon-linkedin-circle mr-xs"></span>
      	</a>
  	</div>
  
</div>