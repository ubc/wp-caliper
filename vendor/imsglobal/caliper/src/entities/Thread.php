<?php
namespace IMSGlobal\Caliper\entities;

class Thread extends DigitalResourceCollection {
    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new EntityType(EntityType::THREAD));
    }
}