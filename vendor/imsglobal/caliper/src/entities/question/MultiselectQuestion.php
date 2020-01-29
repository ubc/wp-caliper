<?php

namespace IMSGlobal\Caliper\entities\question;

use IMSGlobal\Caliper\entities;

class MultiselectQuestion extends Question {
    /** @var int */
    private $points = [];
    /** @var string[] */
    private $itemLabels = [];
    /** @var string[] */
    private $itemValues = [];

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::MULTISELECT_QUESTION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'points' => $this->getPoints(),
            'itemLabels' => $this->getItemLabels(),
            'itemValues' => $this->getItemValues(),
        ]));
    }

    /** @return int|null points */
    public function getPoints() {
        return $this->points;
    }

    /**
     * @param int|null $points
     * @return $this|MultiselectQuestion
     */
    public function setPoints($points) {
        if (!is_null($points) && !is_integer($points)) {
            throw new \InvalidArgumentException(__METHOD__ . ': integer expected');
        }

        $this->points = $points;
        return $this;
    }

    /** @return string[]|null itemLabels */
    public function getItemLabels() {
        return $this->itemLabels;
    }

    /**
     * @param string[]|null $itemLabels
     * @return $this|MultiselectQuestion
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
     * @return $this|MultiselectQuestion
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
