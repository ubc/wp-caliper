<?php

namespace IMSGlobal\Caliper\entities;

use IMSGlobal\Caliper\context\Context;
use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\util;
use IMSGlobal\Caliper\util\ClassUtil;

class Entity extends ClassUtil implements \JsonSerializable, entities\schemadotorg\Thing {
    /** @var string */
    protected $id;
    /** @var Context|null */
    protected $context;
    /** @var bool */
    protected $isReference = false;
    /** @var Type */
    private $type;
    /** @var string */
    private $name;
    /** @var SystemIdentifier[]|null */
    private $otherIdentifiers;
    /** @var string */
    private $description;
    /** @var \array[] */
    private $extensions;
    /** @var \DateTime */
    private $dateCreated;
    /** @var \DateTime */
    private $dateModified;

    function __construct($id) {
        $this->setId($id)
            ->setContext(new Context(Context::CONTEXT));
        $this->setType(new EntityType(EntityType::ENTITY));
    }

    /**
     * Serialize an entity object to JSON.
     *
     * If an entity has been marked as a reference, only its ID will be returned in the JSON.
     *
     * @return array|string
     */
    public function jsonSerialize() {
        if ($this->isReference === true)
            return $this->id;

        return $this->removeChildEntitySameContexts([
            '@context' => $this->getContext(),
            'id' => $this->getId(),
            'type' => $this->getType(),
            'name' => $this->getName(),
            'otherIdentifiers' => $this->getOtherIdentifiers(),
            'description' => $this->getDescription(),
            'extensions' => $this->getExtensions(),
            'dateCreated' => util\TimestampUtil::formatTimeISO8601MillisUTC($this->getDateCreated()),
            'dateModified' => util\TimestampUtil::formatTimeISO8601MillisUTC($this->getDateModified()),
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
     * @return $this|Entity
     */
    public function setContext($context) {
        if (is_null($context) || ($context instanceof Context)) {
            $this->context = $context;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': instance of Context expected');
    }

    /** @return string id */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     * @throws \InvalidArgumentException string required
     * @return $this|Entity
     */
    public function setId($id) {
        if (!is_string($id)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->id = $id;
        return $this;
    }

    /** @return Type type */
    public function getType() {
        return $this->type;
    }

    /**
     * @param Type $type
     * @return $this|Entity
     */
    public function setType(Type $type) {
        $this->type = $type;
        return $this;
    }

    /** @return string name */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @throws \InvalidArgumentException string required
     * @return $this|Entity
     */
    public function setName($name) {
        if (!is_string($name)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->name = $name;
        return $this;
    }

    /**
     * @return SystemIdentifier[]
     */
    public function getOtherIdentifiers() {
        return $this->otherIdentifiers;
    }

    /**
     * @param SystemIdentifier[]|null $otherIdentifiers
     * @throws \InvalidArgumentException array of SystemIdentifier required
     * @return $this|Entity
     */
    public function setOtherIdentifiers($otherIdentifiers) {
        if (!is_null($otherIdentifiers)) {
            if (!is_array($otherIdentifiers)) {
                $otherIdentifiers = [$otherIdentifiers];
            }

            foreach ($otherIdentifiers as $aOtherIdentifier) {
                if (!($aOtherIdentifier instanceof SystemIdentifier)) {
                    throw new \InvalidArgumentException( __METHOD__ . ': array of SystemIdentifier expected');
                }
            }
        }

        $this->otherIdentifiers = $otherIdentifiers;
        return $this;
    }

    /** @return string description */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     * @throws \InvalidArgumentException string required
     * @return $this|Entity
     */
    public function setDescription($description) {
        if (!is_string($description)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->description = $description;
        return $this;
    }

    /** @return \array[]|null extensions */
    public function getExtensions() {
        return $this->extensions;
    }

    /**
     * @param \array[]|null $extensions An associative array
     * @throws \InvalidArgumentException associative array expected
     * @return $this|Entity
     */
    public function setExtensions($extensions) {
        if (($extensions !== null) && !util\Type::isStringKeyedArray($extensions)) {
            throw new \InvalidArgumentException(__METHOD__ . ': associative array expected');
        }

        $this->extensions = $extensions;
        return $this;
    }

    /** @return \DateTime dateCreated */
    public function getDateCreated() {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     * @return $this|Entity
     */
    public function setDateCreated(\DateTime $dateCreated) {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /** @return \DateTime dateModified */
    public function getDateModified() {
        return $this->dateModified;
    }

    /**
     * @param \DateTime $dateModified
     * @return $this|Entity
     */
    public function setDateModified(\DateTime $dateModified) {
        $this->dateModified = $dateModified;
        return $this;
    }

    /**
     * Make a reference to an entity.
     *
     * When called on an entity object, it will clone itself and mark the clone as a reference.
     * When the reference entity is serialized, the JSON will contain only its ID value.  By
     * cloning the object, the reference will still be of the same type and have all the same
     * attribute values as the original, so it will pass the same tests as the original would.
     *
     * @return $this|Entity
     */
    public function makeReference() {
        $reference = clone $this;
        $reference->isReference = true;
        return $reference;
    }

    /**
     * Make an Anonymous entity.
     *
     * Static method to create basic anonymous entity (id set to object type)
     * Additional information can be added with getters/setters though caution
     * should be depending on the required level of anonymity
     *
     * @return $this|Entity
     */
    public static function makeAnonymous() {
        $anonymous = new static('');
        $anonymous->setId('http://purl.imsglobal.org/caliper/'.$anonymous->getType()->jsonSerialize());
        return $anonymous;
    }
}

