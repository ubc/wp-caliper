<?php

namespace IMSGlobal\Caliper\entities\agent;

use IMSGlobal\Caliper\entities;

class Organization extends entities\Entity implements entities\foaf\Agent, entities\w3c\Organization {
    /** @var entities\w3c\Organization */
    private $subOrganizationOf;
    /** @var entities\foaf\Agent[] */
    private $members;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::ORGANIZATION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'members' => $this->getMembers(),
            'subOrganizationOf' => $this->getSubOrganizationOf(),
        ]));

    }

    /** @return entities\foaf\Agent[] */
    public function getMembers() {
        return $this->members;
    }

    /**
     * @param entities\foaf\Agent[] $members
     * @return $this|Organization
     */
    public function setMembers($members) {
        if (!is_null($members)) {
            if (!is_array($members)) {
                $members = [$members];
            }

            foreach ($members as $member) {
                if (!($member instanceof entities\foaf\Agent)) {
                    throw new \InvalidArgumentException(__METHOD__ . ': array of Agent expected');
                }
            }
        }

        $this->members = $members;
        return $this;
    }

    /** @return entities\w3c\Organization */
    public function getSubOrganizationOf() {
        return $this->subOrganizationOf;
    }

    /**
     * @param entities\w3c\Organization $subOrganizationOf
     * @return $this|Organization
     */
    public function setSubOrganizationOf(entities\w3c\Organization $subOrganizationOf) {
        $this->subOrganizationOf = $subOrganizationOf;
        return $this;
    }
}
