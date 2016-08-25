
<?php
/**
 * Sidebar del Grupo Principal, Columna Completa
 *
 */


if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>


<?php dynamic_sidebar( 'sidebar-1' ); ?>


