<?php
/**
 * Adjacent (neighbouring) products class.
 * Fetches links to the next/previous products on the single product page.
 *
 * @since 	    2.0.0
 * @package 	hypermarket
 * @author  	MyPreview (Github: @mahdiyazdani, @mypreview)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hypermarket_WooCommerce_Adjacent_Products' ) ) :

	/**
	 * The adjacent products class
	 */
	class Hypermarket_WooCommerce_Adjacent_Products {

		/**
		 * The current product ID.
		 *
		 * @var int|null
		 */
		private $current_product = null;

		/**
		 * Whether post should be in a same taxonomy term.
		 *
		 * @var bool
		 */
		private $in_same_term = false;

		/**
		 * List of excluded term IDs.
		 *
		 * @var string
		 */
		private $excluded_terms = '';

		/**
		 * Taxonomy slug.
		 *
		 * @var string
		 */
		private $taxonomy = 'product_cat';

		/**
		 * Whether to retrieve previous product.
		 *
		 * @var bool
		 */
		private $previous = false;

		/**
		 * Setup class.
		 *
		 * @param 	bool         	$in_same_term   	Whether post should be in a same taxonomy term. Default false.
		 * @param 	array|string 	$excluded_terms 	Comma-separated list of excluded term IDs. Default empty.
		 * @param 	string       	$taxonomy       	Taxonomy, if $in_same_term is true. Default 'product_cat'.
		 * @param 	bool         	$previous       	Whether to retrieve previous product. Default false.
		 */
		public function __construct( $in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat', $previous = false ) {
			$this->in_same_term   = $in_same_term;
			$this->excluded_terms = $excluded_terms;
			$this->taxonomy       = $taxonomy;
			$this->previous       = $previous;
		}

		/**
		 * Get adjacent product or circle back to the first/last valid product.
		 *
		 * @return 	WC_Product|false 			Product object if successful. False if no valid product is found.
		 */
		public function get_product() {
			global $post;
			$product = false;
			$this->current_product = $post->ID;

			// Try to get a valid product via `get_adjacent_post()`.
			while ( $adjacent = $this->get_adjacent() ) {
				$product = wc_get_product( $adjacent->ID );

				if ( $product && $product->is_visible() ) {
					break;
				} // End If Statement

				$product               = false;
				$this->current_product = $adjacent->ID;
			} // End of the loop.

			if ( $product ) {
				return $product;
			} // End If Statement

			// No valid product found; Query WC for first/last product.
			$product = $this->query_wc();

			if ( $product ) {
				return $product;
			} // End If Statement

			return false;
		}

		/**
		 * Get adjacent post.
		 *
		 * @return 	WP_POST|false 				Post object if successful. False if no valid post is found.
		 */
		private function get_adjacent() {
			global $post;

			$direction = $this->previous ? 'previous' : 'next';

			add_filter( sprintf( 'get_%s_post_where', $direction ), array( $this, 'filter_post_where' ) );

			$adjacent = get_adjacent_post( $this->in_same_term, $this->excluded_terms, $this->previous, $this->taxonomy );

			remove_filter( sprintf( 'get_%s_post_where', $direction ), array( $this, 'filter_post_where' ) );

			return $adjacent;
		}

		/**
		 * Filters the WHERE clause in the SQL for an adjacent post query, replacing the
		 * date with date of the next post to consider.
		 *
		 * @param 	string 			$where 		The `WHERE` clause in the SQL.
		 * @return 	WP_POST|false 				Post object if successful. False if no valid post is found.
		 */
		public function filter_post_where( $where ) {
			global $post;
			$new = get_post( $this->current_product );
			$where = str_replace( $post->post_date, $new->post_date, $where );

			return $where;
		}

		/**
		 * Query WooCommerce for either the first or last products.
		 *
		 * @return 	WC_Product|false 			Post object if successful. False if no valid post is found.
		 */
		private function query_wc() {
			global $post;
			$args = array(
				'limit'      => 2,
				'visibility' => 'catalog',
				'exclude'    => array( $post->ID ),
				'orderby'    => 'date'
			);

			if ( ! $this->previous ) {
				$args['order'] = 'ASC';
			} // End If Statement

			if ( $this->in_same_term ) {
				$terms = get_the_terms( $post->ID, $this->taxonomy );

				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					$args['category'] = wp_list_pluck( $terms, 'slug' );
				} // End If Statement
			} // End If Statement

			$products = wc_get_products( 
				apply_filters( 
					'hypermarket_wc_adjacent_query_args', $args 
				) 
			);

			// At least 2 results are required, otherwise previous/next will be the same.
			if ( ! empty( $products ) && count( $products ) >= 2 ) {
				return $products[0];
			} // End If Statement

			return false;
		}
	}

endif;