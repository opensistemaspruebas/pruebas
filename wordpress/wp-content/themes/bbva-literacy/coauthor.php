<?php
/*Template Name: Página de co-autor */
?>

<?php get_header(); ?>

<div class="contents">
	<article id="about-us">
	
		<?php the_content(); ?>
<?php echo get_query_var("coauthor","nadie"); ?>
		<?php get_sidebar('sidebar-0'); ?>

	</article>
</div>
    
<?php get_footer(); ?>
