<?php

namespace IMSGlobal\Caliper\events;

use IMSGlobal\Caliper\entities\assignable\AssignableDigitalResource;

class AssignableEvent extends Event {
    /** @var AssignableDigitalResource */
    private $object;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::ASSIGNABLE));
    }

    /** @return AssignableDigitalResource object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param AssignableDigitalResource $object
     * @throws \InvalidArgumentException AssignableDigitalResource expected
     * @return $this|AssignableEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof AssignableDigitalResource)) {
            $this->object = $object;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': AssignableDigitalResource expected');
    }

}
