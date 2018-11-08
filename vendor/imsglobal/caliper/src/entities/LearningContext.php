<?php
namespace IMSGlobal\Caliper\entities;

use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\w3c\Organization;

class LearningContext {
    /** @var SoftwareApplication */
    public $edApp;
    /** @var Organization */
    public $group;
    /** @var Membership */
    protected $membership;

    public function jsonSerialize() {
        return [
            'edApp' => $this->getEdApp(),
            'group' => $this->getGroup(),
            'membership' => $this->getMembership(),
        ];
    }

    /** @return SoftwareApplication edApp */
    public function getEdApp() {
        return $this->edApp;
    }

    /**
     * @param SoftwareApplication $edApp
     * @return $this|LearningContext
     */
    public function setEdApp(SoftwareApplication $edApp) {
        $this->edApp = $edApp;
        return $this;
    }

    /** @return Organization group */
    public function getGroup() {
        return $this->group;
    }

    /**
     * @param Organization $group
     * @return $this|LearningContext
     */
    public function setGroup(Organization $group) {
        $this->group = $group;
        return $this;
    }

    /** @return Membership membership */
    public function getMembership() {
        return $this->membership;
    }

    /**
     * @param Membership $membership
     * @return $this|LearningContext
     */
    public function setMembership(Membership $membership) {
        $this->membership = $membership;
        return $this;
    }
}

