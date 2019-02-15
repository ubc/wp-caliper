<?php

namespace IMSGlobal\Caliper\events;
use IMSGlobal\Caliper\entities\Entity;
use IMSGlobal\Caliper\entities\Generatable;
use IMSGlobal\Caliper\context\Context;


class ResourceManagementEvent extends Event {
    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::RESOURCE_MANAGEMENT));
        $this->setContext(new Context(Context::RESOURCE_MANAGEMENT_EXTENSION));
    }
}
