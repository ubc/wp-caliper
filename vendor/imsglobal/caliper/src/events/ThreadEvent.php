<?php

namespace IMSGlobal\Caliper\events;

use IMSGlobal\Caliper\entities\Thread;

class ThreadEvent extends Event {
    /** @var Thread */
    private $object;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::THREAD));
    }

    /** @return Thread object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param Thread $object
     * @throws \InvalidArgumentException Thread expected
     * @return $this|ThreadEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof Thread)) {
            $this->object = $object;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Thread expected');
    }
}
