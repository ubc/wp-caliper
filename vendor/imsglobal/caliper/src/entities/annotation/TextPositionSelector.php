<?php

namespace IMSGlobal\Caliper\entities\annotation;

use IMSGlobal\Caliper\entities\Entity;

/**
 * A Selector which describes a range of text based on its start and end positions
 * Defined by: http://www.w3.org/ns/oa#d4e667
 */
class TextPositionSelector extends Entity implements \JsonSerializable {
    /** @var int */
    private $start;
    /** @var int */
    private $end;

    public function __construct() {
        parent::__construct(''); // TextPositionSelector objects don't need an ID
        $this->setType(new AnnotationType(AnnotationType::TEXT_POSITION_SELECTOR));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return array_merge($serializedParent, [
            'id' => null, // TextPositionSelector objects don't need an ID
            'start' => $this->getStart(),
            'end' => $this->getEnd(),
        ]);
    }

    /** @return int start */
    public function getStart() {
        return $this->start;
    }

    /**
     * @param int $start
     * @return $this|TextPositionSelector
     */
    public function setStart($start) {
        if (!is_int($start)) {
            throw new \InvalidArgumentException(__METHOD__ . ': int expected');
        }

        $this->start = $start;
        return $this;
    }

    /** @return int end */
    public function getEnd() {
        return $this->end;
    }

    /**
     * @param int $end
     * @return $this|TextPositionSelector
     */
    public function setEnd($end) {
        if (!is_int($end)) {
            throw new \InvalidArgumentException(__METHOD__ . ': int expected');
        }

        $this->end = $end;
        return $this;
    }
}
