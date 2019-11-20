<?php

namespace IMSGlobal\Caliper\entities;

use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\util;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;


class SystemIdentifier extends Entity implements \JsonSerializable {
    /** @var string */
    private $identifier;
    /** @var SystemIdentifierType */
    private $identifierType;
    /** @var SoftwareApplication */
    private $source;

    public function __construct($identifier, $identifierType) {
        parent::__construct(''); // SystemIdentifier objects don't need an ID
        $this->setIdentifier($identifier)
             ->setIdentifierType($identifierType)
             ->setType(new EntityType(EntityType::SYSTEM_IDENTIFIER));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'id' => null, // SystemIdentifier objects don't need an ID
            'identifier' => $this->getIdentifier(),
            'identifierType' => $this->getIdentifierType(),
            'source' => $this->getSource(),
        ]));
    }

    /** @return string identifier */
    public function getIdentifier() {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @throws \InvalidArgumentException string required
     * @return $this|SystemIdentifier
     */
    public function setIdentifier($identifier) {
        if (!is_string($identifier)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->identifier = $identifier;
        return $this;
    }

    /** @return SystemIdentifierType identifierType */
    public function getIdentifierType() {
        return $this->identifierType;
    }

    /**
     * @param SystemIdentifierType $identifierType
     * @return $this|SystemIdentifier
     */
    public function setIdentifierType(SystemIdentifierType $identifierType) {
        $this->identifierType = $identifierType;
        return $this;
    }

    /** @return SoftwareApplication source */
    public function getSource() {
        return $this->source;
    }

    /**
     * @param SoftwareApplication $source
     * @return $this|SystemIdentifier
     */
    public function setSource(SoftwareApplication $source) {
        $this->source = $source;
        return $this;
    }
}
