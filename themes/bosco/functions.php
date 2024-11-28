<?php
/**
 * Bosco functions and definitions
 *
 * @package Bosco
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 750; /* pixels */
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bosco_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * Set post thumbnail size.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 750, 'auto' );

	// Switches default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array( 'primary' => __( 'Primary Menu', 'bosco' ) ) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}

add_action( 'after_setup_theme', 'bosco_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function bosco_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'First Footer Widget Area', 'bosco' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Second Footer Widget Area', 'bosco' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Third Footer Widget Area', 'bosco' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'bosco_widgets_init' );

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Lora by default is localized. For languages that use characters
 * not supported by the font, the font can be disabled.
 *
 * Returns the font stylesheet URL or empty string if disabled.
 */
function bosco_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lora, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lora font: on or off', 'bosco' ) ) {
		$font_url = add_query_arg( 'family', urlencode( 'Lora:400,700,400italic,700italic' ), "//fonts.googleapis.com/css" );
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles
 */
function bosco_scripts() {
	wp_enqueue_style( 'bosco-lora', bosco_font_url(), array(), null );
	wp_enqueue_style( 'bosco-style', get_stylesheet_uri(), array(), '20130728' );
}
add_action( 'wp_enqueue_scripts', 'bosco_scripts' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function bosco_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() ) {
		return $title;
	}

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'bosco' ), max( $paged, $page ) );
	}

	return $title;
}

add_filter( 'wp_title', 'bosco_wp_title', 10, 2 );

/*
 */
function bosco_img_caption_shortcode( $output, $atts, $content ) {
	/* We're not worried abut captions in feeds, so just return the output here. */
	if ( is_feed() ) {
		return $output;
	}

	/* Set up the default arguments. */
	$defaults = array(
		'id'      => '',
		'align'   => 'alignnone',
		'width'   => '',
		'caption' => ''
	);

	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $atts, 'caption' );

	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) ) {
		return $content;
	}

	/* Set the width class: if the width is larger than 750, set it to 750 get the right styles. */
	if ( 750 <= $attr['width'] ) {
		$width_class = 750;
	} else {
		$width_class = $attr['width'] . ' smaller-than-750';
	}

	/* Set up the attributes for the caption <div>. */
	$attributes = ( ! empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . ' width-' . esc_attr( $width_class ) . '"';
	$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';

	/* Open the caption <div>. */
	$output = '<div' . $attributes . '>';

	/* Allow shortcodes for the content the caption was created for. */
	$output .= do_shortcode( $content );

	/* Append the caption text. */
	$output .= '<p class="wp-caption-text">' . $attr['caption'] . '</p>';

	/* Close the caption </div>. */
	$output .= '</div>';

	/* Return the formatted, clean caption. */

	return $output;
}

add_filter( 'img_caption_shortcode', 'bosco_img_caption_shortcode', 10, 3 );

/**
 * Filters the HTML containing the attachment that is prepended to the post to use
 * the large image size (instead of the medium default).
 */
function bosco_prepend_attachment( $prepend ) {
	$prepend = '<p class="attachment">';
	$prepend .= wp_get_attachment_link( 0, 'large', false );
	$prepend .= '</p>';

	return $prepend;
}

add_filter( 'prepend_attachment', 'bosco_prepend_attachment' );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @return void
 * @global WP_Query $wp_query WordPress Query object.
 */
function bosco_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}

add_action( 'wp', 'bosco_setup_author' );

/**
 * Display navigation to next/previous set of posts when applicable.
 */
function bosco_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'bosco' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous"><span class="meta-nav">&larr;</span> <?php next_posts_link( __( 'Previous Page', 'bosco' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next"><?php previous_posts_link( __( 'Next Page', 'bosco' ) ); ?> <span class="meta-nav">&rarr;</span></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}


/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */
function bosco_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'bosco' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '<div class="nav-previous">%link</div>', '<div class="meta-nav">' . _x( '&larr;', 'Previous post link', 'bosco' ) . '</div><div class="link">%title</div>' ); ?>
			<?php next_post_link( '<div class="nav-next">%link</div>', '<div class="meta-nav">' . _x( '&rarr;', 'Next post link', 'bosco' ) . '</div><div class="link">%title</div>' ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

/**
 * Prints HTML with the post format, date/time, author and permalink for the current post.
 */
function bosco_posted_on() {

	/* Post Format */
	$format = get_post_format();
	if ( $format ) {
		printf( '<span class="post-format"><a class="entry-format" href="%1$s">%2$s</a></span>',
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	/* Date */
	$time_string = '<span class="posted-on"><span class="screen-reader-text">Posted on </span><time class="entry-date published" datetime="%1$s">%2$s</time></span>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	printf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	/* Author */
	printf( '<span class="byline"><span class="screen-reader-text"> by </span><span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);

	/* Permalink */
	printf( '<span class="permalink"><a href="%1$s" rel="bookmark">&#8734</a></span>',
		esc_url( get_permalink() )
	);
}

/**
 * Prints HTML with the post format, date/time, author and permalink for the current post.
 */
function bosco_post_meta() {

	// Post Format
	$format            = get_post_format();
	$supported_formats = get_theme_support( 'post-formats' );

	if ( $format && has_post_format( $supported_formats[0] ) ) {
		printf( '<span class="post-format"><a class="entry-format" href="%1$s">%2$s</a></span>',
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	// Date and Permalink
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">Posted on %1$s</span><span class="byline"> by %2$s</span>', 'bosco' ),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		)
	);
}

/**
 * Prints HTML with the categories and tags for the current post.
 */
function bosco_categories_tags() {
	$categories_tags = '';

	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( __( ', ', 'bosco' ) );

	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', __( ', ', 'bosco' ) );

	// Don't print anything if there's only 1 category and no tags.
	if ( $categories_list || $tags_list ) :
		?>
		<div class="categories-tags">
			<?php if ( $categories_list  ) : ?>
				<span class="cat-links">
			<?php printf( __( 'Posted in %1$s', 'bosco' ), $categories_list ); ?>
		</span>
			<?php endif; // End if bosco_categorized_blog()
			?>

			<?php if ( $tags_list ) : ?>
				<span class="tags-links">
			<?php printf( __( 'Tagged %1$s', 'bosco' ), $tags_list ); ?>
		</span>
			<?php endif; // End if $tags_list
			?>
		</div><!-- .categories-tags -->
	<?php
	endif;
}

/**
 * Print the attached image with a link to the next attached image.
 */
function bosco_the_attached_image() {
	$next_attachment_url = wp_get_attachment_url();
	$post                = get_post();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => - 1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		} // or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, 'full' )
	);
}

/**
 * Uses get_url_in_content() to get the URL of the first link found in the post content.
 * Falls back to the post permalink if no URL is found in the post.
 */
function bosco_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with a Continue reading link.
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function bosco_excerpt_more( $more ) {
	return sprintf( ' <a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		sprintf( __( 'Continue reading %s', 'bosco' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span> <span class="meta-nav">&rarr;</span>' )
	);
}

add_filter( 'excerpt_more', 'bosco_excerpt_more' );
