<?php

namespace IMSGlobal\Caliper\entities\survey;

use IMSGlobal\Caliper\entities\Entity;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\util\TimestampUtil;

class SurveyInvitation extends Entity {
    /** @var Person|null */
    private $rater;
    /** @var Survey|null */
    private $survey;
    /** @var int|null */
    private $sentCount;
    /** @var \DateTime|null */
    private $dateSent;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::SURVEY_INVITATION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'rater' => $this->getRater(),
            'survey' => $this->getSurvey(),
            'sentCount' => $this->getSentCount(),
            'dateSent' =>  TimestampUtil::formatTimeISO8601MillisUTC($this->getDateSent())
        ]));
    }

    /** @return Person|null */
    public function getRater() {
        return $this->rater;
    }

    /**
     * @param Person|null $rater
     * @return SurveyInvitation
     */
    public function setRater(Person $rater) {
        $this->rater = $rater;
        return $this;
    }

    /** @return Survey|null */
    public function getSurvey() {
        return $this->survey;
    }

    /**
     * @param Survey|null $survey
     * @return SurveyInvitation
     */
    public function setSurvey(Survey $survey) {
        $this->survey = $survey;
        return $this;
    }

    /** @return int|null */
    public function getSentCount() {
        return $this->sentCount;
    }

    /**
     * @param int|null $sentCount
     * @return SurveyInvitation
     */
    public function setSentCount($sentCount) {
        if (!is_null($sentCount) && !is_integer($sentCount)) {
            throw new \InvalidArgumentException(__METHOD__ . ': integer expected');
        }

        $this->sentCount = $sentCount;
        return $this;
    }

    /** @return \DateTime|null */
    public function getDateSent() {
        return $this->dateSent;
    }

    /**
     * @param \DateTime|null $dateSent
     * @return SurveyInvitation
     */
    public function setDateSent(\DateTime $dateSent) {
        $this->dateSent = $dateSent;
        return $this;
    }
}