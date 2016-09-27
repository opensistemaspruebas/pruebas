<?php
/*
Template Name: Archives
*/
get_header(); ?>

<meta name="wp_search" content="true"/>
<meta name="wp_content" content="<?php single_cat_title(); ?>"/>
<meta name="wp_topic" content="category"/>

<div id="container">
	<div id="content" role="main">

		<p>Category: <?php single_cat_title(); ?></p>

	</div><!-- #content -->
</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>