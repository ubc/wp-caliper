<?php

namespace IMSGlobal\Caliper\entities\response;

use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\entities\assignable\Attempt;
use IMSGlobal\Caliper\util;

abstract class Response extends entities\Entity implements entities\Generatable {
    /** @var Attempt */
    private $attempt;
    /** @var \DateTime */
    private $startedAtTime;
    /** @var \DateTime */
    private $endedAtTime;
    /** @var string */
    private $duration;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::RESPONSE));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'attempt' => $this->getAttempt(),
            'startedAtTime' => util\TimestampUtil::formatTimeISO8601MillisUTC($this->getStartedAtTime()),
            'endedAtTime' => util\TimestampUtil::formatTimeISO8601MillisUTC($this->getEndedAtTime()),
            'duration' => $this->getDuration(),
        ]));
    }

    /** @return Attempt attempt */
    public function getAttempt() {
        return $this->attempt;
    }

    /**
     * @param Attempt $attempt
     * @return $this|Response
     */
    public function setAttempt(Attempt $attempt) {
        $this->attempt = $attempt;
        return $this;
    }

    /** @return \DateTime startedAtTime */
    public function getStartedAtTime() {
        return $this->startedAtTime;
    }

    /**
     * @param \DateTime $startedAtTime
     * @return $this|Response
     */
    public function setStartedAtTime(\DateTime $startedAtTime) {
        $this->startedAtTime = $startedAtTime;
        return $this;
    }

    /** @return \DateTime endedAtTime */
    public function getEndedAtTime() {
        return $this->endedAtTime;
    }

    /**
     * @param \DateTime $endedAtTime
     * @return $this|Response
     */
    public function setEndedAtTime(\DateTime $endedAtTime) {
        $this->endedAtTime = $endedAtTime;
        return $this;
    }

    /** @return string|null duration */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * @param string|null $duration (ISO 8601 interval)
     * @throws \InvalidArgumentException ISO 8601 interval string required
     * @return $this|Response
     */
    public function setDuration($duration) {
        if (!is_null($duration)) {
            $duration = strval($duration);

            // TODO: Re-enable after an ISO 8601 compliant interval validator is available.
            // A DateInterval() bug disallows fractions. (https://bugs.php.net/bug.php?id=53831)
            // try {
            //     @$_ = new \DateInterval($duration);
            // } catch (\Exception $exception) {
            //     throw new \InvalidArgumentException(__METHOD__ . ': ISO 8601 interval string expected');
            // }
        }

        $this->duration = $duration;
        return $this;
    }
}
