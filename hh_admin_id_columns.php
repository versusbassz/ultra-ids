<?php
/*
Plugin Name: HH sortable ID columns
Plugin URI: https://github.com/versusbassz/sortable-id-columns/
Description: Sortable ID columns for all standard data types in WordPress admin panel.
Version: 3.0.0
Requires PHP: 5.6
Author: Vladimir Sklyar
Author URI: https://versusbassz.com/
*/

add_action('plugins_loaded', 'hhid_start_plugin');

function hhid_start_plugin() {
	require __DIR__ . '/src/Plugin.php';

	add_action('init', [\Versusbassz\IdColumns\Plugin::class, 'init']);
}
