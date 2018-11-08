<?php

namespace IMSGlobal\Caliper\events;

use IMSGlobal\Caliper\entities\assessment\Assessment;

class AssessmentEvent extends Event {
    /** @var Assessment */
    private $object;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::ASSESSMENT));
    }

    /** @return Assessment object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param Assessment $object
     * @throws \InvalidArgumentException Assessment expected
     * @return $this|AssessmentEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof Assessment)) {
            $this->object = $object;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Assessment expected');
    }
}
