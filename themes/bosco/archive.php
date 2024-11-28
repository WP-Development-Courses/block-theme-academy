<?php
/**
 * @package Bosco
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( __( 'Author: %s', 'bosco' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( __( 'Day: %s', 'bosco' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month: %s', 'bosco' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s', 'bosco' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'bosco' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'bosco');

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'bosco' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'bosco' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'bosco' );

						else :
							_e( 'Archives', 'bosco' );

						endif;
					?>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php bosco_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'archive' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>