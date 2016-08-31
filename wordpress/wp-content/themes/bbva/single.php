<?php
/**
 * Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>
	
		<!-- Para indicar que hay que indexar los posts. -->
		<meta name="wp_search" content="true">
		<meta name="wp_title" content="<?php echo $post->post_title; ?>">
		<?php
			// Elimino puntos, comas y saltos de línea, y paso todo el texto a minúscula. 
		 	$post_content = strtolower(str_replace(array("\r", "\n"), '', strtr(strip_tags($post->post_content), array('.' => '', ',' => ''))));
		?>
		<meta name="wp_content" content="<?php echo $post_content; ?>">
		<meta name="wp_topic" content="<?php _('Publicación'); ?>">
		<!-- ******************************************* -->


		<div id="primary" class="container">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<nav id="nav-single">
						<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
						<span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'twentyeleven' ) ); ?></span>
						<span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></span>
					</nav><!-- #nav-single -->

					<?php get_template_part( 'content-single', get_post_format() ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_footer(); ?>
