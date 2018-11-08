<?php
namespace IMSGlobal\Caliper\entities\media;

class ImageObject extends MediaObject implements \IMSGlobal\Caliper\entities\schemadotorg\ImageObject {

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new MediaObjectType(MediaObjectType::IMAGE_OBJECT));
    }
}