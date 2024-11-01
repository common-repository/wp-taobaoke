<?php
/*
Plugin Name: WP-TaoBaoKe
Plugin URI: http://www.sohao.net/wp-taobaoke
Description: wp-taobaoke enables you shows taobaoke promotion products and stores from taobao.com.
Version: 1.3
Author: Simon Fan
Author URI: http://www.sohao.net/
*/
if( !defined('WP_CONTENT_DIR') )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );

$wp_tbk_functions = WP_CONTENT_DIR . '/plugins/wp-taobaoke/taobaoke-library.php';

require_once($wp_tbk_functions);

### Function: TaoBaoKe Option Menu
add_action('admin_menu', 'taobaoke_menu');
function taobaoke_menu() {
	if (function_exists('add_options_page')) {
		add_options_page(__('TaoBaoKe', 'wp-taobaoke'), __('TaoBaoKe', 'wp-taobaoke'), 'manage_options', 'wp-taobaoke/taobaoke-options.php') ;
	}
}

### Create Text Domain For Translations
add_action('init', 'taobaoke_textdomain');
function taobaoke_textdomain() {
	load_plugin_textdomain('wp-taobaoke', false, 'wp-taobaoke/lang');
}

### Function: Enqueue TaoBaoKe Stylesheets
add_action('wp_print_styles', 'taobaoke_stylesheets');
function taobaoke_stylesheets() {
	if(@file_exists(TEMPLATEPATH.'/taobaoke-css.css')) {
		wp_enqueue_style('wp-taobaoke', get_stylesheet_directory_uri().'/taobaoke-css.css', false, '2.50', 'all');
	} else {
		wp_enqueue_style('wp-taobaoke', plugins_url('wp-taobaoke/taobaoke-css.css'), false, '2.50', 'all');
	}	
}

function wp_taobaoke() {
    // print some HTML for the widget to display here.
    tbk_show();
}
//add_action('widgets_init', 'wp_taobaoke');
register_sidebar_widget("wp-taobaoke", "wp_taobaoke");


/*
 * This example will work at least on WordPress 2.6.3, 
 * but maybe on older versions too.
 */

add_action('admin_init', 'taobaoke_admin_init');
function taobaoke_admin_init()
{
    /* Register our script. */
    //wp_enqueue_script('jquery', '/wp-includes/js/jquery/jquery.js');
    //wp_enqueue_script('jquery');
}

add_shortcode('taobaoke', 'tbk_show');

### Function: Post Views Options
add_action('activate_wp-taobaoke/wp-taobaoke.php', 'taobaoke_init');
function taobaoke_init() {

	taobaoke_textdomain();

	// Add Options
	$taobaoke_options = array();
	$taobaoke_options['pid'] = 'mm_11098708_0_0';
	$taobaoke_options['category'] = 0;
	$taobaoke_options['commission_rate_start'] = 0;
	$taobaoke_options['commission_rate_end'] = 100;
	$taobaoke_options['commission_start'] = 0;
	$taobaoke_options['commission_end'] = 0;
	$taobaoke_options['commission_num_start'] = 0;
	$taobaoke_options['commission_num_end'] = 0;
	$taobaoke_options['credit_start'] = 0;
	$taobaoke_options['credit_end'] = 0;
	$taobaoke_options['product_price_start'] = 0;
	$taobaoke_options['product_price_end'] = 0;
	$taobaoke_options['area'] = 0;

	add_option('taobaoke_options', $taobaoke_options);
}
?>
