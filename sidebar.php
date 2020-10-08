<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link        https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @link        https://www.upwork.com/fl/mahdiyazdani
 * @author      Mahdi Yazdani <mahdiyazdani@mail.com>
 * @since       2.0.0
 *
 * @package     hypermarket
 */

if ( ! hypermarket_has_sidebar() ) {
	return;
}

?><aside id="secondary" class="widget-area" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
