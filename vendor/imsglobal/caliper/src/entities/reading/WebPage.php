<?php
namespace IMSGlobal\Caliper\entities\reading;

use IMSGlobal\Caliper\entities;

class WebPage extends entities\DigitalResource implements entities\schemadotorg\CreativeWork {

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\DigitalResourceType(entities\DigitalResourceType::WEB_PAGE));
    }
}
