=== WP Caliper ===
Contributors: Andrew Gardener
Tags:  Caliper, BadgeOS, LRS
Requires at least: WordPress 4.9
Tested up to: 5.0.0
Stable tag: 1.0.3
License: GNU AGPLv3
License URI: http://www.gnu.org/licenses/agpl-3.0.html

Adds the ability for WordPress to send Caliper events to a Learning Record Store

== Description ==

Sends Caliper events to LRS (tested against IMS Global Learning Consortium Member Caliper Analytics™
Conformance Test Suite). Some features are ONLY enabled if the dependent plugins have also been installed.
The plugin can be used as a MU plugin as well.

It has been partially tested with:

* [IMS Global Learning Consortium Member Caliper Analytics™ Conformance Test Suite](https://caliper.imsglobal.org/sec/index.html)

Events that will be sent are:

* login and logout
* page views
* post creation and edits
* post status changes
* comment creation and edits
* comment status changes
* attachment creation
* earning badges(1)
* voting and starring (2)

(1) requires

* [BadgeOS](https://wordpress.org/plugins/badgeos/)

(2) Currently only works with PulsePress theme (https://github.com/ubc/pulsepress/) when voting or starring

Requires PHP version >= 5.6 (caliper-php recommends minimum version 5.6)

You must setup the Caliper actor by:
* Setting the `WP_CALIPER_DEFAULT_ACTOR_HOMEPAGE` variable or using the `wp_caliper_actor_homepage` filter.
* Setting the `WP_CALIPER_DEFAULT_ACTOR_IDENTIFIER` variable to load a value from the user meta data or by using the `wp_caliper_actor_identifier` filter.

== Installation ==

1. Put the entire folder into plugins
2. Activate the plugin "WP Caliper" through the "Plugins" menu in WordPress

= EXTRA NOTES FOR MU: =
If you want to install in wp-content/mu-plugins folder, the plugin uses a proxy loader file.

1. copy wp-caliper directory to wp-content/mu-plugins folder
2. copy wp-caliper/wp-caliper-mu-loader.php to the wp-content/mu-plugins folder

== Frequently Asked Questions ==

= How come nothing is being sent to the LRS after I activate the plugin? =
Please make sure to set the Caliper host and api key in the Caliper settings first.

= What is the queue for? =
The queue is used as a fall back if the LRS can't be reached. Events will be stored in the queue
allowing you to later send them from the Caliper settings screen when the LRS is available again.

== Upgrade Notice ==
Nothing yet.

== Changelog ==

= 1.1.0 =
* Updated to Caliper v1p2
* switched to php-caliper dev-develop#c7e34e230abc7bbb647f8f94245cb649f6191bcd for Caliper v1p2 support
* Added Restored resource management event to posts
* Modified PulsePress vote and star events to use the Feedback Profile

= 1.0.3 =
* switched to php-caliper dev-develop#05f5eab0fc7fd14af44a410f0b65aff1d0e02d0a which adds Resource Management Profile support
* modified Created, Modified, Deleted to emit resource management events (instead of basic)

= 1.0.2 =
* Added unit tests
* fixed a few minor issues
* switched to php-caliper dev-develop#b665dfda6f8bb3af2e461a16266b0bc649c9438a to get around warnings

= 1.0.1 =
* Add option to disable local site settings in network settings

= 1.0.0 =
* Initial public release
