<?php
/**
 * Main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 */

get_header(); ?>


		<div id="primary" class="container">
			<div id="content" role="main">

			<?php get_sidebar('sidebar-1'); ?>

			<?php if ( have_posts() ) : ?>

				<?php twentyeleven_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php //get_template_part( 'content', get_post_format() ); ?>
					<h1><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
					<p><?php the_content(); ?></p>

				<?php endwhile; ?>

				<?php twentyeleven_content_nav( 'nav-below' ); ?>
			<?php endif; ?>
			</div>
		</div>

<?php get_footer(); ?>