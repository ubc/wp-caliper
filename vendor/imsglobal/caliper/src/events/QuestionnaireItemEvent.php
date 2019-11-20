<?php

namespace IMSGlobal\Caliper\events;

use IMSGlobal\Caliper\entities\foaf\Agent;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\Generatable;
use IMSGlobal\Caliper\entities\survey\QuestionnaireItem;
use IMSGlobal\Caliper\entities\response\Response;

class QuestionnaireItemEvent extends Event {
    /** @var Person */
    private $actor;
    /** @var QuestionnaireItem */
    private $object;
    /** @var Response */
    private $generated;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::QUESTIONNAIRE_ITEM));
    }

    /** @return Person object */
    public function getActor() {
        return $this->actor;
    }

    /**
     * @param Person $object
     * @throws \InvalidArgumentException Person expected
     * @return $this|QuestionnaireItemEvent
     */
    public function setActor(Agent $actor) {
        if (is_null($actor) || ($actor instanceof Person)) {
            $this->actor = $actor;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Person expected');
    }

    /** @return QuestionnaireItem object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param QuestionnaireItem $object
     * @throws \InvalidArgumentException QuestionnaireItem expected
     * @return $this|QuestionnaireItemEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof QuestionnaireItem)) {
            $this->object = $object;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': QuestionnaireItem expected');
    }

    /** @return Response object */
    public function getGenerated() {
        return $this->generated;
    }

    /**
     * @param Response $generated
     * @throws \InvalidArgumentException Response expected
     * @return $this|QuestionnaireItemEvent
     */
    public function setGenerated(Generatable $generated) {
        if (is_null($generated) || ($generated instanceof Response)) {
            $this->generated = $generated;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Response expected');
    }
}
