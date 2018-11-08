<?php

namespace IMSGlobal\Caliper\entities;

use IMSGlobal\Caliper\entities\foaf\Agent;
use IMSGlobal\Caliper\entities\schemadotorg\CreativeWork;
use IMSGlobal\Caliper\util\TimestampUtil;

/**
 *         Caliper representation of a CreativeWork
 *         (https://schema.org/CreativeWork)
 *
 *         We add on learning specific attributes, including a list of
 *         {@link LearningObjective} learning objectives and a list of
 *         {@link String} keywords
 *
 *         In addition, we add a the following attributes:
 *
 *         name (https://schema.org/name) -the name of the resource,
 *
 *         about (https://schema.org/about) - the subject matter of the resource
 *
 *         language (https://schema.org/Language) - Natural languages such as
 *         Spanish, Tamil, Hindi, English, etc. and programming languages such
 *         as Scheme and Lisp
 *
 */
class DigitalResource extends Entity implements Referrable, Targetable, CreativeWork {
    /**
     * @deprecated 1.2 Redundant.  See "@type".
     * @var string[]
     */
    private $objectTypes = [];
    /** @var string */
    private $mediaType;
    /** @var Agent[] */
    private $creators = [];
    /** @var LearningObjective[] */
    private $learningObjectives = [];
    /** @var string[] */
    private $keywords = [];
    /** @var Entity|null */
    private $isPartOf;
    /** @var \DateTime */
    private $datePublished;
    /** @var string */
    private $version;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new EntityType(EntityType::DIGITAL_RESOURCE));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'objectType' => $this->getObjectTypes(),
            'mediaType' => $this->getMediaType(),
            'creators' => $this->getCreators(),
            'learningObjectives' => $this->getLearningObjectives(),
            'keywords' => $this->getKeywords(),
            'isPartOf' => $this->getIsPartOf(),
            'datePublished' => TimestampUtil::formatTimeISO8601MillisUTC($this->getDatePublished()),
            'version' => $this->getVersion(),
        ]));
    }

    /**
     * @deprecated 1.2 Redundant.  See "@type".
     * @return string[] objectTypes
     */
    public function getObjectTypes() {
        return $this->objectTypes;
    }

    /**
     * @deprecated 1.2 Redundant.  See "@type".
     * @param string|string[] $objectTypes
     * @throws \InvalidArgumentException array must contain only strings
     * @return $this|DigitalResource
     */
    public function setObjectTypes($objectTypes) {
        if (!is_array($objectTypes)) {
            $objectTypes = [$objectTypes];
        }

        foreach ($objectTypes as $anObjectType) {
            if (!is_string($anObjectType)) {
                throw new \InvalidArgumentException(__METHOD__ . ': array of string expected');
            }
        }

        $this->objectTypes = $objectTypes;
        return $this;
    }

    /** @return string mediaType */
    public function getMediaType() {
        return $this->mediaType;
    }

    /**
     * @param string $mediaType
     * @throws \InvalidArgumentException string required
     * @return $this|DigitalResource
     */
    public function setMediaType($mediaType) {
        if (!is_string($mediaType)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->mediaType = strval($mediaType);
        return $this;
    }

    /**
     * @return Agent[]
     */
    public function getCreators() {
        return $this->creators;
    }

    /**
     * @param Agent[] $creators
     * @throws \InvalidArgumentException array of Agent required
     * @return $this|DigitalResource
     */
    public function setCreators($creators) {
        if (!is_array($creators)) {
            $creators = [$creators];
        }

        foreach ($creators as $aCreator) {
            if (!($aCreator instanceof Agent)) {
                // Using `Agent::className()` here is tricky.  Using static string for expediency.
                throw new \InvalidArgumentException(
                    __METHOD__ . ': array of Agent expected');
            }
        }

        $this->creators = $creators;
        return $this;
    }

    /** @return LearningObjective[] learningObjectives */
    public function getLearningObjectives() {
        return $this->learningObjectives;
    }

    /**
     * @param LearningObjective|LearningObjective[] $learningObjectives
     * @throws \InvalidArgumentException array must contain only strings
     * @return $this|DigitalResource
     */
    public function setLearningObjectives($learningObjectives) {
        if (!is_array($learningObjectives)) {
            $learningObjectives = [$learningObjectives];
        }

        foreach ($learningObjectives as $aLearningObjective) {
            if (!($aLearningObjective instanceof LearningObjective)) {
                throw new \InvalidArgumentException(__METHOD__ . ': array of LearningObjective expected');
            }
        }

        $this->learningObjectives = $learningObjectives;
        return $this;
    }

    /** @return string[] keywords */
    public function getKeywords() {
        return $this->keywords;
    }

    /**
     * @param string|string[] $keywords
     * @throws \InvalidArgumentException array must contain only strings
     * @return $this|DigitalResource
     */
    public function setKeywords($keywords) {
        if (!is_array($keywords)) {
            $keywords = [$keywords];
        }

        foreach ($keywords as $aKeyword) {
            if (!is_string($aKeyword)) {
                throw new \InvalidArgumentException(__METHOD__ . ': array of string expected');
            }
        }

        $this->keywords = $keywords;
        return $this;
    }

    /** @return Entity|null isPartOf */
    public function getIsPartOf() {
        return $this->isPartOf;
    }

    /**
     * @param Entity|null $isPartOf
     * @return $this|DigitalResource
     */
    public function setIsPartOf(Entity $isPartOf) {
        $this->isPartOf = $isPartOf;
        return $this;
    }

    /**
     * @return \DateTime datePublished
     */
    public function getDatePublished() {
        return $this->datePublished;
    }

    /**
     * @param \DateTime $datePublished
     * @return $this|DigitalResource
     */
    public function setDatePublished(\DateTime $datePublished) {
        $this->datePublished = $datePublished;
        return $this;
    }

    /** @return string version */
    public function getVersion() {
        return $this->version;
    }

    /**
     * @param string $version
     * @throws \InvalidArgumentException string required
     * @return $this|DigitalResource
     */
    public function setVersion($version) {
        if (!is_string($version)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->version = $version;
        return $this;
    }
}
