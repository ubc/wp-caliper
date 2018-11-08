<?php

namespace IMSGlobal\Caliper\events;

use IMSGlobal\Caliper\entities\Forum;

class ForumEvent extends Event {
    /** @var Forum */
    private $object;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::FORUM));
    }

    /** @return Forum object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param Forum $object
     * @throws \InvalidArgumentException Forum expected
     * @return $this|ForumEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof Forum)) {
            $this->object = $object;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Forum expected');
    }
}
