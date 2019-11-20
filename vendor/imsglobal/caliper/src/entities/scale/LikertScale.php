<?php

namespace IMSGlobal\Caliper\entities\scale;

use IMSGlobal\Caliper\entities;

class LikertScale extends Scale {
    /** @var int */
    private $scalePoints;
    /** @var string[] */
    private $itemLabels = [];
    /** @var string[] */
    private $itemValues = [];

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::LIKERT_SCALE));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'scalePoints' => $this->getScalePoints(),
            'itemLabels' => $this->getItemLabels(),
            'itemValues' => $this->getItemValues()
        ]));
    }

    /** @return int|null scalePoints */
    public function getScalePoints() {
        return $this->scalePoints;
    }

    /**
     * @param int|null $scalePoints
     * @return $this|LikertScale
     */
    public function setScalePoints($scalePoints) {
        if (!is_null($scalePoints) && !is_integer($scalePoints)) {
            throw new \InvalidArgumentException(__METHOD__ . ': integer expected');
        }

        $this->scalePoints = $scalePoints;
        return $this;
    }

    /** @return string[]|null itemLabels */
    public function getItemLabels() {
        return $this->itemLabels;
    }

    /**
     * @param string[]|null $itemLabels
     * @return $this|LikertScale
     */
    public function setItemLabels($itemLabels) {
        if (!is_null($itemLabels)) {
            if (!is_array($itemLabels)) {
                $itemLabels = [$itemLabels];
            }

            foreach ($itemLabels as $itemLabel) {
                if (!is_string($itemLabel)) {
                    throw new \InvalidArgumentException(__METHOD__ . ': array of string expected');
                }
            }
        }

        $this->itemLabels = $itemLabels;
        return $this;
    }

    /** @return string[]|null itemValues */
    public function getItemValues() {
        return $this->itemValues;
    }

    /**
     * @param string[]|null $itemValues
     * @return $this|LikertScale
     */
    public function setItemValues($itemValues) {
        if (!is_null($itemValues)) {
            if (!is_array($itemValues)) {
                $itemValues = [$itemValues];
            }

            foreach ($itemValues as $itemValue) {
                if (!is_string($itemValue)) {
                    throw new \InvalidArgumentException(__METHOD__ . ': array of string expected');
                }
            }
        }

        $this->itemValues = $itemValues;
        return $this;
    }
}
