<?php

namespace Versusbassz\UltraIds\Feature;

use Versusbassz\UltraIds\Utils;
use WP_Query;

/**
 * "Searching by ID" functionality of the plugin
 */
class Search {
	const QUERY_VAR = 'hh_sid';

	public static function init() {
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_footer', [ __CLASS__, 'render_css' ], 1 );

		/**
		 * The "Posts" related logic
		 *
		 * @see /wp-admin/edit.php
		 * @see \WP_Posts_List_Table
		 * @see \WP_Query
		 */
		add_filter( 'query_vars', [ __CLASS__, 'register_query_var' ], 10, 1 );
		add_action( 'pre_get_posts', [__CLASS__, 'pre_get_posts'], 10, 1 );
		add_action( 'restrict_manage_posts', [ __CLASS__, 'render_post_input' ], 10, 2 );

		/**
		 * The "Users" related logic
		 *
		 * @see /wp-admin/users.php
		 * @see \WP_Users_List_Table
		 * @see \WP_User_Query
		 */
		add_filter( 'users_list_table_query_args', [ __CLASS__, 'filter_users_query' ], 10, 1 );
		add_action( 'restrict_manage_users', [ __CLASS__, 'render_user_input' ], 10, 1 );
	}

	/**
	 * The docs of "query_vars" filter:
	 *
	 * Filters the query variables allowed before processing.
	 *
	 * Allows (publicly allowed) query vars to be added, removed, or changed prior
	 * to executing the query. Needed to allow custom rewrite rules using your own arguments
	 * to work, or any other custom query variables you want to be publicly available.
	 *
	 * @param string[] $query_vars The array of allowed query variable names.
	 *
	 * @return string[]
	 */
	public static function register_query_var( $query_vars = [] ) {
		$query_vars[] = self::QUERY_VAR;

		return $query_vars;
	}

	/**
	 * The docs of "pre_get_posts" action:
	 *
	 * Fires after the query variable object is created, but before the actual query is run.
	 *
	 * Note: If using conditional tags, use the method versions within the passed instance
	 * (e.g. $this->is_main_query() instead of is_main_query()). This is because the functions
	 * like is_main_query() test against the global $wp_query instance, not the passed one.
	 *
	 * @param WP_Query $query The WP_Query instance (passed by reference).
	 *
	 * @return void
	 */
	public static function pre_get_posts( $query ) {
		global $pagenow;

		if ( ! is_admin() || ! $query->is_main_query() || $pagenow !== 'edit.php' ) {
			return;
		}

		$query_var = get_query_var( self::QUERY_VAR );

		if ( ! $query_var ) {
			return;
		}

		$post__in = Utils::map_query_var_to_ids_list( $query_var );

		if ( is_wp_error( $post__in ) ) {
			// TODO maybe it could be helpful to display an admin notice in such a case ???
			return;
		}

		if ( ! count( $post__in ) ) {
			return;
		}

		$post__in_old = $query->get( 'post__in' );
		$query->set( 'post__in', array_merge( $post__in_old, $post__in ) );
	}

	/**
	 * The docs for "restrict_manage_posts" action:
	 *
	 * Fires before the Filter button on the Posts and Pages list tables.
	 *
	 * The Filter button allows sorting by date and/or category on the
	 * Posts list table, and sorting by date on the Pages list table.
	 *
	 * @param string $post_type The post type slug.
	 * @param string $which     The location of the extra table nav markup:
	 *                          'top' or 'bottom' for WP_Posts_List_Table,
	 *                          'bar' for WP_Media_List_Table.
	 *
	 * @return void
	 */
	public static function render_post_input( $post_type, string $which ) {
		if ( $which !== 'top' ) {
			return;
		}

		self::render_input();
	}

	/**
	 * The docs for "users_list_table_query_args" filter:
	 *
	 * Filters the query arguments used to retrieve users for the current users list table.
	 *
	 * @param array $args Arguments passed to WP_User_Query to retrieve items for the current
	 *                    users list table.
	 *
	 * @return array
	 */
	public static function filter_users_query( $args ) {
		$query_var = $_GET[ self::QUERY_VAR ] ?? '';

		if ( ! $query_var ) {
			return $args;
		}

		$include = Utils::map_query_var_to_ids_list( $query_var );

		if ( is_wp_error( $include ) ) {
			// TODO maybe it could be helpful to display an admin notice in such a case ???
			return;
		}

		if ( ! count( $include ) ) {
			return;
		}

		$args['include'] = $include;

		return $args;
	}

	/**
	 * The docs for "restrict_manage_users" filter:
	 *
	 * Fires just before the closing div containing the bulk role-change controls
	 * in the Users list table.
	 *
	 * @param string $which The location of the extra table nav markup: 'top' or 'bottom'.
	 *
	 * @return void
	 */
	public static function render_user_input( $which ) {
		if ( $which !== 'top' ) {
			return;
		}

		self::render_input();
	}

	/**
	 * Renders the "Search by ID" input.
	 * It has the specific wrappers for each entity.
	 *
	 * @return void
	 */
	public static function render_input() {
		$value = isset( $_GET[ self::QUERY_VAR ] ) && $_GET[ self::QUERY_VAR ] ? $_GET[ self::QUERY_VAR ] : '';
		?>

		<span class="ultid-search--prefix">id:</span>
		<input
			type="text"
			name="<?= esc_attr( self::QUERY_VAR ) ?>"
			value="<?= esc_attr( $value ) ?>"
			class="ultid-search--input"
		/>

		<?php
	}

	/**
	 * Renders the css styles of the layout elements related to the Search functionality
	 *
	 * @return void
	 */
	public static function render_css() {
		?>

		<style type="text/css">
			.ultid-search--prefix {
				display: inline-block;
				margin-left: 5px;
			}

			.ultid-search--input {
				max-width: 170px;
			}
		</style>

		<?php
	}
}
