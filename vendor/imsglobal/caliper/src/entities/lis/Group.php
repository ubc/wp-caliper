<?php
namespace IMSGlobal\Caliper\entities\lis;

use IMSGlobal\Caliper\entities;

class Group extends entities\agent\Organization {
    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::GROUP));
    }
}


