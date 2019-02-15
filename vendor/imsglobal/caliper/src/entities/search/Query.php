<?php

namespace IMSGlobal\Caliper\entities\search;

use IMSGlobal\Caliper\entities\Entity;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\context\Context;

class Query extends Entity implements entities\Referrable {
    /** @var Person|null */
    private $creator;
    /** @var Entity|null */
    private $searchTarget;
    /** @var string */
    private $searchTerms;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::QUERY));
        $this->setContext(new Context(Context::SEARCH_PROFILE_EXTENSION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'creator' => $this->getCreator(),
            'searchTarget' => $this->getSearchTarget(),
            'searchTerms' => $this->getSearchTerms(),
        ]));
    }

    /** @return Person|null creator */
    public function getCreator() {
        return $this->creator;
    }

    /**
     * @param Person|null $creator
     * @return $this|Query
     */
    public function setCreator(Person $creator) {
        $this->creator = $creator;
        return $this;
    }

    /** @return Entity|null searchTarget */
    public function getSearchTarget() {
        return $this->searchTarget;
    }

    /**
     * @param Entity|null $searchTarget
     * @return $this|Query
     */
    public function setSearchTarget(Entity $searchTarget) {
        $this->searchTarget = $searchTarget;
        return $this;
    }

    /** @return string|null searchTerms */
    public function getSearchTerms() {
        return $this->searchTerms;
    }

    /**
     * @param string|null $searchTerms
     * @return $this|Query
     */
    public function setSearchTerms($searchTerms) {
        if (!is_null($searchTerms) && !is_string($searchTerms)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->searchTerms = strval($searchTerms);
        return $this;
    }
}
