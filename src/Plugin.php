<?php

namespace Versusbassz\IdColumns;

class Plugin {
	const COLUMN_ID = 'hh_id';

	public static function init() {
		if ( is_admin() ) {
			add_action( 'admin_init', [ __CLASS__, 'register_columns' ] );
			add_action( 'admin_head', [ __CLASS__, 'add_css' ] );
		}
	}

	public static function register_columns() {
		add_filter( 'manage_media_columns', [ __CLASS__, 'add_column' ] );
		add_action( 'manage_media_custom_column', [ __CLASS__, 'echo_value' ], 10, 2 );

		add_filter( 'manage_link-manager_columns', [ __CLASS__, 'add_column' ] );
		add_action( 'manage_link_custom_column', [ __CLASS__, 'echo_value' ], 10, 2 );

		add_action( 'manage_edit-link-categories_columns', [ __CLASS__, 'add_column' ] );
		add_filter( 'manage_link_categories_custom_column', [ __CLASS__, 'return_value' ], 10, 3 );

		foreach ( get_taxonomies() as $taxonomy ) {
			add_action( "manage_edit-{$taxonomy}_columns", [ __CLASS__, 'add_column' ] );
			add_filter( "manage_{$taxonomy}_custom_column", [ __CLASS__, 'return_value' ], 10, 3 );
			add_filter( "manage_edit-{$taxonomy}_sortable_columns", [ __CLASS__, 'add_column' ] );
		}

		foreach ( get_post_types() as $ptype ) {
			add_action( "manage_edit-{$ptype}_columns", [ __CLASS__, 'add_column' ] );
			add_filter( "manage_{$ptype}_posts_custom_column", [ __CLASS__, 'echo_value' ], 10, 3 );
			add_filter( "manage_edit-{$ptype}_sortable_columns", [ __CLASS__, 'add_column' ] );
		}

		add_action( 'manage_users_columns', [ __CLASS__, 'add_column' ] );
		add_filter( 'manage_users_custom_column', [ __CLASS__, 'return_value' ], 10, 3 );
		add_filter( 'manage_users_sortable_columns', [ __CLASS__, 'add_column' ] );

		/**
		 * Multisite Users
		 *
		 * @see \WP_MS_Users_List_Table
		 */
		add_filter( 'wpmu_users_columns', [ __CLASS__, 'add_column' ] );

		/**
		 * Comments
		 */
		add_action( 'manage_edit-comments_columns', [ __CLASS__, 'add_column' ] );
		add_action( 'manage_comments_custom_column', [ __CLASS__, 'echo_value' ], 10, 2 );
		add_filter( 'manage_edit-comments_sortable_columns', [ __CLASS__, 'add_column' ] );

		/**
		 * Multisite Sites
		 */
		add_action( 'manage_sites-network_columns', [ __CLASS__, 'add_column' ] );
		add_filter( 'manage_sites_custom_column', [ __CLASS__, 'echo_value' ], 100, 2 );
	}

	public static function add_css() {
		// 6 chars
		echo PHP_EOL . '<style type="text/css"> table.widefat th.column-hh_id { width: 65px; } </style>' . PHP_EOL;
	}

	public static function add_column( $columns ) {
		$column_id = [ self::COLUMN_ID => __( 'ID' ) ];

		$columns = array_merge(
			array_slice( $columns, 0, 1, true ),
			$column_id,
			array_slice( $columns, 1, null, true )
		);

		return $columns;
	}

	public static function echo_value( $column_name, $id ) {
		if ( $column_name === self::COLUMN_ID ) {
			echo $id;
		}
	}

	public static function return_value( $value, $column_name, $id ) {
		if ( $column_name === self::COLUMN_ID ) {
			$value .= $id;
		}

		return $value;
	}
}
