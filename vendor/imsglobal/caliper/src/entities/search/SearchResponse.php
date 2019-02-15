<?php

namespace IMSGlobal\Caliper\entities\search;

use IMSGlobal\Caliper\entities\Entity;
use IMSGlobal\Caliper\entities\search\Query;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\context\Context;

class SearchResponse extends Entity implements entities\Referrable, entities\Generatable {
    /** @var SoftwareApplication|null */
    private $searchProvider;
    /** @var Entity|null */
    private $searchTarget;
    /** @var Query|null */
    private $query;
    /** @var int|null */
    private $searchResultsItemCount;
    /** @var Entity[]|string[]|null */
    private $searchResults = [];

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::SEARCH_RESPONSE));
        $this->setContext(new Context(Context::SEARCH_PROFILE_EXTENSION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'searchProvider' => $this->getSearchProvider(),
            'searchTarget' => $this->getSearchTarget(),
            'query' => $this->getQuery(),
            'searchResultsItemCount' => $this->getSearchResultsItemCount(),
            'searchResults' => $this->getSearchResults(),
        ]));
    }

    /** @return SoftwareApplication|null searchProvider */
    public function getSearchProvider() {
        return $this->searchProvider;
    }

    /**
     * @param SoftwareApplication|null $searchProvider
     * @return $this|SearchResponse
     */
    public function setSearchProvider(SoftwareApplication $searchProvider) {
        $this->searchProvider = $searchProvider;
        return $this;
    }

    /** @return Entity|null searchTarget */
    public function getSearchTarget() {
        return $this->searchTarget;
    }

    /**
     * @param Entity|null $searchTarget
     * @return $this|SearchResponse
     */
    public function setSearchTarget(Entity $searchTarget) {
        $this->searchTarget = $searchTarget;
        return $this;
    }

    /** @return Query|null query */
    public function getQuery() {
        return $this->query;
    }

    /**
     * @param Query|null $query
     * @return $this|SearchResponse
     */
    public function setQuery(Query $query) {
        $this->query = $query;
        return $this;
    }

    /** @return int searchResultsItemCount */
    public function getSearchResultsItemCount() {
        return $this->searchResultsItemCount;
    }

    /**
     * @param int|null $searchResultsItemCount
     * @throws \InvalidArgumentException int required
     * @return $this|SearchResponse
     */
    public function setSearchResultsItemCount($searchResultsItemCount) {
        if (is_null($searchResultsItemCount) || is_int($searchResultsItemCount)) {
            $this->searchResultsItemCount = $searchResultsItemCount;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': int expected');
    }


    /** @return Entity[]|null */
    public function getSearchResults() {
        return $this->searchResults;
    }

    /**
     * @param Entity|Entity[]|string|string[]|null $searchResults
     * @return $this|SearchResponse
     */
    public function setSearchResults($searchResults) {
        if (!is_null($searchResults)) {
            if (!is_array($searchResults)) $searchResults = [$searchResults];

            foreach ($searchResults as $searchResult) {
                if (!($searchResult instanceof Entity) && !is_string($searchResult)) {
                    throw new \InvalidArgumentException(
                        __METHOD__ . ': array of ' . Entity::className() . ' or string expected');
                }
            }
        }

        $this->searchResults = $searchResults;
        return $this;
    }
}
