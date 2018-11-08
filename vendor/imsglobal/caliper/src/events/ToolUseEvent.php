<?php

namespace IMSGlobal\Caliper\events;

use IMSGlobal\Caliper\entities\agent\SoftwareApplication;

class ToolUseEvent extends Event {
    /** @var SoftwareApplication */
    private $object;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::TOOL_USE));
    }

    /** @return SoftwareApplication object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param SoftwareApplication $object
     * @throws \InvalidArgumentException SoftwareApplication expected
     * @return $this|ToolUseEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof SoftwareApplication)) {
            $this->object = $object;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': SoftwareApplication expected');
    }
}
