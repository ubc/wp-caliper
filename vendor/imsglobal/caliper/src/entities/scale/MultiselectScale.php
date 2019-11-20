<?php

namespace IMSGlobal\Caliper\entities\scale;

use IMSGlobal\Caliper\entities;

class MultiselectScale extends Scale {
    /** @var int[] */
    private $scalePoints = [];
    /** @var string[] */
    private $itemLabels = [];
    /** @var string[] */
    private $itemValues = [];
    /** @var bool */
    private $isOrderedSelection;
    /** @var int */
    private $minSelections;
    /** @var int */
    private $maxSelections;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::MULTISELECT_SCALE));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'scalePoints' => $this->getScalePoints(),
            'itemLabels' => $this->getItemLabels(),
            'itemValues' => $this->getItemValues(),
            'isOrderedSelection' => $this->getIsOrderedSelection(),
            'minSelections' => $this->getMinSelections(),
            'maxSelections' => $this->getMaxSelections()
        ]));
    }

    /** @return int|null scalePoints */
    public function getScalePoints() {
        return $this->scalePoints;
    }

    /**
     * @param int|null $scalePoints
     * @return $this|MultiselectScale
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
     * @return $this|MultiselectScale
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
     * @return $this|MultiselectScale
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

    /** @return bool|null isOrderedSelection */
    public function getIsOrderedSelection() {
        return $this->isOrderedSelection;
    }

    /**
     * @param bool|null $isOrderedSelection
     * @return $this|MultiselectScale
     */
    public function setIsOrderedSelection($isOrderedSelection) {
        if (!is_null($isOrderedSelection) && !is_bool($isOrderedSelection)) {
            throw new \InvalidArgumentException(__METHOD__ . ': bool expected');
        }

        $this->isOrderedSelection = $isOrderedSelection;
        return $this;
    }

    /** @return integer|null minSelections */
    public function getMinSelections() {
        return $this->minSelections;
    }

    /**
     * @param integer|null $minSelections
     * @return $this|MultiselectScale
     */
    public function setMinSelections($minSelections) {
        if (!is_null($minSelections) && !is_integer($minSelections)) {
            throw new \InvalidArgumentException(__METHOD__ . ': integer expected');
        }

        $this->minSelections = $minSelections;
        return $this;
    }

    /** @return integer|null maxSelections */
    public function getMaxSelections() {
        return $this->maxSelections;
    }

    /**
     * @param integer|null $maxSelections
     * @return $this|MultiselectScale
     */
    public function setMaxSelections($maxSelections) {
        if (!is_null($maxSelections) && !is_integer($maxSelections)) {
            throw new \InvalidArgumentException(__METHOD__ . ': integer expected');
        }

        $this->maxSelections = $maxSelections;
        return $this;
    }
}
