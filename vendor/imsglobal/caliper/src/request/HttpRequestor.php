<?php
namespace IMSGlobal\Caliper\request;

use IMSGlobal\Caliper\entities\Entity;
use IMSGlobal\Caliper\events\Event;
use IMSGlobal\Caliper\Options;

class HttpRequestor extends Requestor {
    private $options;

    /**
     * @param \IMSGlobal\Caliper\Options $options
     * @throws \RuntimeException if "http" (AKA pecl_http) or "curl" extensions not loaded
     */
    public function __construct(Options $options) {
        if (!extension_loaded('http') && !extension_loaded('curl')) {
            throw new \RuntimeException('Caliper ' . __CLASS__ . ' requires one of the PHP extensions: "http" (AKA pecl_http) or "curl".');
        }

        $this->setOptions($options);
    }

    /**
     * @param \IMSGlobal\Caliper\Sensor $sensor
     * @param Entity|Event|Entity[]|Event[] $items
     * @throws \InvalidArgumentException if $items doesn't contain Entity or Event objects
     * @throws \RuntimeException if HTTP response code is not 200
     * @return bool success
     */
    public function send(\IMSGlobal\Caliper\Sensor $sensor, $items) {
        $status = false;
        $responseCode = null;
        $responseText = null;

        if (!is_array($items)) {
            $items = [$items];
        }

        foreach ($items as $anItem) {
            if (!(($anItem instanceof Entity) || ($anItem instanceof Event))) {
                throw new \InvalidArgumentException(__METHOD__ .
                    ': array of ' . Entity::className() . ' or ' . Event::className() . ' expected');
            }
        }

        $envelope = $this->createEnvelope($sensor, $items);
        $payload = $this->serializeData($envelope);

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => $this->getOptions()->getApiKey(),
        ];

        if (extension_loaded('http')) {
            $message = new \http\Message();
            $message->getBody()->append($payload);

            $request = new \http\Client\Request(
                'POST',
                $this->getOptions()->getHost(),
                array_merge($headers, ['User-Agent' => 'Caliper (PHP http extension)']),
                $message->getBody()
            );

            $request->setOptions([
                'timeout' => $this->getOptions()->getConnectionTimeout(),
            ]);

            $client = (new \http\Client)->enqueue($request)->send();
            $response = $client->getResponse($request);

            $responseCode = $response->getResponseCode();
            $responseText = $responseCode;
        } elseif (extension_loaded('curl')) {
            $client = curl_init($this->getOptions()->getHost());

            $headerStrings = [];
            foreach ($headers as $headerKey => $headerValue) {
                $headerStrings[] = $headerKey . ': ' . $headerValue;
            }

            curl_setopt_array($client, [
                CURLOPT_POST => true,
                CURLOPT_TIMEOUT_MS => $this->getOptions()->getConnectionTimeout(),
                CURLOPT_HTTPHEADER => $headerStrings,
                CURLOPT_USERAGENT => 'Caliper (PHP curl extension)',
                CURLOPT_HEADER => true, // CURLOPT_HEADER required to return response text
                CURLOPT_RETURNTRANSFER => true, // CURLOPT_RETURNTRANSFER required to return response text
                CURLOPT_POSTFIELDS => $payload,
            ]);

            $responseText = curl_exec($client);
            $responseInfo = curl_getinfo($client);
            curl_close($client);

            if ($responseText) {
                $responseCode = $responseInfo['http_code'];
            } else {
                $responseCode = null;
            }
        }

        if ($responseCode != 200) {
            throw new \RuntimeException('Failure: HTTP error: ' . $responseText);
        } else {
            $status = true;
        }

        return $status;
    }

    /**
     * @param object $data
     * @param Options $options
     * @return string
     */
    public function serializeData($data, Options $options = null) {
        if (is_null($options)) {
            $options = $this->getOptions();
        }

        return parent::serializeData($data, $options);
    }

    /** @return Options */
    public function getOptions() {
        return $this->options;
    }

    /**
     * @param Options $options
     * @return $this|HttpRequestor
     */
    public function setOptions($options) {
        $this->options = $options;
        return $this;
    }
}
