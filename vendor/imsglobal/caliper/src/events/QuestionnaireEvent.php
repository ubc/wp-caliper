<?php

namespace IMSGlobal\Caliper\events;

use IMSGlobal\Caliper\entities\foaf\Agent;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\survey\Questionnaire;

class QuestionnaireEvent extends Event {
    /** @var Person */
    private $actor;
    /** @var Questionnaire */
    private $object;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::QUESTIONNAIRE));
    }

    /** @return Person object */
    public function getActor() {
        return $this->actor;
    }

    /**
     * @param Person $object
     * @throws \InvalidArgumentException Person expected
     * @return $this|QuestionnaireEvent
     */
    public function setActor(Agent $actor) {
        if (is_null($actor) || ($actor instanceof Person)) {
            $this->actor = $actor;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Person expected');
    }

    /** @return Questionnaire object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param Questionnaire $object
     * @throws \InvalidArgumentException Questionnaire expected
     * @return $this|QuestionnaireEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof Questionnaire)) {
            $this->object = $object;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Questionnaire expected');
    }
}
