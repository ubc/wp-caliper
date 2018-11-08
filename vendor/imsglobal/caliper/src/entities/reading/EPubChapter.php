<?php
namespace IMSGlobal\Caliper\entities\reading;

use IMSGlobal\Caliper\entities;

/**
 *         Representation of an EPUB 3 Volume
 *
 *         A major structural division of a piece of writing
 *         http://www.idpf.org/epub/vocab/structure/#chapter
 *
 */
class EPubChapter extends entities\DigitalResource implements entities\schemadotorg\CreativeWork {
    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\DigitalResourceType(entities\DigitalResourceType::EPUB_CHAPTER));
    }
}