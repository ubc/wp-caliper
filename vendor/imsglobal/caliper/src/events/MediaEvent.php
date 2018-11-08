<?php

namespace IMSGlobal\Caliper\events;

use IMSGlobal\Caliper\entities\media\MediaObject;

class MediaEvent extends Event {
    /** @var MediaObject */
    private $object;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::MEDIA));
    }

    /** @return MediaObject object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param MediaObject $object
     * @throws \InvalidArgumentException MediaObject expected
     * @return $this|MediaEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof MediaObject)) {
            $this->object = $object;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': MediaObject expected');
    }
}
