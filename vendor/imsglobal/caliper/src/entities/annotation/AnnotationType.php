<?php
namespace IMSGlobal\Caliper\entities\annotation;

use IMSGlobal\Caliper;

class AnnotationType extends Caliper\util\BasicEnum implements Caliper\entities\Type {
    const
        __default = '',
        BOOKMARK_ANNOTATION = 'BookmarkAnnotation',
        HIGHLIGHT_ANNOTATION = 'HighlightAnnotation',
        SHARED_ANNOTATION = 'SharedAnnotation',
        TAG_ANNOTATION = 'TagAnnotation',
        TEXT_POSITION_SELECTOR = 'TextPositionSelector';
}

