<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Gragas
 */
/**
 * Set up the WordPress core custom header feature.
 *
 * @uses gragas_header_style()
 */
function gragas_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'gragas_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'gragas_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'gragas_custom_header_setup' );

if ( ! function_exists( 'gragas_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see gragas_custom_header_setup().
	 */
	function gragas_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
		// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Gragas
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function gragas_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'gragas_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function gragas_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'gragas_pingback_header' );

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Gragas
 */

if ( ! function_exists( 'gragas_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function gragas_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( '%s', 'post date', 'gragas' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'gragas_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function gragas_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'Written by %s', 'post author', 'gragas' ),
			'<strong class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></strong>'
		);

		echo '<blockquote class="byline"> ' . $byline . '</blockquote>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'gragas_entry_tags') ) :
	function gragas_entry_tags() {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'gragas' ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'gragas' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'gragas_entry_categories' ) ) :
	function gragas_entry_categories() {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ' ', 'gragas' ) );
		if ( $categories_list ) {
			echo '<div class="categories">';
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">' . esc_html__( '%1$s', 'gragas' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			echo '</div>';
		}
	}
endif;

if ( ! function_exists( 'gragas_post_edit' ) ) :
	function gragas_post_edit() {
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'gragas' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'gragas_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function gragas_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'gragas' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'gragas' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'gragas' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'gragas' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'gragas' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'gragas' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if( !function_exists( 'gragas_pagination' ) ) :

	function gragas_pagination() {

		$prev = "<";
		$next = ">";
		$big = 999999;

		global $wp_query;
		$total = $wp_query->max_num_pages;

		if( $total > 1 ) {
			if( !$current_page = get_query_var('page') ) {
				$current_page = 1;	
				if( get_option('permalink_structure') ) {
					$format = 'page/%#%/';
				} else {
					$format = '&page=%#%';
				}

				echo paginate_links( array(
					'base' 		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' 	=> $format,
					'current' 	=> max( 1, get_query_var( 'paged' ) ),
					'total' 	=> $total,
					'mid_size' 	=> 3,
					'type' 		=> 'list',
					'prev_text' => $prev,
					'next_text' => $next,
				) );
			}
		}

	}

endif;

if ( ! function_exists( 'gragas_entry_tags' ) ) :
	/**
	 * Prints HTML with meta information for the tags.
	 */
	function gragas_entry_tags() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'gragas' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( '%1$s', 'gragas' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'gragas' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}
	}
	
endif;

if ( ! function_exists( 'gragas_entry_categories' ) ) :
	function gragas_entry_categories() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'gragas' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="gragas-cat-links">' . esc_html__( '%1$s', 'gragas' ) . '</span>', $categories_list); // WPCS: XSS OK.
			}

		}
	}
endif;

if ( ! function_exists( 'gragas_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function gragas_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail cover-image">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<div class="article-item--image">
			<a class="post-thumbnail block" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail( 'post-thumbnail', array(
					'alt' => the_title_attribute( array(
						'echo' => false,
					) ),
				) );
				?>
			</a>
		</div>

		<?php
		endif; // End is_singular().
	}
endif;


/**
 * Helpers methods
 * List all your static functions you wish to use globally on your theme
 *
 * @package awps
 */

if ( ! function_exists( 'dd' ) ) {
	/**
	 * Var_dump and die method
	 *
	 * @return void
	 */
	function dd() {
		echo '<pre>';
		array_map( function( $x ) {
			var_dump( $x );
		}, func_get_args() );
		echo '</pre>';
		die;
	}
}

if ( ! function_exists( 'starts_with' ) ) {
	/**
	 * Determine if a given string starts with a given substring.
	 *
	 * @param  string  $haystack
	 * @param  string|array  $needles
	 * @return bool
	 */
	function starts_with($haystack, $needles)
	{
		foreach ((array) $needles as $needle) {
			if ($needle != '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
				return true;
			}
		}
		return false;
	}
}

if (! function_exists('mixin')) {
	/**
	 * Get the path to a versioned Mix file.
	 *
	 * @param  string  $path
	 * @param  string  $manifestDirectory
	 * @return \Illuminate\Support\HtmlString
	 *
	 * @throws \Exception
	 */
	function mixin($path, $manifestDirectory = '')
	{
		if (! $manifestDirectory) {
			//Setup path for standard AWPS-Folder-Structure
			$manifestDirectory = "assets/dist/";
		}
		static $manifest;
		if (! starts_with($path, '/')) {
			$path = "/{$path}";
		}
		if ($manifestDirectory && ! starts_with($manifestDirectory, '/')) {
			$manifestDirectory = "/{$manifestDirectory}";
		}
		$rootDir = dirname(__FILE__, 2);
		if (file_exists($rootDir . '/' . $manifestDirectory.'/hot')) {
			return getenv('WP_SITEURL') . ":8080" . $path;
		}
		if (! $manifest) {
			$manifestPath =  $rootDir . $manifestDirectory . 'mix-manifest.json';
			if (! file_exists($manifestPath)) {
				throw new Exception('The Mix manifest does not exist.');
			}
			$manifest = json_decode(file_get_contents($manifestPath), true);
		}

		if (starts_with($manifest[$path], '/')) {
			$manifest[$path] = ltrim($manifest[$path], '/');
		}

		$path = $manifestDirectory . $manifest[$path];

		return get_stylesheet_directory_uri() . $path;
	}
}

/**
 * Gragas Current Title
 */
function gragas_current_title() {
	$text = 'Unknown';

	if( is_author() ) :
		
		// Get the author information
		global $author;
		$userdata = get_userdata($author);

		$text = sprintf( __('Author: %1$s', 'origamicrane'), $userdata->display_name );

    elseif( is_home() ):

        $text = __('Latest Blog Post', 'origamicrane');

    elseif ( is_archive() && !is_tax() && !is_category() && !is_tag() ):

		$text = post_type_archive_title($prefix, false);
		
		if( is_post_type_archive('portfolio') ) {
			// $text = __('Art Gallery', 'gragas');
		}

        if( is_day() ):
            $text = sprintf( __('Archive: %1$s', 'origamicrane'), get_the_time('jS') );
        elseif ( is_month() ):
            $text = sprintf( __('Archive: %1$s', 'origamicrane'), get_the_time('F') );
        elseif ( is_year() ):
            $text = sprintf( __('Archive: %1$s', 'origamicrane'), get_the_time('Y') );
        endif;

    elseif ( is_archive() && is_tax() && !is_category() && !is_tag() ):

		$text = get_queried_object()->name;

    elseif ( is_single() ):

        $text = get_the_title();

    elseif ( is_category() ):

        $text = __('Kategori: ', 'origamicrane') . single_cat_title('', false);

    elseif ( is_page() ):

        $text = get_the_title();

    elseif ( is_tag() ):

        // Get tag information
        $term_id        = get_query_var('tag_id');
        $taxonomy       = 'post_tag';
        $args           = 'include=' . $term_id;
        $terms          = get_terms($taxonomy, $args);
        $get_term_id    = $terms[0]->term_id;
        $get_term_slug  = $terms[0]->slug;
        $get_term_name  = $terms[0]->name;

        // Return information
        $text = sprintf( __('Tag: %1$s', 'origamicrane'), $get_term_name );

    elseif ( is_day() ):
        
        $text = sprintf( __('Arsip: %1$s', 'origamicrane'), get_the_time('jS') );

    elseif ( is_month() ):
        
        $text = sprintf( __('Arsip: %1$s', 'origamicrane'), get_the_time('F') );

    elseif ( is_year() ):
        
        $text = sprintf( __('Arsip: %1$s', 'origamicrane'), get_the_time('Y') );

    elseif ( get_query_var('paged') ):

        $text = sprinf( __('Page %1$s', 'origamicrane'), get_query_var('paged') );

    elseif ( is_search() ):

        $text = sprintf( esc_html__( 'Hasil pencarian: %s', 'origamicrane' ), get_search_query() );

    elseif ( is_404() ):

        $text = __('Page Not Found', 'origamicrane');
        
    endif;

    return $text;
}

/**
 * Gragas Jumbotron
 */
function the_gragas_jumbotron( $post = 0, $force = false ) {
	if( get_the_page_jumbotron( $post ) || $force ):
	?>
	<div class="jumbotron">
		<div class="jumbotron-wrapper">
			<h1 class="jumbotron-title"><?php echo gragas_current_title(); ?></h1>
			<div class="breadcrumb-container">
				<?php breadcrumbs(); ?>
			</div>
		</div>
	</div>
	<?php
	endif;
}

/**
 * @version    4.0.1
 * @package    Alpha
 * @author     Ahmad Faris <faris@cirebonmedia.com>
 * @copyright  Copyright (C) 2015 CirebonMedia.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.cirebonmedia.com
 */
function breadcrumbs()
{

    // Settings
    $separator          = '&gt;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumb';
    $home_title         = 'Beranda';

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';

    // Get the query & post information
    global $post, $wp_query;

    // Do not display on the homepage
    if (!is_front_page()) {

        // Build the breadcrums
        echo '<ol id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';

		if( is_author() ) {

			// Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata($author);

            // Display author name
			echo '<li class="active item-current item-current-' . $userdata->user_nicename . '">' . 'Author: ' . $userdata->display_name . '</li>';
			
		} elseif (is_home()) {
            echo '<li class="active">Blog</li>';
        } elseif (is_archive() && !is_tax() && !is_category() && !is_tag()) {
            echo '<li class="active">' . post_type_archive_title($prefix, false) . '</li>';
        } elseif (is_archive() && is_tax() && !is_category() && !is_tag()) {
            $tax = get_taxonomy(get_query_var('taxonomy'));
            echo '<li class="item-tax item-custom-tax-' . $tax->name . '"><span>' . $tax->labels->name . '</span></li>';

            $custom_tax_name = get_queried_object()->name;
            echo '<li class="active">' . $custom_tax_name . '</li>';
        } elseif (is_single()) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if ($post_type != 'post') {
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
            }

            // Get post category info
            $category = get_the_category();

            if (!empty($category)) {

                // Get last category post is in
                $last_category = end(array_values($category));

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
                $cat_parents = explode(',', $get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach ($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">' . $parents . '</li>';
                }
            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if (empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                $taxonomy_terms = get_the_terms($post->ID, $custom_taxonomy);
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
            }

            $judul_artikel = get_the_title();
            if (strlen($judul_artikel) > 20) {
                $judul_artikel = substr($judul_artikel, 0, 20) . "...";
            }

            // Check if the post is in a category
            if (!empty($last_category)) {
                echo $cat_display;
                echo '<li class="active item-' . $post->ID . '">' . $judul_artikel . '</li>';

            // Else if post is in a custom taxonomy
            } elseif (!empty($cat_id)) {
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="active item-' . $post->ID . '">' . get_the_title() . '</li>';
            } else {
                echo '<li class="active item-' . $post->ID . '">' . get_the_title() . '</li>';
            }
        } elseif (is_category()) {

            // Category page
            echo '<li class="active item-cat">' . single_cat_title('', false) . '</li>';
        } elseif (is_page()) {

            // Standard page
            if ($post->post_parent) {

                // If child page, get parents
                $anc = get_post_ancestors($post->ID);

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                foreach ($anc as $ancestor) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="active item-' . $post->ID . '">' . get_the_title() . '</li>';
            } else {

                // Just display current page if not parents
                echo '<li class="active item-' . $post->ID . '">' . get_the_title() . '</li>';
            }
        } elseif (is_tag()) {

            // Tag page

            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms($taxonomy, $args);
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;

            // Display the tag name
            echo '<li class="active item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '">' . $get_term_name . '</li>';
        } elseif (is_day()) {

            // Day archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">Arsip Tahun' . get_the_time('Y') . '</a></li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '" title="' . get_the_time('M') . '">Arsip Bulan' . get_the_time('M') . '</a></li>';

            // Day display
            echo '<li class="active item-' . get_the_time('j') . '">Arsip ' . get_the_time('jS') . ' ' . get_the_time('M') . '</li>';
        } elseif (is_month()) {

            // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">Arsip Tahun ' . get_the_time('Y') . '</a></li>';

            // Month display
            echo '<li class="active item-month-' . get_the_time('m') . '">Arsip Bulan' . get_the_time('M') . '</li>';
        } elseif (is_year()) {

            // Display year archive
            echo '<li class="active item-current-' . get_the_time('Y') . '">Arsip Tahun ' . get_the_time('Y') . '</li>';
        } elseif (get_query_var('paged')) {

            // Paginated archives
            echo '<li class="active item-current item-current-' . get_query_var('paged') . '">' . __('Halaman') . ' ' . get_query_var('paged') . '</li>';
        } elseif (is_search()) {

            // Search results page
            echo '<li class="active item-current item-current-' . get_search_query() . '">Hasil pencarian: ' . get_search_query() . '</li>';
        } elseif (is_404()) {

            // 404 page
            echo '<li class="active">' . 'Error 404' . '</li>';
        }

        echo '</ol>';
    }
}

/**
 * Gragas Post Related
 */
function gragas_article_related() {
	$tags = wp_get_post_tags(get_the_id());
	if( $tags ) {
		$tag_ids = [];
		foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

		$args = [
			'tag__in'			=> $tag_ids,
			'post__not_in'		=> [get_the_id()],
			'posts_per_page'	=> 4,
			'caller_get_posts'	=> 1,
			'post_type'			=> get_post_type(),
		];

		$related = new WP_Query($args);

		if( $related->have_posts() ):
			echo '<div class="related-post">';
			
				echo '<h3 class="title-related">' . __('Related Post', 'gragas') . '</h3>';
				
				echo '<div class="grid grid-cols-1 gap-5 md:grid-cols-3 md:gap-8">';

					while( $related->have_posts() ):

						$related->the_post();

						echo '<article id="post-'.get_the_ID().'" '. get_post_class('article-item').'>';

							get_template_part( 'template-parts/content', 'grid' );

						echo '</article>';

					endwhile;

				echo '</div>';

			echo '</div>';
		endif;
	}
}

function gragas_post_related() {
	$tags = wp_get_post_tags(get_the_id());
	if( $tags ) {
		$tag_ids = [];
		foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

		$args = [
			'tag__in'			=> $tag_ids,
			'post__not_in'		=> [get_the_id()],
			'posts_per_page'	=> 4,
			'caller_get_posts'	=> 1,
			'post_type'			=> get_post_type(),
		];

		$related = new WP_Query($args);

		if( $related->have_posts() ):

			if( get_post_type() == 'post' ) {
				echo '<div class="related-post">
					<div class="container-fluid">';
			} else {
				echo '<div class="portfolio-grid-section">
				<h3 class="title-related">' . __('Seni Terkait', 'gragas') . '</h3>';
			}

			echo '<div class="row justify-content-center">';

			while( $related->have_posts() ):

				$related->the_post();

				echo '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">';

				if( get_post_type() == 'post' ) {
					get_template_part( 'template-parts/content-item', get_post_format() );
				} else {
					get_template_part( 'template-parts/content-item', get_post_type() );
				}

				echo '</div>';

			endwhile;

			if( get_post_type() == 'post' ) {
				echo '</div></div></div>';
			} else {
				echo '</div></div>';
			}
		endif;
	}
}

/**
 * Print next and previous post
 **/
function gragas_post_navigation() {
	$prevPost = get_previous_post();
	$prevThumbnail = get_the_post_thumbnail( $prevPost->ID );
	$prevLink = get_previous_post_link( '%link', sprintf('<div class="img-container">%1$s</div><div class="title-container"><h6>%2$s</h6></div>', $prevThumbnail, $prevPost->post_title) );
	$nextPost = get_next_post();
	$nextThumbnail = get_the_post_thumbnail( $nextPost->ID );
	$nextLink = get_next_post_link( '%link', sprintf('<div class="img-container">%1$s</div><div class="title-container"><h6>%2$s</h6></div>', $nextThumbnail, $nextPost->post_title) );

	if( $prevLink || $nextLink ) {
		echo '<nav class="post-navigation__container">';

		echo $prevLink . $nextLink;

		echo '</nav>';
	}
}

/**
 * Get menu functions
 */
function gragas_get_menu($location, $print = false)
{
    $menu = strip_tags(
        wp_nav_menu(
            array(
                'theme_location' 	=> $location,
                'container' 		=> 'ul',
                'container_class' 	=> 'item',
                'menu_class' 		=> 'm-0 list-none flex items-center justify-end main-navigation animate__animated',
                // 'walker'          	=> new \Lorasin\Core\WalkerNav
            )
        ),
        '<a><nav><i>'
    );

    if ($print) {
        echo $menu;
        return;
    }

    return $menu;
}
/**
 * Get top header menu functions
 */
function gragas_menu_header() {
    gragas_get_menu('top', true);
}

/**
 * Get primary menu functions
 */
function gragas_menu_primary()
{
    gragas_get_menu('primary', true);
}

/**
 * Get footer menu functions
 */
function gragas_menu_footer()
{
    gragas_get_menu('footer', true);
}

function load_template_part( $template_name, $part_name = null ) {
    ob_start();
    get_template_part( $template_name, $part_name );
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}

function gragas_default_image() {
	return get_stylesheet_directory_uri() . '/assets/dist/images/placeholder.png';
}

function get_the_page_header_style( $post = 0 ) {
	$post = get_post( $post );
	$data = get_post_meta( $post, 'gragas_page_header_style', true );

	return $data ?: 'boxed';
}

function get_the_page_jumbotron( $post = 0 ) {
	$post = get_post( $post );
	$data = get_post_meta( $post->ID, 'gragas_page_jumbotron', true );

	return $data == 1;
}

function slugify($text) {
	// replace non letter or digits by -
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);

	// transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);

	// trim
	$text = trim($text, '-');

	// remove duplicate -
	$text = preg_replace('~-+~', '-', $text);

	// lowercase
	$text = strtolower($text);

	if (empty($text)) {
	return 'n-a';
	}

	return $text;
}

function unslugify( $text ) {
	return str_replace( '_', ' ', $text );
}

function get_user_ip_addr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function gragas_sharing_button() {
	echo '<wsocial-sharing title="'. get_the_title() .'" link="'. get_the_permalink() .'" excerpt="'. get_the_excerpt() .'" />';
}

require_once 'Settings.php';