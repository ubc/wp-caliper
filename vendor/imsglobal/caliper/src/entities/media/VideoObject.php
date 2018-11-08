<?php
namespace IMSGlobal\Caliper\entities\media;

class VideoObject extends MediaObject implements \IMSGlobal\Caliper\entities\schemadotorg\VideoObject {

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new MediaObjectType(MediaObjectType::VIDEO_OBJECT));
    }
}