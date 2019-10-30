<?php
namespace WPCaliperPlugin\caliper;

use WPCaliperPlugin\WP_Caliper;
use WPCaliperPlugin\caliper\ResourceIRI;
use WPCaliperPlugin\caliper\CaliperEvent;

use IMSGlobal\Caliper\Options;
use IMSGlobal\Caliper\Sensor;
use IMSGlobal\Caliper\events\Event;
use IMSGlobal\Caliper\Client;
use IMSGlobal\Caliper\util\TimestampUtil;

use IMSGlobal\Caliper\request\HttpRequestor;

class CaliperSensor {
	private static $options     = null;
	private static $send_events = true; // allows disabling for unit tests.
	private static $temp_store  = array();

	public static function setSendEvents( $send_events ) {
		self::$send_events = $send_events;
	}

	public static function getEnvelopes() {
		$envelopes        = self::$temp_store;
		self::$temp_store = array();
		return $envelopes;
	}

	public static function setOptions( $host, $api_key ) {
		self::$options = ( new Options() )
			->setApiKey( "Bearer $api_key" )
			->setHost( $host );
	}

	private static function getOptions() {
		return self::$options;
	}

	private static function getSensor() {
		$sensor = new Sensor( ResourceIRI::wordPress() );
		$sensor->registerClient(
			'default_client', new Client( 'remote_lrs', self::getOptions() )
		);
		return $sensor;
	}

	public static function caliperEnabled() {
		$options = self::getOptions();
		return $options !== null && is_string( $options->getHost() ) && is_string( $options->getApiKey() );
	}

	public static function sendEvent( Event &$event, \WP_User $user ) {
		if ( ! self::caliperEnabled() ) {
			return false;
		}
		CaliperEvent::addDefaults( $event, $user );

		$requestor  = new HttpRequestor( self::getOptions() );
		$envelope   = $requestor->createEnvelope( self::getSensor(), $event );
		$event_json = $requestor->serializeData( $envelope );

		$success = self::_sendEvent( $event_json );
		if ( ! $success ) {
			$blog_id = function_exists( 'get_current_blog_id' ) ? get_current_blog_id() : null;
			WP_Caliper::wp_caliper_add_queue( $event_json, $blog_id );
		}
		return $success;
	}

	public static function _sendEvent( $event_json ) {
		if ( ! is_string( $event_json ) ) {
			throw new \InvalidArgumentException( __METHOD__ . ': string expected' );
		}
		if ( ! self::caliperEnabled() ) {
			return false;
		}

		// used for unit tests.
		if ( ! self::$send_events ) {
			self::$temp_store[] = $event_json;
			return true;
		}

		/*
		 * Requires curl extension
		 * based off of https://github.com/IMSGlobal/caliper-php/blob/master/src/request/HttpRequestor.php#L75
		 */
		$client  = curl_init( self::getOptions()->getHost() );
		$headers = [
			'Content-Type: application/json',
			'Authorization: ' .self::getOptions()->getApiKey(),
		];
		curl_setopt_array(
			$client,
			array(
				CURLOPT_POST           => true,
				CURLOPT_TIMEOUT_MS     => self::getOptions()->getConnectionTimeout(),
				CURLOPT_HTTPHEADER     => $headers,
				CURLOPT_USERAGENT      => 'Caliper ( PHP curl extension )',
				CURLOPT_HEADER         => true, // CURLOPT_HEADER required to return response text.
				CURLOPT_RETURNTRANSFER => true, // CURLOPT_RETURNTRANSFER required to return response text.
				CURLOPT_POSTFIELDS     => $event_json,
			)
		);

		$response_text = curl_exec( $client );
		$response_info = curl_getinfo( $client );
		curl_close( $client );

		$response_code = $response_text ? $response_info['http_code'] : null;
		if ( 200 !== $response_code ) {
			error_log( '[wp-caliper] Failed to emit Caliper event: '. print_r( $event_json, true ) );
			return false;
		}
		return true;
	}
}
