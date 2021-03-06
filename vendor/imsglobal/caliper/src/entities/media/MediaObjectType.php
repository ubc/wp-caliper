<?php
namespace IMSGlobal\Caliper\entities\media;

use IMSGlobal\Caliper;

class MediaObjectType extends Caliper\util\BasicEnum implements Caliper\entities\Type {
    const
        __default = '',
        AUDIO_OBJECT = 'AudioObject',
        IMAGE_OBJECT = 'ImageObject',
        MEDIA_OBJECT = 'MediaObject',
        VIDEO_OBJECT = 'VideoObject';
}
