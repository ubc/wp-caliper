<?php

namespace IMSGlobal\Caliper\entities\agent;

use IMSGlobal\Caliper\entities;

class SoftwareApplication extends Agent implements entities\foaf\Agent,
    entities\schemadotorg\SoftwareApplication, entities\Targetable {
    /** @var host */
    private $host;
    /** @var ipAddress */
    private $ipAddress;
    /** @var userAgent */
    private $userAgent;
    /** @var string */
    private $version;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::SOFTWARE_APPLICATION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return array_merge($serializedParent, [
            'host' => $this->getHost(),
            'ipAddress' => $this->getIpAddress(),
            'userAgent' => $this->getUserAgent(),
            'version' => $this->getVersion(),
        ]);
    }

    /** @return string host */
    public function getHost() {
        return $this->host;
    }

    /**
     * @param string $host
     * @return $this|SoftwareApplication
     */
    public function setHost($host) {
        if (!is_string($host)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->host = $host;
        return $this;
    }

    /** @return string ipAddress */
    public function getIpAddress() {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     * @return $this|SoftwareApplication
     */
    public function setIpAddress($ipAddress) {
        if (!is_string($ipAddress)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->ipAddress = $ipAddress;
        return $this;
    }

    /** @return string userAgent */
    public function getUserAgent() {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     * @return $this|SoftwareApplication
     */
    public function setUserAgent($userAgent) {
        if (!is_string($userAgent)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->userAgent = $userAgent;
        return $this;
    }

    /** @return string version */
    public function getVersion() {
        return $this->version;
    }

    /**
     * @param string $version
     * @return $this|SoftwareApplication
     */
    public function setVersion($version) {
        if (!is_string($version)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->version = $version;
        return $this;
    }

}
