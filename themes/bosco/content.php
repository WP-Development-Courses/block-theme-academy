<?php
/**
 * @package Bosco
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( is_single() ) : ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php else : ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php endif; // if is_single ?>
	</header><!-- .entry-header -->

	<?php if ( '' != get_the_post_thumbnail() && ! post_password_required() ) : ?>
	<div class="entry-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .entry-thumbnail -->
	<?php endif; ?>

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'bosco' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'bosco' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : ?>
			<?php bosco_post_meta(); ?>
		<?php endif; ?>

		<?php if ( 'post' == get_post_type() && is_single() ) : // Hide category and tag text for pages on Search ?>
			<?php bosco_categories_tags(); ?>
		<?php endif; // End if 'post' == get_post_type() ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
