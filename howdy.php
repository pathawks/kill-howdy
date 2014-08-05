<?php
/*
Plugin Name: Kill Howdy
Plugin URI: https://github.com/pathawks/kill-howdy
Description: Changes 'Howdy' to something else
Author: Pat Hawks
Author URI: http://pathawks.com
License: GPL2
Version: 1.02

  Copyright 2014 Pat Hawks  (email : pat@pathawks.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_filter( 'gettext', 'dirtysuds_howdy', 10, 3 );
add_filter( 'plugin_row_meta', 'dirtysuds_howdy_rate', 10, 2 );

function dirtysuds_howdy( $translated_text, $untranslated_text, $domain ) {
	if ( $untranslated_text === 'Howdy, %1$s' ) {

		if ( $dirtysuds_howdy_text = get_transient( 'dirtysuds_howdy' ) )
			return $dirtysuds_howdy_text;

		$greeting = file_get_contents( plugin_dir_path(__FILE__) .'greetings.txt' );
		$greeting = explode("\n", $greeting);

		srand( crc32( date( 'dmo' ) ) ); // Let's set the random greeting based on todays date, for a new greeting every day
		$greeting = wptexturize( $greeting[ rand(0, count($greeting) - 1) ] );
		srand();

		if ( strpos( $greeting, '%1$s' ) !== false ) {
			set_transient( 'dirtysuds_howdy_rate', $greeting, 3600 );
			return $greeting;
		} else {
			set_transient( 'dirtysuds_howdy_rate', $greeting.' %1$s', 3600 );
			return $greeting.' %1$s';
		}

	}

	return $translated_text;
}

function dirtysuds_howdy_rate($links,$file) {
		if (plugin_basename(__FILE__) == $file) {
			$links[] = '<a href="http://wordpress.org/extend/plugins/dirtysuds-kill-howdy/">Rate this plugin</a>';
		}
	return $links;
}
