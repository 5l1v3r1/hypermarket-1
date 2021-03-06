<?php
/**
 * The loop template file.
 * Included on pages like index.php, archive.php and `search.php` to display a loop of posts.
 *
 * @link        https://codex.wordpress.org/The_Loop
 * @link        https://mypreview.github.io/hypermarket
 * @author      MyPreview
 * @since       2.0.0
 *
 * @package     hypermarket
 */

do_action( 'hypermarket_loop_before' );

while ( have_posts() ) :
	the_post();

	/**
	 * Include the Post-Format-specific template for the content.
	 * If you want to override this in a child theme, then include a file
	 * called `template-parts/content-___.php` (where ___ is the Post Format name) 
	 * and that will be used instead.
	 */
	get_template_part( 'template-parts/content', get_post_format() );

endwhile;

/**
 * Functions hooked in to `hypermarket_paging_nav` action
 *
 * @hooked hypermarket_paging_nav       - 10
 */
do_action( 'hypermarket_loop_after' );
