<?php

namespace IMSGlobal\Caliper\entities\session;

use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\entities\foaf\Agent;
use IMSGlobal\Caliper\util;

class Session extends entities\Entity implements entities\Generatable, entities\Targetable {
    /** @var Agent|null */
    private $user;
    /** @var \DateTime */
    private $startedAtTime;
    /** @var \DateTime */
    private $endedAtTime;
    /** @var string|null ISO 8601 interval */
    private $duration;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::SESSION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'user' => $this->getUser(),
            'startedAtTime' => util\TimestampUtil::formatTimeISO8601MillisUTC($this->getStartedAtTime()),
            'endedAtTime' => util\TimestampUtil::formatTimeISO8601MillisUTC($this->getEndedAtTime()),
            'duration' => $this->getDuration(),
        ]));
    }

    /** @return Agent|null user */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param Agent|null $user
     * @throws \InvalidArgumentException Agent required
     * @return $this|Session
     */
    public function setUser($user) {
        if (is_null($user) || ($user instanceof Agent)) {
            $this->user = $user;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Agent expected');
    }

    /** @return \DateTime startedAtTime */
    public function getStartedAtTime() {
        return $this->startedAtTime;
    }

    /**
     * @param \DateTime $startedAtTime
     * @return $this|Session
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
     * @return $this|Session
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
     * @return $this|Session
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
