=== HH sortable ID columns ===
Contributors: versusbassz
Tags: sortable, id, column, admin, panel
Requires at least: 5.7
Tested up to: 5.9
Stable tag: 3.0.0
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Sortable ID columns for all standard data types in WordPress admin panel.

== Description ==

Sortable ID columns for all standard data types in WordPress admin panel.
No settings pages. It just works.
ID columns will be first in admin panel tables.

Supported entities:
* posts, pages, attachments, any custom post types
* category, term, any custom taxonomies
* users (including Multisite users)
* comments
* links (the legacy WP feature)
* blogs (aka "sites") in Multisite Admin panel

= Links =
<a href="https://github.com/versusbassz/sortable-id-columns/" target="_blank">Github repo</a>

== Frequently Asked Questions ==

= How to change the width of the column? =

Here is the example of PHP-code that can be pasted (for example in functions.php of your theme, or as a tiny plugin/mu-plugin).
The current default value is `65px`;
```
add_action( 'admin_head', function () {
	echo PHP_EOL . '<style type="text/css">table.widefat th.column-hh_id { width: 80px !important; } </style>' . PHP_EOL;
} );
```

== Changelog ==

= 3.0.0 --- 2022.01.31 =
* Add the "ID" column for Multisite Blogs and Multisite Users
* Update "Tested up to" header: 5.5 -> 5.9
* Update "Requires at least" header: 4.9 -> 5.7
* Rework the content of readme.txt file
* Refactor the codebase of the plugin
* Add automated end-to-end tests for the output of the plugin

= 2.1.0 --- 2021.07.07 =
* Increase width of the "ID" column: 50px -> 65px , so now it can display 6 chars without a line break (#1)
* Add the link to the Github repository of the plugin to readme.txt
* Change "Tested up to" header: 5.5 -> 5.7
* Update "Requires PHP" header: 5.3 -> 5.6
* Update "Plugin URI" and "Author URI" links in the entry PHP file

= 2.0.3 --- 2020.11.21 =
* Checked compatibility with WordPress <= 5.5

= 2.0.2 --- 2017.03.16 =
* Fix PHP 5.3 compatibility

= 2.0.1 --- 2017.02.24 =
* Fix plugin meta and "Changelog" tab in readme.txt

= 2.0.0 --- 2017.02.24 =
* Code style changes
* Change "Tested up to" meta-field to "4.7.2"
* Change "Requires at least" meta-field to "4.6"
* Change "Plugin URI" meta-field
* Change "Author URI" meta-field
* Remove unnecessary code
* Change column insert algorithm
* Add "Differences from "Reveal IDs" plugin" section in readme.txt
* Add "Plugins with same functionality" section in readme.txt

= 1.0.0 --- 2013.04.30 =
* Initial release.
