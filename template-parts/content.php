<?php
/**
 * Template part for displaying posts.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @link        https://mypreview.github.io/hypermarket
 * @author      MyPreview
 * @since       2.0.0
 *
 * @package     hypermarket
 * @subpackage  hypermarket/template-parts
 */

?><article id="post-<?php the_ID(); ?>" <?php post_class( 'post-view' ); ?>>
	<?php

		/**
		 * Functions hooked in to `hypermarket_loop_post` action.
		 *
		 * @hooked hypermarket_div                 - 5
		 * @hooked hypermarket_post_header         - 10
		 * @hooked hypermarket_post_meta           - 20
		 * @hooked hypermarket_div_close           - 25
		 * @hooked hypermarket_post_thumbnail      - 30
		 * @hooked hypermarket_post_excerpt        - 40
		 * @hooked hypermarket_post_footnote       - 50
		 */
		do_action( 'hypermarket_loop_post', get_the_ID() );

	?>
</article><!-- #post-<?php the_ID(); ?> -->
