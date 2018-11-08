<?php

namespace IMSGlobal\Caliper\entities\annotation;

use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\foaf\Agent;

/**
 *         The super-class of all Annotation types.
 *
 *         Direct sub-types can include - Highlight, Attachment, etc. - all of
 *         which are specified in the Caliper Annotation Metric Profile
 *
 */
abstract class Annotation extends entities\Entity implements entities\Generatable {
    /** @var Agent|null */
    private $annotator;
    /** @var DigitalResource|null */
    private $annotated;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::ANNOTATION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'annotator' => $this->getAnnotator(),
            'annotated' => $this->getAnnotated(),
        ]));
    }

    /** @return Agent|null annotator */
    public function getAnnotator() {
        return $this->annotator;
    }

    /**
     * @param Agent|null $annotator
     * @throws \InvalidArgumentException Agent required
     * @return $this|Annotation
     */
    public function setAnnotator($annotator) {
        if (is_null($annotator) || ($annotator instanceof Agent)) {
            $this->annotator = $annotator;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Agent expected');
    }

    /** @return DigitalResource|null annotated */
    public function getAnnotated() {
        return $this->annotated;
    }

    /**
     * @param DigitalResource|null $annotated
     * @throws \InvalidArgumentException DigitalResource required
     * @return $this|Annotation
     */
    public function setAnnotated($annotated) {
        if (is_null($annotated) || ($annotated instanceof DigitalResource)) {
            $this->annotated = $annotated;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': DigitalResource expected');
    }
}
