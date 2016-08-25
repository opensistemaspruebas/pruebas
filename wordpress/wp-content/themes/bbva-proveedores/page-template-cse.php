<?php
/**
 * Template Name: Google CSE
*/
 
global $theme; get_header(); ?>
 
    <div id="main">
     
        <?php $theme->hook('main_before'); ?>
 
        <div id="content">
             
            <?php $theme->hook('content_before'); ?>
 
            <script>
              (function() {
                var cx = '001455800085049371218:_jimodya4xy';
                var gcse = document.createElement('script');
                gcse.type = 'text/javascript';
                gcse.async = true;
                gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(gcse, s);
              })();
            </script>
            <gcse:search></gcse:search>        
 
            <?php $theme->hook('content_after'); ?>
         
        </div>
     
        <?php get_sidebars(); ?>
         
        <?php $theme->hook('main_after'); ?>
         
    </div>
     
<?php get_footer(); ?>
