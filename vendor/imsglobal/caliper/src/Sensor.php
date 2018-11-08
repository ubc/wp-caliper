<?php
namespace IMSGlobal\Caliper;

use IMSGlobal\Caliper\entities\Entity;
use IMSGlobal\Caliper\events\Event;

class Sensor {
    /** @var Client[] */
    private $clients;
    /** @var string */
    private $id;

    /**
     * @param string $id
     * @throws \RuntimeException if "json" extension is not loaded
     * @throws \InvalidArgumentException _passed along_ if $id is not a string
     */
    public function __construct($id) {
        if (!extension_loaded('json')) {
            throw new \RuntimeException('Caliper requires the PHP "json" extension.');
        }

        $this->setId($id);
    }

    /** @return string id */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this|Sensor
     * @throws \InvalidArgumentException if $id is not a string
     */
    public function setId($id) {
        if (!is_string($id)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->id = $id;
        return $this;
    }

    /**
     * @param string $key
     * @param Client $client
     * @return $this|Sensor
     * @throws \InvalidArgumentException if $key is not a string
     */
    public function registerClient($key, Client $client) {
        if (!is_string($key)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->clients[$key] = $client;
        return $this;
    }

    /**
     * @param string $key
     * @return $this|Sensor
     * @throws \InvalidArgumentException if $key is not a string
     */
    public function unregisterClient($key) {
        if (!is_string($key)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        unset($this->clients[$key]);
        return $this;
    }

    /**
     * Send learning events
     *
     * @param Sensor $sensor
     * @param Event|Event[] $events
     * @throws \InvalidArgumentException if $events doesn't contain Event objects
     * @throws \RuntimeException _passed along_ if HTTP response code is not 200
     */
    public function send(Sensor $sensor, $events) {
        $this->checkClients();

        if (!is_array($events)) {
            $events = [$events];
        }

        foreach ($events as $anEvent) {
            if (!($anEvent instanceof Event)) {
                throw new \InvalidArgumentException(__METHOD__ . ': array of ' . Event::className() . ' expected');
            }
        }

        foreach ($this->clients as $client) {
            $client->send($sensor, $events);
        }
    }

    /**
     * Ensures that some clients are set.
     *
     * @throws \RuntimeException if no clients are registered
     */
    private function checkClients() {
        if ($this->clients == null) {
            throw new \RuntimeException(
                'registerClient() must be called before describe() or send()'
            );
        }
    }

    /**
     * Describe entities
     *
     * @param Sensor $sensor
     * @param Entity|Entity[] $entities
     * @throws \InvalidArgumentException if $events doesn't contain Entity objects
     * @throws \RuntimeException _passed along_ if HTTP response code is not 200
     */
    public function describe(Sensor $sensor, $entities) {
        $this->checkClients();

        if (!is_array($entities)) {
            $entities = [$entities];
        }

        foreach ($entities as $anEntity) {
            if (!($anEntity instanceof Entity)) {
                throw new \InvalidArgumentException(__METHOD__ . ': array of ' . Entity::className() . ' expected');
            }
        }

        foreach ($this->clients as $client) {
            $client->describe($sensor, $entities);
        }
    }
}
