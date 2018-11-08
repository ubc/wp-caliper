<?php
namespace IMSGlobal\Caliper\entities;

class LearningObjective extends Entity {

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new EntityType(EntityType::LEARNING_OBJECTIVE));
    }
}
