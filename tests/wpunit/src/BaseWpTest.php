<?php

namespace Versusbassz\UltraIds\Tests;

class BaseWpTest extends \WP_UnitTestCase {
	public function testNothing() {
		self::factory()->post->create_many( 20 );

		$posts = get_posts( [
			'nopaging' => true,
		] );
		$this->assertCount( 20, $posts );
	}

	public function testIsPluginLoaded() {
		$this->assertTrue( function_exists( 'hhid_start_plugin' ) );

		// hhid_start_plugin() call loads all classes of the plugin
		$this->assertTrue( class_exists( '\\Versusbassz\\UltraIds\\Feature\\Column' ) );
	}
}
