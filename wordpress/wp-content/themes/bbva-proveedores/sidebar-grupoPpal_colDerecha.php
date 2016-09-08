<?php
/**
 * Sidebar del Grupo Principal, Columna Derecha
 *
 */

if ( ! is_active_sidebar( 'sidebar-3' ) ) {
	return;
}
?>


<?php dynamic_sidebar( 'sidebar-3' ); ?>

