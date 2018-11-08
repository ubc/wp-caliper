<?php
namespace IMSGlobal\Caliper\entities\reading;

use IMSGlobal\Caliper\entities;

class Chapter extends entities\DigitalResource {
    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\DigitalResourceType(entities\DigitalResourceType::CHAPTER));
    }
}
