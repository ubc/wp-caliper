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
    private static $options = null;

    public static function setOptions($host, $apiKey) {
        self::$options = (new Options())
            ->setApiKey("Bearer $apiKey")
            ->setHost($host);
    }

    private static function getOptions() {
        return self::$options;
    }

    private static function getSensor() {
        $sensor = new Sensor(ResourceIRI::wordPress());
        $sensor->registerClient(
            'default_client', new Client('remote_lrs', self::getOptions())
        );
        return $sensor;
    }

    public static function caliperEnabled() {
        $options = self::getOptions();
        return $options !== NULL && is_string($options->getHost()) && is_string($options->getApiKey());
    }

    public static function sendEvent(Event &$event, \WP_User &$user) {
        if (!self::caliperEnabled()) {
            return false;
        }
        CaliperEvent::addDefaults($event, $user);

        $requestor = new HttpRequestor(self::getOptions());
        $envelope = $requestor->createEnvelope(self::getSensor(), $event);
        $eventJson = $requestor->serializeData($envelope);

        $success = self::_sendEvent($eventJson);
        if ( ! $success ) {
            $blog_id = function_exists( 'get_current_blog_id' ) ? get_current_blog_id() : NULL;
            WP_Caliper::wp_caliper_add_queue( $eventJson, $blog_id );
        }
        return $success;
    }

    public static function _sendEvent($eventJson) {
        if (!is_string($eventJson)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }
        if (!self::caliperEnabled()) {
            return false;
        }

        // Requires curl extension
        // based off of https://github.com/IMSGlobal/caliper-php/blob/master/src/request/HttpRequestor.php#L75
        $client = curl_init(self::getOptions()->getHost());
        $headers = [
            'Content-Type: application/json',
            'Authorization: ' .self::getOptions()->getApiKey()
        ];
        curl_setopt_array($client, [
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT_MS => self::getOptions()->getConnectionTimeout(),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_USERAGENT => 'Caliper (PHP curl extension)',
            CURLOPT_HEADER => true, // CURLOPT_HEADER required to return response text
            CURLOPT_RETURNTRANSFER => true, // CURLOPT_RETURNTRANSFER required to return response text
            CURLOPT_POSTFIELDS => $eventJson,
        ]);

        $responseText = curl_exec($client);
        $responseInfo = curl_getinfo($client);
        curl_close($client);

        $responseCode = $responseText ? $responseInfo['http_code'] : null;
        if ($responseCode != 200) {
            error_log( '[wp-caliper] Failed to emit Caliper event: '. print_r( $eventJson, true ) );
            return false;
        }
        return true;
    }
}
