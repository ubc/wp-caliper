<?php
namespace IMSGlobal\Caliper\entities\reading;

use IMSGlobal\Caliper\entities;

/**
 *         Representation of an EPUB 3 Volume
 *
 *         A major structural division of a piece of writing, typically
 *         encapsulating a set of related chapters.
 *         http://www.idpf.org/epub/vocab/structure/#part
 *
 */
class EPubPart extends entities\DigitalResource implements entities\schemadotorg\CreativeWork {
    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\DigitalResourceType(entities\DigitalResourceType::EPUB_PART));
    }
}