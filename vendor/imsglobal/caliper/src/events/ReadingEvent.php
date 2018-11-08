<?php

namespace IMSGlobal\Caliper\events;

use IMSGlobal\Caliper\entities\DigitalResource;

/**
 * Class ReadingEvent
 *
 * @deprecated 1.2
 * @package IMSGlobal\Caliper\events
 */
class ReadingEvent extends Event {
    /** @var DigitalResource */
    private $object;

    /**
     * ReadingEvent constructor.
     *
     * @deprecated 1.2
     */
    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::READING));
    }

    /** @return DigitalResource object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param DigitalResource $object
     * @throws \InvalidArgumentException DigitalResource expected
     * @return $this|ReadingEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof DigitalResource)) {
            $this->object = $object;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': DigitalResource expected');
    }
}
