<?php
/**
 * Template for displaying posts in the Status Post Format
 *
 * Used on index and archive pages
 *
 * @link https://codex.wordpress.org/Post_Formats
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<hgroup>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<h3 class="entry-format"><?php _e( 'Status', 'twentyeleven' ); ?></h3>
			</hgroup>

		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<div class="avatar">
				<?php
				/**
				 * Filter the Twenty Eleven status avatar size.
				 *
				 * @since Twenty Eleven 1.0
				 *
				 * @param int The height and width avatar dimensions in pixels. Default 65.
				 */
				echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'twentyeleven_status_avatar', 65 ) );
				?>
			</div>

			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

		
	</article><!-- #post-<?php the_ID(); ?> -->
