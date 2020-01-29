<?php

namespace IMSGlobal\Caliper\entities\question;

use IMSGlobal\Caliper\entities;

class OpenEndedQuestion extends Question {
    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::OPEN_ENDED_QUESTION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
        ]));
    }
}
