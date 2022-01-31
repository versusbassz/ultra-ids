<?php

/**
 * Multisite loading:
 * @see wp-settings.php
 * @see wp-includes/ms-settings.php
 * @see ms_load_current_site_and_network()
 * @see is_multisite()
 *
 * about URLs
 * @see wp_plugin_directory_constants()
 * @see home_url()
 * @see get_theme_root_uri()
 * @see get_option()
 *
 * - define SUNRISE constant in wp-config.php
 * - check env var of test container
 * - get current blog with id=1
 * - replace all necessary vars from wp-includes/ms-settings.php
 * - copy sunrise.php to the result wp-content
 */

/**
 * @see wp-config.php (for the source of these globals)
 */
global $is_test_env, $do_rewrite_of_domain, $dev_env_test_domain;

// We do the changes in sunrise.php only for the domain of e2e-test, i.e. "test.{dev-env-domain}"
if ( ! $is_test_env || ! $do_rewrite_of_domain ) {
	return;
}

// Rewrite global constants
//define( 'WP_HOME', 'http://' . $dev_env_test_domain );
//define( 'WP_SITEURL', 'http://' . $dev_env_test_domain );
define( 'WP_CONTENT_URL', 'http://' . $dev_env_test_domain . '/wp-content' );

// Rewtite global Multisite variables
global $current_site, $current_blog, $domain, $path, $site_id, $public;

$current_site = \WP_Network::get_instance( 1 );
$current_blog = \WP_Site::get_instance( 1 );

$current_site->domain = $dev_env_test_domain;
$current_blog->domain = $dev_env_test_domain;

$domain = $current_blog->domain;
$path = $current_blog->path;

$blog_id = $current_blog->blog_id;
$public  = $current_blog->public;

$site_id = $current_blog->site_id;

// Rewrite home and siteurl options
add_filter( 'pre_option_home', 'hhid_change_test_options', 10, 3 );
add_filter( 'pre_option_siteurl', 'hhid_change_test_options', 10, 3 );

function hhid_change_test_options( $value, $option, $default ) {
	global $dev_env_test_domain;

	return 'http://' . $dev_env_test_domain;
}
