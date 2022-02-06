<?php

namespace Versusbassz\UltraIds\Feature;

use wp_admin_bar;

/**
 * Display ID of a current entity in WP Admin Bar
 */
class AdminBar {
	public static function init() {
		if ( ! is_user_logged_in() ) {
			return;
		}

		add_action( 'admin_bar_menu', [__CLASS__, 'add_node'], 999, 1 );
	}

	/**
	 * Adds ID to the WP Admin bar
	 *
	 * @param $wp_admin_bar wp_admin_bar
	 *
	 * @return null|void
	 *
	 * @see \wp_admin_bar_search_menu() As an example. The way how it works is a bit hacky...
     * @see \WP_Admin_Bar::_render_item() The place where the magic happens
	 */
	public static function add_node( $wp_admin_bar ) {
		if ( is_admin() || ! is_singular() ) {
			return;
		}

		$queried_object = get_queried_object();

		$wp_admin_bar->add_node( [
			'id' => 'hh_post_id',
			'title' => '<div><span style="user-select: none;">ID: </span>' . esc_html( $queried_object->ID ) . '</div>',
			'href' => '', // it's required to be empty
		] );
	}
}
