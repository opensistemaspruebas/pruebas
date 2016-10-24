<?php 
	$post_title = the_title('','',false);
	$blog_title = get_bloginfo('name');
	$permalink = get_permalink();
	$summary = get_the_excerpt('','',false);
	$title_encoded = urlencode( html_entity_decode($blog_title . ' | ' . the_title('','',false)));
	$title = $blog_title . ' | ' . $post_title;
?>

<div class="share-rrss-section rrss-xs">
  <span id="share-button" class="icon bbva-icon-share" data-container="body" data-toggle="popover" data-placement="left" data-html="true"
  data-content="<a title='<?php echo $title; ?>' href='https://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo $title_encoded; ?>'' target='popup' onclick='window.open('https://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo $title_encoded; ?>','name','width=600,height=500')'><span data-wow-delay='0.4s' class='bbva-icon-twitter-circle twitter-icon mr-xs wow rollIn'></span></a>

  <a href='https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>' target='popup' onclick='window.open(this.href,'name','width=600,height=500')'><span data-wow-delay='0.3s' class='bbva-icon-facebook-circle facebook-icon mr-xs wow rollIn'></span></a>

  <a title='<?php echo $title; ?>' href='https://plus.google.com/share?url=<?php echo $permalink; ?>' target='popup' onclick='window.open('https://plus.google.com/share?url=<?php echo $permalink; ?>','name','width=600,height=500')'><span data-wow-delay='0.2s' class='bbva-icon-google-plus-circle googleplus-icon mr-xs wow rollIn'></span></a>
  
  <a title='<?php echo $title; ?>' href='http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo $title_encoded; ?>&summary=<?php echo $summary; ?>&source=<?php echo urlencode( html_entity_decode($blog_title)); ?>' target='popup' onclick='window.open(this.href,'name','width=520,height=570')'><span data-wow-delay='0s' class='bbva-icon-linkedin-circle linkedin-icon mr-xs wow rollIn'></span></a>"></span>
</div>