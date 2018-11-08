<?php
namespace IMSGlobal\Caliper;

use IMSGlobal\Caliper\util\JsonInclude;

class Options {
    /** @var string */
    private $host;
    /** @var string */
    private $apiKey;
    /** @var int */
    private $connectionTimeout;
    /** @var int */
    private $socketTimeout;
    /** @var int */
    private $connectionRequestTimeout;
    /** @var JsonInclude */
    private $jsonInclude;
    /** @var int */
    private $jsonEncodeOptions;
    /** @var bool */
    private $debug;

    public function __construct() {
        $this->setHost(Defaults::HOST)
            ->setJsonEncodeOptions(Defaults::JSON_ENCODE_OPTIONS)
            ->setJsonInclude(\IMSGlobal\Caliper\Defaults::JSON_INCLUDE)
            ->setDebug(Defaults::DEBUG)
            ->setConnectionTimeout(Defaults::CONNECTION_TIMEOUT);
    }

    /** @return string host Complete URL for event store server */
    public function getHost() {
        return $this->host;
    }

    /**
     * @param string $host Complete URL for event store server
     * @return $this|Options
     */
    public function setHost($host) {
        if (!is_string($host)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->host = $host;
        return $this;
    }

    /** @return string */
    public function getApiKey() {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     * @return $this|Options
     */
    public function setApiKey($apiKey) {
        if (!is_string($apiKey)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->apiKey = $apiKey;
        return $this;
    }

    /** @return int connectionTimeout timeout in milliseconds */
    public function getConnectionTimeout() {
        return $this->connectionTimeout;
    }

    /**
     * @param int $connectionTimeout timeout in milliseconds
     * @return $this|Options
     */
    public function setConnectionTimeout($connectionTimeout) {
        if (!is_int($connectionTimeout)) {
            throw new \InvalidArgumentException(__METHOD__ . ': int expected');
        }

        $this->connectionTimeout = $connectionTimeout;
        return $this;
    }

    /**
     * Not used in caliper-php, but included to align with caliper-java's API.
     *
     * @return int socketTimeout timeout in milliseconds
     */
    public function getSocketTimeout() {
        return $this->socketTimeout;
    }

    /**
     * Not used in caliper-php, but included to align with caliper-java's API.
     *
     * @param int $socketTimeout timeout in milliseconds
     * @return $this|Options
     */
    public function setSocketTimeout($socketTimeout) {
        if (!is_int($socketTimeout)) {
            throw new \InvalidArgumentException(__METHOD__ . ': int expected');
        }

        $this->socketTimeout = $socketTimeout;
        return $this;
    }

    /**
     * Not used in caliper-php, but included to align with caliper-java's API.
     *
     * @return int connectionRequestTimeout timeout in milliseconds
     */
    public function getConnectionRequestTimeout() {
        return $this->connectionRequestTimeout;
    }

    /**
     * Not used in caliper-php, but included to align with caliper-java's API.
     *
     * @param int $connectionRequestTimeout timeout in milliseconds
     * @return $this|Options
     */
    public function setConnectionRequestTimeout($connectionRequestTimeout) {
        if (!is_int($connectionRequestTimeout)) {
            throw new \InvalidArgumentException(__METHOD__ . ': int expected');
        }

        $this->connectionRequestTimeout = $connectionRequestTimeout;
        return $this;
    }

    /** @return JsonInclude */
    public function getJsonInclude() {
        return $this->jsonInclude;
    }

    /**
     * @param JsonInclude|null $jsonInclude
     * @return $this|Options
     */
    public function setJsonInclude($jsonInclude = null) {
        if (!($jsonInclude instanceof JsonInclude)) {
            $jsonInclude = new JsonInclude($jsonInclude);
        }

        $this->jsonInclude = $jsonInclude;
        return $this;
    }

    /** @return int jsonEncodeOptions */
    public function getJsonEncodeOptions() {
        return $this->jsonEncodeOptions;
    }

    /**
     * Options passed to json_encode().
     * See: http://php.net/manual/en/json.constants.php
     *
     * @param int $jsonEncodeOptions
     * @return $this|Options
     */
    public function setJsonEncodeOptions($jsonEncodeOptions) {
        if (!is_int($jsonEncodeOptions)) {
            throw new \InvalidArgumentException(__METHOD__ . ': int expected');
        }

        $this->jsonEncodeOptions = $jsonEncodeOptions;
        return $this;
    }

    /** @return boolean debug */
    public function isDebug() {
        return $this->debug;
    }

    /**
     * @param boolean $debug
     * @return $this|Options
     */
    public function setDebug($debug) {
        if (!is_bool($debug)) {
            throw new \InvalidArgumentException(__METHOD__ . ': bool expected');
        }

        $this->debug = $debug;
        return $this;
    }
}