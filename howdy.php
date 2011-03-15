<?php
/*
Plugin Name: DirtySuds - Kill Howdy
Plugin URI: http://dirtysuds.com
Description: Changes 'Howdy' to something else
Author: Pat Hawks
Version: 1.01
Author URI: http://www.pathawks.com

Updates:
1.01 - Moved Greetings to greetings.txt
1.00 - First Version

  Copyright 2011 Pat Hawks  (email : pat@pathawks.com)

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

add_filter('admin_user_info_links', 'dirtysuds_howdy');
add_filter('plugin_row_meta', 'dirtysuds_howdy_rate',10,2);


function dirtysuds_howdy( $links ) {

	$greeting = file_get_contents(WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'/greetings.txt' );
	$greeting = explode("\n", $greeting);
	$greeting = wptexturize( $greeting[ mt_rand(0, count($greeting) - 1) ] );

	$links[5] = str_replace('Howdy,',$greeting,$links[5]);
	return $links;
}

function dirtysuds_howdy_rate($links,$file) {
		if (plugin_basename(__FILE__) == $file) {
			$links[] = '<a href="http://wordpress.org/extend/plugins/dirtysuds-kill-howdy/">Rate this plugin</a>';
		}
	return $links;
}