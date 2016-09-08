<?php
/**
 * Sidebar del Grupo Secundario, Columna Principal
 *
 */

if ( ! is_active_sidebar( 'sidebar-0' ) ) {
	return;
}
?>

<?php dynamic_sidebar( 'sidebar-0' ); ?>
