<?php

class MiscCest
{
	public function _before( AcceptanceTester $I ) {
	}

	public function checkFrontendWorks( AcceptanceTester $I ) {
		$I->amOnPage( '/' );
		$I->see( 'Welcome to WordPress' );
	}

	public function checkDashboardWorks( AcceptanceTester $I ) {
		$I->loginAsAdmin();
		$I->amOnPage( '/wp-admin/index.php' );
		$I->see( 'At a Glance' );;
	}
}
