<?php

namespace IMSGlobal\Caliper\events;

use IMSGlobal\Caliper\profiles;
use IMSGlobal\Caliper\actions;
use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\survey\Questionnaire;
use IMSGlobal\Caliper\entities\survey\QuestionnaireItem;

class NavigationEvent extends Event {
    /** @var DigitalResource */
    private $object;
    /** @var entities\DigitalResource */
    private $target;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::NAVIGATION))
            ->setAction(new actions\Action(actions\Action::NAVIGATED_TO));
    }

    /** @return DigitalResource object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param DigitalResource $object
     * @throws \InvalidArgumentException DigitalResource expected
     * @return $this|NavigationEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof DigitalResource)) {
            $this->object = $object;
            if ($this->profile === profiles\Profile::SURVEY) {
                if (!$object instanceof Questionnaire && !$object instanceof QuestionnaireItem) {
                    throw new \InvalidArgumentException(__METHOD__ . ': Questionnaire or QuestionnaireItem expected');
                }
            }
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': DigitalResource expected');
    }

    /** @return entities\DigitalResource|null target */
    public function getTarget() {
        return $this->target;
    }

    /**
     * @param entities\DigitalResource|null $target
     * @return $this|Event
     */
    public function setTarget($target) {
        if (is_null($target) || ($target instanceof DigitalResource)) {
            $this->target = $target;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': DigitalResource expected');
    }
}
