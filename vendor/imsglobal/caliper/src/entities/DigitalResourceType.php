<?php
namespace IMSGlobal\Caliper\entities;

class DigitalResourceType extends \IMSGlobal\Caliper\util\BasicEnum implements Type {
    const
        __default = '',
        ASSIGNABLE_DIGITAL_RESOURCE = 'AssignableDigitalResource',
        CHAPTER = 'Chapter',
        DOCUMENT = 'Document',
        EPUB_CHAPTER = 'EpubChapter', // @deprecated 1.2
        EPUB_PART = 'EpubPart', // @deprecated 1.2
        EPUB_VOLUME = 'EpubVolume', // @deprecated 1.2
        FRAME = 'Frame',
        MEDIA_OBJECT = 'MediaObject',
        MEDIA_LOCATION = 'MediaLocation',
        READING = 'Reading', // @deprecated 1.2
        WEB_PAGE = 'WebPage';
}