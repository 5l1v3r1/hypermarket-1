<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being `style.css`).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @link        https://www.upwork.com/fl/mahdiyazdani
 * @author      Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since       2.0.0
 *
 * @package     hypermarket
 */

get_header(); 

?><div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
		
		/**
		 * Functions hooked into `hypermarket_home_top` action
		 *
		 * @hooked  hypermarket_div                    - 5
		 * @hooked  hypermarket_posts_page_header      - 10
		 * @hooked  hypermarket_breadcrumb             - 20
		 * @hooked  hypermarket_div_close              - 25
		 * @hooked  hypermarket_jscroll           	   - 30
		 */
		do_action( 'hypermarket_home_top' );
		
		if ( have_posts() ) :
			get_template_part( 'loop' );
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		
		/**
		 * Functions hooked into `hypermarket_home_bottom` action
		 *
		 * @hooked  hypermarket_jscroll_close          - 5
		 */
		do_action( 'hypermarket_home_bottom' );

		?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php

/**
 * Functions hooked into `hypermarket_sidebar` action
 *
 * @hooked  hypermarket_get_sidebar         - 10
 */
do_action( 'hypermarket_sidebar' );

get_footer();
