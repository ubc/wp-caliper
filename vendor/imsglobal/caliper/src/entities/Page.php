<?php
namespace IMSGlobal\Caliper\entities;

class Page extends DigitalResource {
    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new EntityType(EntityType::PAGE));
    }
}
