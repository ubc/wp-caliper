<?php

namespace IMSGlobal\Caliper\entities\assessment;

use IMSGlobal\Caliper\entities\assignable\AssignableDigitalResource;
use IMSGlobal\Caliper\entities\assignable\AssignableDigitalResourceType;

class AssessmentItem extends AssignableDigitalResource {
    /** @var bool */
    private $isTimeDependent;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new AssignableDigitalResourceType(AssignableDigitalResourceType::ASSESSMENT_ITEM));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return array_merge($serializedParent, [
            'isTimeDependent' => $this->getIsTimeDependent(),
        ]);
    }

    /** @return bool isTimeDependent */
    public function getIsTimeDependent() {
        return $this->isTimeDependent;
    }

    /**
     * @param bool $isTimeDependent
     * @return $this|AssessmentItem
     */
    public function setIsTimeDependent($isTimeDependent) {
        if (!is_bool($isTimeDependent)) {
            throw new \InvalidArgumentException(__METHOD__ . ': bool expected');
        }

        $this->isTimeDependent = $isTimeDependent;
        return $this;
    }
}
