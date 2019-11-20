<?php

namespace IMSGlobal\Caliper\entities\feedback;

use IMSGlobal\Caliper\entities\Entity;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities;

class Comment extends Entity implements entities\Referrable, entities\Generatable {
    /** @var Person */
    private $commenter;
    /** @var Entity */
    private $commentedOn;
    /** @var string */
    private $value;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::COMMENT));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'commenter' => $this->getCommenter(),
            'commentedOn' => $this->getCommentedOn(),
            'value' => $this->getValue()
        ]));
    }

    /** @return Person|null commenter */
    public function getCommenter() {
        return $this->commenter;
    }

    /**
     * @param Person|null $commenter
     * @return $this|Comment
     */
    public function setCommenter(Person $commenter) {
        $this->commenter = $commenter;
        return $this;
    }

    /** @return Entity|null commentedOn */
    public function getCommentedOn() {
        return $this->commentedOn;
    }

    /**
     * @param Entity|null $commentedOn
     * @return $this|Comment
     */
    public function setCommentedOn(Entity $commentedOn) {
        $this->commentedOn = $commentedOn;
        return $this;
    }

    /** @return string|null value */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return $this|Comment
     */
    public function setValue($value) {
        if (!is_null($value) && !is_string($value)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->value = strval($value);
        return $this;
    }
}
