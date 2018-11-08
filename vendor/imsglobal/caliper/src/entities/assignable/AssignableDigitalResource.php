<?php

namespace IMSGlobal\Caliper\entities\assignable;

use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\DigitalResourceType;
use IMSGlobal\Caliper\util\TimestampUtil;

class AssignableDigitalResource extends DigitalResource implements Assignable {
    /** @var \DateTime */
    private $dateToActivate;
    /** @var \DateTime */
    private $dateToShow;
    /** @var \DateTime */
    private $dateToStartOn;
    /** @var \DateTime */
    private $dateToSubmit;
    /** @var int */
    private $maxAttempts;
    /** @var int */
    private $maxSubmits;
    /** @var float */
    private $maxScore;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new DigitalResourceType(DigitalResourceType::ASSIGNABLE_DIGITAL_RESOURCE));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return array_merge($serializedParent, [
            'dateToActivate' => TimestampUtil::formatTimeISO8601MillisUTC($this->getDateToActivate()),
            'dateToShow' => TimestampUtil::formatTimeISO8601MillisUTC($this->getDateToShow()),
            'dateToStartOn' => TimestampUtil::formatTimeISO8601MillisUTC($this->getDateToStartOn()),
            'dateToSubmit' => TimestampUtil::formatTimeISO8601MillisUTC($this->getDateToSubmit()),
            'maxAttempts' => $this->getMaxAttempts(),
            'maxSubmits' => $this->getMaxSubmits(),
            'maxScore' => $this->getMaxScore(), // Fractionless float prints as int!
        ]);
    }

    /** @return \DateTime dateToActivate */
    public function getDateToActivate() {
        return $this->dateToActivate;
    }

    /**
     * @param \DateTime $dateToActivate
     * @return $this|AssignableDigitalResource
     */
    public function setDateToActivate(\DateTime $dateToActivate) {
        $this->dateToActivate = $dateToActivate;
        return $this;
    }

    /** @return \DateTime dateToShow */
    public function getDateToShow() {
        return $this->dateToShow;
    }

    /**
     * @param \DateTime $dateToShow
     * @return $this|AssignableDigitalResource
     */
    public function setDateToShow(\DateTime $dateToShow) {
        $this->dateToShow = $dateToShow;
        return $this;
    }

    /** @return \DateTime dateToStartOn */
    public function getDateToStartOn() {
        return $this->dateToStartOn;
    }

    /**
     * @param \DateTime $dateToStartOn
     * @return $this|AssignableDigitalResource
     */
    public function setDateToStartOn(\DateTime $dateToStartOn) {
        $this->dateToStartOn = $dateToStartOn;
        return $this;
    }

    /** @return \DateTime dateToSubmit */
    public function getDateToSubmit() {
        return $this->dateToSubmit;
    }

    /**
     * @param \DateTime $dateToSubmit
     * @return $this|AssignableDigitalResource
     */
    public function setDateToSubmit(\DateTime $dateToSubmit) {
        $this->dateToSubmit = $dateToSubmit;
        return $this;
    }

    /** @return int maxAttempts */
    public function getMaxAttempts() {
        return $this->maxAttempts;
    }

    /**
     * @param int $maxAttempts
     * @return $this|AssignableDigitalResource
     */
    public function setMaxAttempts($maxAttempts) {
        if (!is_int($maxAttempts)) {
            throw new \InvalidArgumentException(__METHOD__ . ': int expected');
        }

        $this->maxAttempts = $maxAttempts;
        return $this;
    }

    /** @return int maxSubmits */
    public function getMaxSubmits() {
        return $this->maxSubmits;
    }

    /**
     * @param int $maxSubmits
     * @return $this|AssignableDigitalResource
     */
    public function setMaxSubmits($maxSubmits) {
        if (!is_int($maxSubmits)) {
            throw new \InvalidArgumentException(__METHOD__ . ': int expected');
        }

        $this->maxSubmits = $maxSubmits;
        return $this;
    }

    /** @return float maxScore */
    public function getMaxScore() {
        return $this->maxScore;
    }

    /**
     * @param float $maxScore
     * @return $this|AssignableDigitalResource
     */
    public function setMaxScore($maxScore) {
        if (!is_float($maxScore)) {
            if (is_numeric($maxScore)) {
                $maxScore = floatval($maxScore);
            } else {
                throw new \InvalidArgumentException(__METHOD__ . ': float expected');
            }
        }

        $this->maxScore = $maxScore;
        return $this;
    }
}
