<?php

namespace IMSGlobal\Caliper\events;

use IMSGlobal\Caliper\entities\assessment\AssessmentItem;

class AssessmentItemEvent extends Event {
    /** @var AssessmentItem */
    private $object;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::ASSESSMENT_ITEM));
    }

    /** @return AssessmentItem object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param AssessmentItem $object
     * @throws \InvalidArgumentException AssessmentItem expected
     * @return $this|AssessmentItemEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof AssessmentItem)) {
            $this->object = $object;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': AssessmentItem expected');
    }
}
