<?php

namespace IMSGlobal\Caliper\events;

use IMSGlobal\Caliper\entities\Message;

class MessageEvent extends Event {
    /** @var Message */
    private $object;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::MESSAGE));
    }

    /** @return Message object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param Message $object
     * @throws \InvalidArgumentException Message expected
     * @return $this|MessageEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof Message)) {
            $this->object = $object;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Message expected');
    }
}
