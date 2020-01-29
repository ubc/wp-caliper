<?php

namespace IMSGlobal\Caliper\events;

use IMSGlobal\Caliper\actions;
use IMSGlobal\Caliper\entities\assignable\Attempt;
use IMSGlobal\Caliper\entities\Generatable;
use IMSGlobal\Caliper\entities\outcome\Score;

class GradeEvent extends Event {
    /** @var Attempt */
    private $object;
    /** @var Score */
    private $generated;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::GRADE))
            ->setAction(new actions\Action(actions\Action::GRADED));
    }

    /** @return Attempt object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param Attempt $object
     * @throws \InvalidArgumentException Attempt expected
     * @return $this|GradeEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof Attempt)) {
            $this->object = $object;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Attempt expected');
    }

    /** @return Score */
    public function getGenerated() {
        return $this->generated;
    }

    /**
     * @param Score $generated
     * @return $this|GradeEvent
     */
    public function setGenerated(Generatable $generated) {
        if (is_null($generated) || ($generated instanceof Score)) {
            $this->generated = $generated;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Score expected');
    }
}
