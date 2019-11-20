<?php
namespace IMSGlobal\Caliper\entities;

class Collection extends Entity implements Collectable {
    /** @var Entity[]|null */
    private $items;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new EntityType(EntityType::COLLECTION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'items' => $this->getItems(),
        ]));
    }

    /** @return Entity[]|null */
    public function getItems() {
        return $this->items;
    }

    /**
     * @param Entity|Entity[]|null $items
     * @return Collection
     */
    public function setItems($items) {
        if (!is_null($items)) {
            if (!is_array($items)) $items = [$items];

            foreach ($items as $item) {
                if (!($item instanceof Entity)) {
                    throw new \InvalidArgumentException(
                        __METHOD__ . ': array of ' . Entity::className() . ' expected');
                }
            }
        }

        $this->items = $items;
        return $this;
    }
}
