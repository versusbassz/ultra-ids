<?php

namespace Versusbassz\IdColumns\Tests;

use PHPUnit\Framework\TestCase;

use Versusbassz\IdColumns\Utils;

class BaseTest extends TestCase {
	public function testNothing() {
		$this->assertTrue( true );
	}

	/**
	 * @dataProvider dataForTestMapHelper
	 */
	public function testMapHelper( $query_var, $expected ) {
		$result = Utils::map_query_var_to_ids_list( $query_var );

		$this->assertSame( $expected, is_wp_error( $result ) ? $result->get_error_code() : $result );
	}

	public function dataForTestMapHelper(  ) {
		return [
			[ '', [] ],
			[ ' ', [] ],
			[ '1', [1] ],
			[ '2', [2] ],
			[ '2 ', [2] ],
			[ ' 2', [2] ],
			[ ' 2 ', [2] ],
			[ ' 2', [2] ],
			[ '1,2', [1, 2] ],
			[ ' 1,2', [1, 2] ],
			[ '1,2 ', [1, 2] ],
			[ '1, 2', [1, 2] ],
			[ '1 ,2', [1, 2] ],
			[ '1 , 2', [1, 2] ],
			[ ' 1 , 2 ', [1, 2] ],
			[ ' 1 , 2   ,3 ', [1, 2, 3] ],
			[ ' 3 , 1   ,2 ,2 ', [1, 2, 3] ],

			[ ',', 'not_valid' ],
			[ ' , ', 'not_valid' ],
			[ '.', 'not_valid' ],
			[ ' . ', 'not_valid' ],
			[ '-', 'not_valid' ],
			[ ' - ', 'not_valid' ],
			[ ' , 2 ', 'not_valid' ],
			[ ' 1 , 2   ,3, ', 'not_valid' ],
			[ ' ,1 , 2   ,3 ', 'not_valid' ],
			[ ' ,1 , 2  2 ,3 ', 'not_valid' ],
		];
	}
}
