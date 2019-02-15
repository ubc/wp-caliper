<?php

namespace IMSGlobal\Caliper\events;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\search\SearchResponse;
use IMSGlobal\Caliper\entities\Generatable;
use IMSGlobal\Caliper\context\Context;


class SearchEvent extends Event {
    /** @var SearchResponse */
    private $generated;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::SEARCH));
        $this->setContext(new Context(Context::SEARCH_PROFILE_EXTENSION));
    }

    /** @return SearchResponse generated */
    public function getGenerated() {
        return $this->generated;
    }

    /**
     * @param SearchResponse $generated
     * @return $this|SearchEvent
     */
    public function setGenerated(Generatable $generated) {
        if (is_null($generated) || ($generated instanceof SearchResponse)) {
            $this->generated = $generated;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': SearchResponse expected');
    }
}
