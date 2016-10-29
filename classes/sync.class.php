<?php
/**
 * Class Pods_Multisite_Sync
 */

! defined( 'PODS_MULTISITE_DIR' ) and die();

class Pods_Multisite_Sync {

	/**
	 * @var Pods_Multisite_Sync
	 */
	private static $instance;

	/**
	 * @return Pods_Multisite_Sync
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Pods_Multisite_Sync constructor.
	 */
	function __construct() {
		// @todo Non ajax method
		add_action( 'pods_admin_ajax_success_save_pod', array( $this, 'sync_pod' ) );

		add_filter( 'pods_admin_setup_edit_tabs', array( $this, 'pod_settings_tab' ) );
		add_filter( 'pods_admin_setup_edit_options', array( $this, 'pod_settings_options' ) );
	}

	/**
	 * @param $pod (optional) a Pod
	 */
	function sync_pod( $pod ) {

		$api = pods_api();
		$pod = $api->load_pod( $pod );

		if ( empty( $pod['options']['multisite_sync_to_sites'] ) || ! is_array( $pod['options']['multisite_sync_to_sites'] ) ) {
			return;
		}

		unset( $pod['id'] );
		foreach ( $pod['fields'] as $name => $field ) {
			unset( $pod['fields'][ $name ]['id'] );
		}

		$pod_name = $pod['name'];
		if ( isset( $pod['options']['old_name'] ) ) {
			$pod_name = $pod['options']['old_name'];
		}

		$site_id = get_current_blog_id();

		foreach( $pod['options']['multisite_sync_to_sites'] as $site ) {

			// Do not run sync if it's the current site + validate site value to a number (site id)
			if ( ! is_numeric( $site ) || $site_id == (int) $site ) {
				continue;
			}

			switch_to_blog( (int) $site );

			$remote_pod = $api->load_pod( $pod_name, false );
			$store_pod = $pod;

			/*if ( false === $remote_pod ) {
				$add_pod = array(
					'name' => $store_pod['name']
				);
				$api->add_pod( $store_pod );
			}*/

			if ( false !== $remote_pod ) {
				$store_pod['id'] = $remote_pod['id'];
				foreach ( $remote_pod['fields'] as $name => $field ) {
					if ( isset( $store_pod['fields'][ $name ] ) ) {
						$store_pod['fields'][ $name ]['id'] = $field['id'];
					}
				}
			}

			//wp_send_json( array( 'pod' => $pod, 'store_pod' => $store_pod, 'remote_pod' => $remote_pod ) );

			$api->save_pod( $store_pod );
		}

		restore_current_blog();
	}


	/**
	 * The multisite option tab.
	 *
	 * @since  0.1
	 * @param  array $tabs
	 * @return array
	 */
	public function pod_settings_tab( $tabs ) {
		$tabs[ 'pods-multisite' ] = __( 'Multisite', 'pods-multisite' );
		return $tabs;
	}

	/**
	 * The mutisite options
	 *
	 * @since  0.1
	 * @param  array $options
	 * @return array
	 */
	public function pod_settings_options( $options ) {

		$options[ 'pods-multisite' ] = array(
			'multisite_sync_to_sites' => array(
				'label' => __( 'Sync this Pod with other sites', 'pods-multisite' ),
				'help' => __( 'This overwrites the the remote Pod data', 'pods-multisite' ),
				'description' => __( 'Sync is not bi-directional by default. If you want to sync both ways you need to check the current site as well', 'pods-multisite' ),
				'type' => 'pick',
				'default' => '',
				'pick_object' => 'site',
				'pick_format_type' => 'multi'
			),
		);

		return $options;

	}
}