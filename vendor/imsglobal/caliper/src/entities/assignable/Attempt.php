<?php

namespace IMSGlobal\Caliper\entities\assignable;

use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\foaf\Agent;
use IMSGlobal\Caliper\util\TimestampUtil;

class Attempt extends entities\Entity implements entities\Generatable {
    /** @var DigitalResource|null */
    private $assignable;
    /** @var Agent|null */
    private $assignee;
    /** @var Attempt|null */
    private $isPartOf;
    /** @var int|null */
    private $count;
    /** @var \DateTime */
    private $startedAtTime;
    /** @var \DateTime */
    private $endedAtTime;
    /** @var string|null ISO 8601 interval */
    private $duration;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::ATTEMPT));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'assignable' => $this->getAssignable(),
            'assignee' => $this->getAssignee(),
            'isPartOf' => $this->getIsPartOf(),
            'count' => $this->getCount(),
            'startedAtTime' => TimestampUtil::formatTimeISO8601MillisUTC($this->getStartedAtTime()),
            'endedAtTime' => TimestampUtil::formatTimeISO8601MillisUTC($this->getEndedAtTime()),
            'duration' => $this->getDuration(),
        ]));
    }

    /** @return DigitalResource assignable */
    public function getAssignable() {
        return $this->assignable;
    }

    /**
     * @param DigitalResource|null $assignable
     * @throws \InvalidArgumentException DigitalResource required
     * @return $this|Attempt
     */
    public function setAssignable($assignable) {
        if (is_null($assignable) || ($assignable instanceof DigitalResource)) {
            $this->assignable = $assignable;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': DigitalResource expected');
    }

    /** @return Agent assignee */
    public function getAssignee() {
        return $this->assignee;
    }

    /**
     * @param Agent|null $assignee
     * @throws \InvalidArgumentException Agent required
     * @return $this|Attempt
     */
    public function setAssignee($assignee) {
        if (is_null($assignee) || ($assignee instanceof Agent)) {
            $this->assignee = $assignee;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Agent expected');
    }

    /** @return Attempt|null */
    public function getIsPartOf() {
        return $this->isPartOf;
    }

    /**
     * @param Attempt|null $isPartOf
     * @throws \InvalidArgumentException Attempt required
     * @return $this|Attempt
     */
    public function setIsPartOf($isPartOf) {
        if (is_null($isPartOf) || ($isPartOf instanceof Attempt)) {
            $this->isPartOf = $isPartOf;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Attempt expected');
    }

    /** @return int count */
    public function getCount() {
        return $this->count;
    }

    /**
     * @param int|null $count
     * @throws \InvalidArgumentException int required
     * @return $this|Attempt
     */
    public function setCount($count) {
        if (is_null($count) || is_int($count)) {
            $this->count = $count;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': int expected');
    }

    /** @return \DateTime startedAtTime */
    public function getStartedAtTime() {
        return $this->startedAtTime;
    }

    /**
     * @param \DateTime $startedAtTime
     * @return $this|Attempt
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
     * @return $this|Attempt
     */
    public function setEndedAtTime(\DateTime $endedAtTime) {
        $this->endedAtTime = $endedAtTime;
        return $this;
    }

    /** @return string|null duration (ISO 8601 interval) */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * @param string|null $duration (ISO 8601 interval)
     * @throws \InvalidArgumentException ISO 8601 interval string required
     * @return $this|Attempt
     */
    public function setDuration($duration) {
        if (!is_null($duration)) {
            $duration = strval($duration);

            // TODO: Re-enable after an ISO 8601 compliant interval validator is available.
            // A DateInterval() bug disallows fractions. (https://bugs.php.net/bug.php?id=53831)
            // try {
            //     $_ = new \DateInterval($duration);
            // } catch (\Exception $exception) {
            //     throw new \InvalidArgumentException(__METHOD__ . ': ISO 8601 interval string expected');
            // }
        }

        $this->duration = $duration;
        return $this;
    }
}
