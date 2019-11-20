<?php

namespace IMSGlobal\Caliper\entities\question;

use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities;

class Question extends DigitalResource {
    /** @var string */
    private $questionPosed;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::QUESTION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'questionPosed' => $this->getQuestionPosed()
        ]));
    }

    /** @return string|null questionPosed */
    public function getQuestionPosed() {
        return $this->questionPosed;
    }

    /**
     * @param string|null $questionPosed
     * @return $this|Question
     */
    public function setQuestionPosed($questionPosed) {
        if (!is_null($questionPosed) && !is_string($questionPosed)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->questionPosed = strval($questionPosed);
        return $this;
    }
}
