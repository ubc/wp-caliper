<?php

namespace IMSGlobal\Caliper\entities;

use IMSGlobal\Caliper\context\Context;
use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\util;
use IMSGlobal\Caliper\util\ClassUtil;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;


class SystemIdentifier extends ClassUtil implements \JsonSerializable {
    /** @var Context|null */
    protected $context;
    /** @var string */
    private $identifier;
    /** @var SystemIdentifierType */
    private $identifierType;
    /** @var Type */
    private $type;
    /** @var SoftwareApplication */
    private $source;
    /** @var \array[] */
    private $extensions;

    public function __construct($identifier, $identifierType) {
        $this->setIdentifier($identifier)
             ->setIdentifierType($identifierType)
             ->setType(new EntityType(EntityType::SYSTEM_IDENTIFIER))
             ->setContext(new Context(Context::CONTEXT));
    }

    public function jsonSerialize() {
        return $this->removeChildEntitySameContexts([
            '@context' => $this->getContext(),
            'identifier' => $this->getIdentifier(),
            'identifierType' => $this->getIdentifierType(),
            'type' => $this->getType(),
            'source' => $this->getSource(),
            'extensions' => $this->getExtensions(),
        ]);
    }

    /**
     * @param array $serializationData Object property array (from $this->jsonSerialize())
     * @return array $serializationData with possible updates
     */
    protected function removeChildEntitySameContexts(array $serializationData) {
        return parent::removeChildEntitySameContextsBase($serializationData, $this);
    }

    /** @return Context|null */
    public function getContext() {
        return $this->context;
    }

    /**
     * @param Context|null $context
     * @throws \InvalidArgumentException Context object or null required
     * @return $this|SystemIdentifier
     */
    public function setContext($context) {
        if (is_null($context) || ($context instanceof Context)) {
            $this->context = $context;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': instance of Context expected');
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

    /** @return Type type */
    public function getType() {
        return $this->type;
    }

    /**
     * @param Type $type
     * @return $this|SystemIdentifier
     */
    public function setType(Type $type) {
        $this->type = $type;
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

    /** @return \array[]|null extensions */
    public function getExtensions() {
        return $this->extensions;
    }

    /**
     * @param \array[]|null $extensions An associative array
     * @throws \InvalidArgumentException associative array expected
     * @return $this|SystemIdentifier
     */
    public function setExtensions($extensions) {
        if (($extensions !== null) && !util\Type::isStringKeyedArray($extensions)) {
            throw new \InvalidArgumentException(__METHOD__ . ': associative array expected');
        }

        $this->extensions = $extensions;
        return $this;
    }
}
