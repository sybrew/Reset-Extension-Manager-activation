<?php
/**
 * Plugin Name: Reset Extension Manager activation
 * Plugin URI: https://theseoframework.com/
 * Description: Activating this plugin will reset Extension Manager activation data on this site. Network-activate this plugin to reset all sites in the network.
 * Author: Sybre Waaijer
 * Version: 1.0.0
 * Author URI: https://cyberwire.nl/
 */

defined( 'ABSPATH' ) or die;

add_action(
	'admin_init',
	function() {
		new TSFEM_Reset;
	}
);

class TSFEM_Reset {

	private $success = [];

	function __construct() {

		$network_mode = (bool) ( get_site_option( 'active_sitewide_plugins' )[ plugin_basename( __FILE__ ) ] ?? false );

		if ( $network_mode ) {
			$blog_ids = get_sites( [ 'fields' => 'ids' ] );

			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				$this->cleanup();
				restore_current_blog();
			}

		} else {
			$this->cleanup();
		}

		register_deactivation_hook( __FILE__, [ $this, 'register_notices' ] );
		deactivate_plugins( plugin_basename( __FILE__ ), false, $network_mode );
	}

	function cleanup() {
		global $wpdb, $blog_id;

		$this->success[ $blog_id ] = delete_option( 'tsf-extension-manager-settings' );

		$this->success[ $blog_id ] |= $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $wpdb->options WHERE `option_name` LIKE %s",
				$wpdb->esc_like( 'tsfem_i_' ) . '%'
			)
		);
	}

	function register_notices() {
		add_action( 'admin_notices', [ $this, 'output_notices' ] );
	}

	function output_notices() {

		$count = count( array_filter( $this->success ) );

		printf( '<div class="notice updated"><p>%s</p><p>%s</p><p>%s</p></div>',
			$this->success
				? "Successfully reset Extension Manager activation settings on $count site(s)."
				: 'Extension Manager activation settings have already been removed.',
			'"Reset Extension Manager activation" has been deactivated instantly.',
			'You can safely remove plugin <strong>"Reset Extension Manager activation"</strong>.'
		);
	}
}
