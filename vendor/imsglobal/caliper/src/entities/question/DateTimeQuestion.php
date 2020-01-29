<?php

namespace IMSGlobal\Caliper\entities\question;

use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\util\TimestampUtil;

class DateTimeQuestion extends Question {
    /** @var \DateTime */
    private $minDateTime;
    /** @var string */
    private $minLabel;
    /** @var \DateTime */
    private $maxDateTime;
    /** @var string */
    private $maxLabel;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::DATE_TIME_QUESTION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'minDateTime' => TimestampUtil::formatTimeISO8601MillisUTC($this->getMinDateTime()),
            'minLabel' => $this->getMinLabel(),
            'maxDateTime' => TimestampUtil::formatTimeISO8601MillisUTC($this->getMaxDateTime()),
            'maxLabel' => $this->getMaxLabel()
        ]));
    }

    /** @return \DateTime|null minDateTime */
    public function getMinDateTime() {
        return $this->minDateTime;
    }

    /**
     * @param \DateTime|null $minDateTime
     * @return $this|DateTimeQuestion
     */
    public function setMinDateTime(\DateTime $minDateTime) {
        $this->minDateTime = $minDateTime;
        return $this;
    }

    /** @return string|null minLabel */
    public function getMinLabel() {
        return $this->minLabel;
    }

    /**
     * @param string|null $minLabel
     * @return $this|DateTimeQuestion
     */
    public function setMinLabel($minLabel) {
        if (!is_null($minLabel) && !is_string($minLabel)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->minLabel = strval($minLabel);
        return $this;
    }

    /** @return \DateTime|null minDateTime */
    public function getMaxDateTime() {
        return $this->maxDateTime;
    }

    /**
     * @param \DateTime|null $maxDateTime
     * @return $this|DateTimeQuestion
     */
    public function setMaxDateTime(\DateTime $maxDateTime) {
        $this->maxDateTime = $maxDateTime;
        return $this;
    }

    /** @return string|null maxLabel */
    public function getMaxLabel() {
        return $this->maxLabel;
    }

    /**
     * @param string|null $maxLabel
     * @return $this|DateTimeQuestion
     */
    public function setMaxLabel($maxLabel) {
        if (!is_null($maxLabel) && !is_string($maxLabel)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->maxLabel = strval($maxLabel);
        return $this;
    }
}
