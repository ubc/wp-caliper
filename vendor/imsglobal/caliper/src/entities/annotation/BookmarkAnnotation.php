<?php

namespace IMSGlobal\Caliper\entities\annotation;

class BookmarkAnnotation extends Annotation {
    /** @var string */
    private $bookmarkNotes;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new AnnotationType(AnnotationType::BOOKMARK_ANNOTATION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'bookmarkNotes' => $this->getBookmarkNotes(),
        ]));
    }

    /** @return string bookmarkNotes */
    public function getBookmarkNotes() {
        return $this->bookmarkNotes;
    }

    /**
     * @param string $bookmarkNotes
     * @return $this|BookmarkAnnotation
     */
    public function setBookmarkNotes($bookmarkNotes) {
        $this->bookmarkNotes = $bookmarkNotes;
        return $this;
    }
}
