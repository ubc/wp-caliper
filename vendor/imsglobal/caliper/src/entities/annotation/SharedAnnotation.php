<?php

namespace IMSGlobal\Caliper\entities\annotation;

use IMSGlobal\Caliper\entities\foaf\Agent;

class SharedAnnotation extends Annotation {
    /** @var Agent[]|null */
    public $withAgents;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new AnnotationType(AnnotationType::SHARED_ANNOTATION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'withAgents' => $this->getWithAgents(),
        ]));
    }

    /** @return Agent[]|null withAgents */
    public function getWithAgents() {
        return $this->withAgents;
    }

    /**
     * @param Agent|Agent[]|null $withAgents
     * @throws \InvalidArgumentException array of Agent required
     * @return $this|SharedAnnotation
     */
    public function setWithAgents($withAgents) {
        if (!is_null($withAgents)) {
            if (!is_array($withAgents)) {
                $withAgents = [$withAgents];
            }

            foreach ($withAgents as $aWithAgents) {
                if (!($aWithAgents instanceof Agent)) {
                    // FIXME: After PHP 5.5 is a requirement, change "Agent" string to "::class".
                    throw new \InvalidArgumentException(__METHOD__ . ': array of Agent expected');
                }
            }
        }

        $this->withAgents = $withAgents;
        return $this;
    }
}
