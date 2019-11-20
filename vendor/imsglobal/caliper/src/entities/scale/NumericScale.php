<?php

namespace IMSGlobal\Caliper\entities\scale;

use IMSGlobal\Caliper\entities;

class NumericScale extends Scale {
    /** @var float */
    private $minValue;
    /** @var string */
    private $minLabel;
    /** @var float */
    private $maxValue;
    /** @var string */
    private $maxLabel;
    /** @var float */
    private $step;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::NUMERIC_SCALE));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'minValue' => $this->getMinValue(),
            'minLabel' => $this->getMinLabel(),
            'maxValue' => $this->getMaxValue(),
            'maxLabel' => $this->getMaxLabel(),
            'step' => $this->getStep()
        ]));
    }

    /** @return float|null minValue */
    public function getMinValue() {
        return $this->minValue;
    }

    /**
     * @param float|null $minValue
     * @return $this|NumericScale
     */
    public function setMinValue($minValue) {
        if (!is_null($minValue)) {
            if (is_numeric($minValue)) {
                $minValue = floatval($minValue);
            }

            if (!is_float($minValue)) {
                throw new \InvalidArgumentException(__METHOD__ . ': float expected');
            }
        }

        $this->minValue = $minValue;
        return $this;
    }

    /** @return string|null minLabel */
    public function getMinLabel() {
        return $this->minLabel;
    }

    /**
     * @param string|null $minLabel
     * @return $this|NumericScale
     */
    public function setMinLabel($minLabel) {
        if (!is_null($minLabel) && !is_string($minLabel)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->minLabel = $minLabel;
        return $this;
    }

    /** @return float|null maxValue */
    public function getMaxValue() {
        return $this->maxValue;
    }

    /**
     * @param float|null $maxValue
     * @return $this|NumericScale
     */
    public function setMaxValue($maxValue) {
        if (!is_null($maxValue)) {
            if (is_numeric($maxValue)) {
                $maxValue = floatval($maxValue);
            }

            if (!is_float($maxValue)) {
                throw new \InvalidArgumentException(__METHOD__ . ': float expected');
            }
        }

        $this->maxValue = $maxValue;
        return $this;
    }

    /** @return string|null maxLabel */
    public function getMaxLabel() {
        return $this->maxLabel;
    }

    /**
     * @param string|null $maxLabel
     * @return $this|NumericScale
     */
    public function setMaxLabel($maxLabel) {
        if (!is_null($maxLabel) && !is_string($maxLabel)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->maxLabel = $maxLabel;
        return $this;
    }

    /** @return float|null step */
    public function getStep() {
        return $this->step;
    }

    /**
     * @param float|null $step
     * @return $this|NumericScale
     */
    public function setStep($step) {
        if (!is_null($step)) {
            if (is_numeric($step)) {
                $step = floatval($step);
            }

            if (!is_float($step)) {
                throw new \InvalidArgumentException(__METHOD__ . ': float expected');
            }
        }

        $this->step = $step;
        return $this;
    }
}
