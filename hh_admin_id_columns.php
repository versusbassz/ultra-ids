<?php
/*
Plugin Name: HH sortable ID columns
Plugin URI: https://github.com/versusbassz/sortable-id-columns/
Description: Sortable ID columns for all standard data types in WordPress admin panel.
Version: 4.0.0-alpha
Requires PHP: 5.6
Author: Vladimir Sklyar
Author URI: https://versusbassz.com/
*/

add_action('plugins_loaded', 'hhid_start_plugin');

function hhid_start_plugin() {
	require_once __DIR__ . '/src/Utils.php';

	require_once __DIR__ . '/src/Feature/Column.php';
	require_once __DIR__ . '/src/Feature/Search.php';

	add_action('init', [\Versusbassz\IdColumns\Feature\Column::class, 'init']);
	add_action('init', [\Versusbassz\IdColumns\Feature\Search::class, 'init']);
}
