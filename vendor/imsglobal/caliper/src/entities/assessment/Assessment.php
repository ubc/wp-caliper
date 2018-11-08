<?php

namespace IMSGlobal\Caliper\entities\assessment;

use IMSGlobal\Caliper\entities\assignable\AssignableDigitalResource;
use IMSGlobal\Caliper\entities\assignable\AssignableDigitalResourceType;

class Assessment extends AssignableDigitalResource {
    /** @var  AssessmentItem[]|null */
    private $items = [];

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new AssignableDigitalResourceType(AssignableDigitalResourceType::ASSESSMENT));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'items' => $this->getItems(),
        ]));
    }

    /** @return AssessmentItem[]|null */
    public function getItems() {
        return $this->items;
    }

    /**
     * @param AssessmentItem|AssessmentItem[]|null $items
     * @return $this|Assessment
     */
    public function setItems($items) {
        if (!is_null($items)) {
            if (!is_array($items)) $items = [$items];

            foreach ($items as $item)
                if (!($item instanceof AssessmentItem))
                    // FIXME: After PHP 5.5 is a requirement, change "IMSGlobal\Caliper\entities\foaf\Agent" string to "::class".
                    throw new \InvalidArgumentException(__METHOD__ . ': array of \IMSGlobal\Caliper\entities\assessment\AssessmentItem expected');
        }

        $this->items = $items;
        return $this;
    }
}
