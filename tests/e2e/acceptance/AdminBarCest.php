<?php

class AdminBarCest {
	public function checkIdIsDisplayedInAdminBar( AcceptanceTester $I ) {
		$I->loginAsAdmin();
		$I->amOnPage( '/wp-admin/index.php' );
		$I->see( 'At a Glance' );

		// Post
		// TODO Set permalink structure to `/%postname%/ or find another way to visit frontend pages (now it's too hacky)
		$I->amOnPage( '/' );
		$I->click( 'Hello world!' );

		$I->see( 'One response to' );
		$I->see( 'Hello world!' );
		$I->see( 'ID: 1' );
		$I->wait( 3 );

		// Page
		$I->amOnPage( '/sample-page/' );
		$I->see( 'As a new WordPress user' );
		$I->see( 'ID: 2' );
		$I->wait( 3 );

		// TODO Test all other necessary entities
		// CPT
		// Attachment
	}
}
