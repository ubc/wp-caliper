<?php
namespace IMSGlobal\Caliper\entities\reading;

use IMSGlobal\Caliper\entities;

/**
 *         Representation of an EPUB 3 Volume
 *
 *         A component of a collection
 *         http://www.idpf.org/epub/vocab/structure/#volume
 *
 */
class EPubVolume extends entities\DigitalResource implements entities\schemadotorg\CreativeWork {

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\DigitalResourceType(entities\DigitalResourceType::EPUB_VOLUME));
    }
}