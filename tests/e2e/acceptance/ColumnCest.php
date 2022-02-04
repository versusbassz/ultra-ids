<?php

class ColumnCest {
	public function checkColumnsWork( AcceptanceTester $I ) {
		$I->loginAsAdmin();
		$I->amOnPage( '/wp-admin/index.php' );
		$I->see( 'At a Glance' );

		$th_selector = '#hh_id';
		$td_selector = 'td.hh_id';

		// Posts
		$I->amOnPage( '/wp-admin/edit.php' );
		$I->see( 'ID', $th_selector );
		$I->see( '1', $td_selector );

		// Categories
		$I->amOnPage( '/wp-admin/edit-tags.php?taxonomy=category' );
		$I->see( 'ID', $th_selector );
		$I->see( '1', $td_selector );

		// Media
		$I->amOnPage( '/wp-admin/upload.php?mode=list' );
		$I->see( 'ID', $th_selector );
		// TODO upload a file and check a td value

		// Pages
		$I->amOnPage( '/wp-admin/edit.php?post_type=page' );
		$I->see( 'ID', $th_selector );
		$I->see( '2', $td_selector );

		// Links
		$I->amOnPage( '/wp-admin/link-manager.php' );
		$I->see( 'ID', $th_selector );
		// TODO create a link and check a td value

		// Comments
		$I->amOnPage( '/wp-admin/edit-comments.php' );
		$I->see( 'ID', $th_selector );
		$I->see( '1', $td_selector );

		// Users
		$I->amOnPage( '/wp-admin/users.php' );
		$I->see( 'ID', $th_selector );
		$I->see( '1', $td_selector );

		// Multisite Blogs
		$I->amOnPage( '/wp-admin/network/sites.php' );
		$I->see( 'ID', $th_selector );
		$I->see( '1', $td_selector );

		// Multisite Users
		$I->amOnPage( '/wp-admin/network/users.php' );
		$I->see( 'ID', $th_selector );
		$I->see( '1', $td_selector );
	}
}
