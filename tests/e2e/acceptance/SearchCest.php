<?php

class SearchCest {
	public function checkSearchingWorks( AcceptanceTester $I ) {
		$I->loginAsAdmin();
		$I->amOnPage( '/wp-admin/index.php' );
		$I->see( 'At a Glance' );

		$input = '.ultid-search--input';
		$td_selector = 'td.hh_id';
		$all_link = '.all a.current'; // It's the link "All" in the top-left corner of the table. It's to check that the page was reloaded.

		// Posts
		$I->amOnPage( '/wp-admin/edit.php' );
		$I->seeElement( $input );
		$I->see( '1', $td_selector );
		$I->see( 'Hello world!' );

		// search for a non-existing post
		$I->fillField( $input, '333' );
		$I->click( '#post-query-submit' );

//		$I->wait( 2 );
		$I->dontSeeElement( $all_link );
		$I->seeElement( $input, [ 'value' => '333' ] );

		$I->dontSee( '1', $td_selector );

		// search for "Hello world" post
		$I->fillField( $input, 1 );
		$I->click( '#post-query-submit' );

		$I->dontSeeElement( $all_link );
		$I->seeElement( $input, [ 'value' => '1' ] );

		$I->see( '1', $td_selector );
		$I->see( 'Hello world!' );

		// TODO Pages
		//

		// TODO CPT
		//
	}
}
