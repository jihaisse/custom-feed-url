<?php
/*
Plugin Name: Custom feed url
Plugin URI: https://github.com/jihaisse/custom-feed-url
Description: Customize your feed URL
Author: Jean-Sébastien Mansart
Author URI: http://jihais.se
Version: 0.1
License: GPL2++
*/

// Plugin uninstall: delete option
register_uninstall_hook( __FILE__, 'custom_feed_url_uninstall' );
function custom_feed_url_uninstall() {
	delete_option( 'custom_feed_url' );
}

function my_rss_link($feed){
	$opts = custom_feed_url_get_options();
	if (false === strpos($feed, 'comments')){
		$output = $opts['customFeedUrl'];
	}
	else {
		$output = $feed;
	}
	
	return $output;
}
add_filter('feed_link', 'my_rss_link', 10, 1);

// Add a "Settings" link in the plugins list
add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'custom_feed_url_settings_action_links', 10, 2 );
function custom_feed_url_settings_action_links( $links, $file ) {
	$settings_link = '<a href="' . admin_url( 'options-general.php?page=custom_feed_url_options' ) . '">' . __("Settings") . '</a>';
	array_unshift( $links, $settings_link );

	return $links;
}

//The add_action to add onto the WordPress menu.
add_action('admin_menu', 'custom_feed_url_add_options');
function custom_feed_url_add_options() {
	$page = add_submenu_page( 'options-general.php', 'Custom feed url options', 'Custom feed url', 'manage_options', 'custom_feed_url_options', 'custom_feed_url_options_page' );
	register_setting( 'custom-feed-url', 'custom_feed_url');
}

// Settings page
function custom_feed_url_options_page() {
	$opts = custom_feed_url_get_options();
	?>
	<form id="custom-feed-url-form" method="post" action="options.php">
		<?php settings_fields('custom-feed-url'); ?>
		<p>
			<label for="customFeedUrl">Your custom feed url :</label>
			<input id="customFeedUrl" type="text" name="custom_feed_url[customFeedUrl]" class="regular-text" value="<?php echo $opts['customFeedUrl']; ?>" />
		</p>
		<?php submit_button(null, 'primary', '_submit'); ?>
	</form>
	<?php
}

// Retrieve and sanitize options
function custom_feed_url_get_options() {
	$options = get_option( 'custom_feed_url' );
	return custom_feed_url_sanitize_options($options);
}

// Sanitize options
function custom_feed_url_sanitize_options($options) {
	$new = array();

	if ( !is_array($options) )
	return $new;

	if ( isset($options['customFeedUrl']) )
	$new['customFeedUrl'] = $options['customFeedUrl'];
	
	return $new;
}
?>