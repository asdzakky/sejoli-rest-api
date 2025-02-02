<?php
namespace Sejoli_Rest_Api;

/**
 * Main class responsible for rest api functions
 * @since   1.0.0
 */
class Rest {

	/**
	 * The main rest route of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private static $rest_route;

	/**
	 * Initialize the class and set its properties.
	 * @since    1.0.0
	 */
	public function __construct() {

		self::$rest_route = 'sejoli-api/v1';
		
	}

	/**
	 * Get main route for this plugin
	 * @since    1.0.0
	 * @return    string
	 */
	public static function get_main_route() {

		return self::$rest_route;

	}

	/**
	 * Register rest routes
	 * @param 	$routes array of routes to register
	 * @since    1.0.0
	 */
	public static function register_routes( $routes ) {

		foreach ( $routes as $key => $route ) {

			$store_route = register_rest_route( self::get_main_route(), $route['endpoint'], array(
				'methods'				=> $route['methods'],
				'callback'				=> $route['callback'],
				'permission_callback' 	=> $route['permission_callback'],
			));
		}

	}

	/**
	 * respond error
	 * @param 	$type string
	 * @since    1.0.0
	 * @return   WP_Error
	 */
	public static function respond_error( $type = NULL, $message = NULL ) {

		if( $type == 'unauthorized' ) {

			return new \WP_REST_Response(
				array(
					'status'  => false,
					'code'    => 401,
					'message' => 'invalid-auth - Forbidden Access',
					'data'	  => array()
				)
			);

		} elseif( $type == 'forbidden' ) {

			return new \WP_REST_Response(
				array(
					'status'  => false,
					'code'    => 403,
					'message' => 'invalid-access - Forbidden Access',
					'data'	  => array()
				)
			);
		} elseif( $type == 'invalid-response' ) {

			return new \WP_REST_Response(
				array(
					'status'  => false,
					'code'    => 403,
					'message' => $message,
					'data'	  => array()
				)
			);
		} else {

			return new \WP_REST_Response(
				array(
					'status'  => false,
					'code'    => 404,
					'message' => 'invalid-data - Data not found',
					'data'	  => array()
				)
			);

		}

	}

	/**
	 * respond success
	 * @since    1.0.0
	 * @return   WP_REST_Response
	 */
	public static function respond_success( $status = null, $body = null, $message = null, $code = 200 ) {

		return new \WP_REST_Response(
			array(
				'status'  => $status,
				'code'    => $code,
				'message' => $message,
				'data'	  => $body
			)
		);

	}

}
