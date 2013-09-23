<?php
/*
Plugin Name: indieAuth Links
Plugin URI: http://jihais.se
Description: Add links tag to your blog to enable indieAuth
Author: Jean-Sébastien Mansart
Author URI: http://jihais.se
Version: 0.1
License: GPL2++
*/

// Plugin uninstall: delete option
register_uninstall_hook( __FILE__, 'indieauth_links_uninstall' );
function indieauth_links_uninstall() {
	delete_option( 'indieauth_links' );
}

// Add a "Settings" link in the plugins list
add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'indieauth_links_settings_action_links', 10, 2 );
function indieauth_links_settings_action_links( $links, $file ) {
	$settings_link = '<a href="' . admin_url( 'options-general.php?page=indieauth_links_options' ) . '">' . __("Settings") . '</a>';
	array_unshift( $links, $settings_link );

	return $links;
}

//The add_action to add onto the WordPress menu.
add_action('admin_menu', 'indieauth_links_add_options');
function indieauth_links_add_options() {
	$page = add_submenu_page( 'options-general.php', 'indieAuth Links options', 'indieAuth Links', 'manage_options', 'indieauth_links_options', 'indieauth_links_options_page' );
	register_setting( 'indieauth-links', 'indieauth_links');
}

// Settings page
function indieauth_links_options_page() {
	$opts = indieauth_links_get_options();
	?>
	<form id="indieauth-links-form" method="post" action="options.php">
		<?php settings_fields('indieauth-links'); ?>
		<p>
			<label for="customFeedUrl">GitHub :</label>
			<input id="customFeedUrl" type="text" name="indieauth_links[github]" class="regular-text" value="<?php echo $opts['github']; ?>" />
		</p>
		<p>
			<label for="customFeedUrl">Google :</label>
			<input id="customFeedUrl" type="text" name="indieauth_links[google]" class="regular-text" value="<?php echo $opts['google']; ?>" />
		</p>
		<p>
			<label for="customFeedUrl">App.net :</label>
			<input id="customFeedUrl" type="text" name="indieauth_links[appnet]" class="regular-text" value="<?php echo $opts['appnet']; ?>" />
		</p>
		<p>
			<label for="customFeedUrl">Geoloqi :</label>
			<input id="customFeedUrl" type="text" name="indieauth_links[geoloqi]" class="regular-text" value="<?php echo $opts['geoloqi']; ?>" />
		</p>
		<p>
			<label for="customFeedUrl">Twitter :</label>
			<input id="customFeedUrl" type="text" name="indieauth_links[twitter]" class="regular-text" value="<?php echo $opts['twitter']; ?>" />
		</p>
		<?php submit_button(null, 'primary', '_submit'); ?>
	</form>
	<?php
}

// Retrieve and sanitize options
function indieauth_links_get_options() {
	$options = get_option( 'indieauth_links' );
	return indieauth_links_sanitize_options($options);
}

// Sanitize options
function indieauth_links_sanitize_options($options) {
	$new = array();

	if ( !is_array($options) )
	return $new;

	if ( isset($options['github']) )
	$new['github'] = $options['github'];
	
	if ( isset($options['google']) )
	$new['google'] = $options['google'];
	
	if ( isset($options['appnet']) )
	$new['appnet'] = $options['appnet'];
	
	if ( isset($options['geoloqi']) )
	$new['geoloqi'] = $options['geoloqi'];
	
	if ( isset($options['twitter']) )
	$new['twitter'] = $options['twitter'];
	
	return $new;
}
?>