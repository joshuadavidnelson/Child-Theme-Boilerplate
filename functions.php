<?php
/**
 * Custom Functions for Child Theme Template
 *
 * @package 	 Child_Theme
 * @author       Joshua David Nelson <josh@joshuadnelson.com>
 * @copyright    Copyright (c) 2014, Joshua David Nelson
 * @license      http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @since        1.0.0
 **/

/**
 * Theme Setup
 * @since 1.0.0
 *
 * This setup function attaches all of the site-wide functions 
 * to the correct hooks and filters. All the functions themselves
 * are defined below this setup function.
 *
 * See why this is important: http://justintadlock.com/archives/2010/12/30/wordpress-theme-function-files
 */
add_action( 'after_theme_setup', 'child_theme_setup' );
function child_theme_setup() {
	
	// Child theme (do not remove)
	define( 'CHILD_THEME_DOMAN', 'child-theme-domain' );
	define( 'CHILD_THEME_NAME', __( 'Child Theme', CHILD_THEME_DOMAN ) );
	// define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );
	
	// Setup Theme Settings
	//include_once( get_stylesheet_directory_uri() . '/includes/child-theme-settings.php' );
	
	// Remove "More" Jump
	add_filter( 'the_content_more_link', 'child_remove_more_tag_link_jump' );
	
	// Don't update theme
	add_filter( 'http_request_args', 'child_dont_update_theme', 5, 2 );
	
}

/**
 * Don't Update Theme
 * @since 1.0.0
 *
 * If there is a theme in the repo with the same name, 
 * this prevents WP from prompting an update.
 *
 * @author Mark Jaquith
 * @link http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 *
 * @param array $r, request arguments
 * @param string $url, request url
 * @return array request arguments
 */
function child_dont_update_theme( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request. Bail immediately.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}

/**
 * Remove More Link Jump
 * @since 1.0.0
 * @param string $link
 * @return string $link
 */
function child_remove_more_tag_link_jump( $link ) {
    $offset = strpos($link, '#more-'); //Locate the jump portion of the link
    if ($offset) { //If we found the jump portion of the link
        $end = strpos($link, '"', $offset); //Locate the end of the jump portion
    }
    if ($end) { //If we found the end of the jump portion
        $link = substr_replace($link, '', $offset, $end-$offset); //Remove the jump portion
    }
    return $link; //Return the link without jump portion or just the normal link if we didn't find a jump portion
}

/**
 * Add Metaboxes
 *
 * @since 1.0.1
 * @link https://github.com/WebDevStudios/Custom-Metaboxes-and-Fields-for-WordPress/blob/master/example-functions.php
 **/
//add_action( 'init', 'child_initialize_cmb_meta_boxes', 9999 );
function child_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once ( get_stylesheet_directory_uri() . '/includes/metabox/init.php' );
}
