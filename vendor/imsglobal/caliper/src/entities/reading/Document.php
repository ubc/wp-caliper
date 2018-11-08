<?php
namespace IMSGlobal\Caliper\entities\reading;

use IMSGlobal\Caliper\entities;

class Document extends entities\DigitalResource {
    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\DigitalResourceType(entities\DigitalResourceType::DOCUMENT));
    }
}
