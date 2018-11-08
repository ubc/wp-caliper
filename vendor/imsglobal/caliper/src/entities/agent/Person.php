<?php
namespace IMSGlobal\Caliper\entities\agent;

use IMSGlobal\Caliper\entities;

class Person extends entities\Entity implements entities\foaf\Agent {
    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::PERSON));
    }
}
