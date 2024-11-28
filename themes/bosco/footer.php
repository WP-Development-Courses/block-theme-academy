<?php
/**
 * @package Bosco
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'bosco_credits' ); ?>
			<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'bosco' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'bosco' ), 'WordPress' ); ?></a>
			<span class="sep">  &#8226; </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'bosco' ), 'Bosco', '<a href="https://wordpress.com/themes/" rel="designer">WordPress.com</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
