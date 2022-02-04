<?php

class MiscCest {
	public function checkFrontendWorks( AcceptanceTester $I ) {
		$I->amOnPage( '/' );

		// Theme: Twenty Twenty-Two
		$I->see( 'Hello world!' ); // default post title
		$I->see( 'Proudly powered by WordPress' ); // footer text
	}
}
