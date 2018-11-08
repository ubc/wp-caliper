<?php

namespace IMSGlobal\Caliper\entities\reading;

use IMSGlobal\Caliper\entities;

class Frame extends entities\DigitalResource implements entities\Targetable {
    /** @var int */
    private $index;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\DigitalResourceType(entities\DigitalResourceType::FRAME));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return array_merge($serializedParent, [
            'index' => $this->getIndex(),
        ]);
    }

    /** @return int index */
    public function getIndex() {
        return $this->index;
    }

    /**
     * @param int $index
     * @return $this|Frame
     */
    public function setIndex($index) {
        if (!is_int($index)) {
            throw new \InvalidArgumentException(__METHOD__ . ': int expected');
        }

        $this->index = $index;
        return $this;
    }
}
