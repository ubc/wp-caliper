<?php

namespace IMSGlobal\Caliper\entities\link;

use IMSGlobal\Caliper\entities;

class Link extends entities\Entity implements entities\Referrable, entities\Targetable {
    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::LINK));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return array_merge($serializedParent, []);
    }
}
