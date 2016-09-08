<?php
/**
 * Sidebar Columna Principal
 *
 */

if ( ! is_active_sidebar( 'sidebar-0' ) ) {
	return;
}
?>

<div class="colFluid">
	<?php dynamic_sidebar( 'sidebar-0' ); ?>
</div>
