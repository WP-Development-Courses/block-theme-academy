<?php
/**
 * @package Bosco
 */

/* If none of the sidebars have widgets, then let's bail early. */
if ( ! is_active_sidebar( 'sidebar-1' ) && ! is_active_sidebar( 'sidebar-2' ) && ! is_active_sidebar( 'sidebar-3' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area footer-widget-area" role="complementary">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div class="first footer-widgets">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
	<div class="second footer-widgets">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
	<div class="third footer-widgets">
		<?php dynamic_sidebar( 'sidebar-3' ); ?>
	</div>
	<?php endif; ?>
</div><!-- #secondary -->
