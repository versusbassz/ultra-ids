<?php
/*
Plugin Name: Ultra IDs
Plugin URI: https://github.com/versusbassz/ultra-ids/
Description: Sortable ID columns for all standard data types in WordPress admin panel.
Version: 4.0.0-alpha
Requires PHP: 7.4
Author: Vladimir Sklyar
Author URI: https://versusbassz.com/
*/

add_action('plugins_loaded', 'hhid_start_plugin');

function hhid_start_plugin() {
	require_once __DIR__ . '/src/Utils.php';

	require_once __DIR__ . '/src/Feature/Column.php';
	require_once __DIR__ . '/src/Feature/Search.php';
	require_once __DIR__ . '/src/Feature/AdminBar.php';

	add_action('init', [\Versusbassz\UltraIds\Feature\Column::class, 'init']);
	add_action('init', [\Versusbassz\UltraIds\Feature\Search::class, 'init']);
	add_action('init', [\Versusbassz\UltraIds\Feature\AdminBar::class, 'init']);
}
