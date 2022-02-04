<?php

namespace Versusbassz\IdColumns;

use \WP_Error;

class Utils {
	/**
	 * Maps a string like "1 ,2, 2, 3" to an array of integers.
	 * The example: "1 ,2, 2, 3" -> [1, 2, 3]
	 *
	 * @param string $query_var
	 *
	 * @return int[]|WP_Error
	 */
	public static function map_query_var_to_ids_list( $query_var ) {
		if ( ! is_string( $query_var ) ) {
			return new WP_Error( 'not_string' );
		}

		if ( $query_var === '' || preg_match( '/^(\s)+$/', $query_var ) ) {
			return [];
		}

		$query_var_t = trim( $query_var );

		// syntax: single int
		if ( is_numeric( $query_var_t ) ) {
			return [ absint( $query_var_t ) ];
		}

		// syntax: comma-separated list of integers
		$raw_items = explode( ',', $query_var_t );

		$possible_items = [];

		foreach ( $raw_items as $raw_item ) {
			$item = trim( $raw_item );

			if ( ! is_numeric( $item ) ) {
				return new WP_Error( 'not_valid' );
			}

			$possible_items[] = absint( trim( $item ) );
		}

		sort( $possible_items, SORT_NUMERIC );

		return array_values( array_unique( $possible_items ) );
	}
}
