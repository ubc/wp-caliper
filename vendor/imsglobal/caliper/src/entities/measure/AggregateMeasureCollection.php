<?php
namespace IMSGlobal\Caliper\entities\measure;

use IMSGlobal\Caliper\entities\Collection;
use IMSGlobal\Caliper\entities;

class AggregateMeasureCollection extends Collection implements entities\Generatable {
    /** @var AggregateMeasure[]|null */
    private $items;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::AGGREGATE_MEASURE_COLLECTION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'items' => $this->getItems(),
        ]));
    }

    /** @return AggregateMeasure[]|null */
    public function getItems() {
        return $this->items;
    }

    /**
     * @param AggregateMeasure|AggregateMeasure[]|null $items
     * @return Collection
     */
    public function setItems($items) {
        if (!is_null($items)) {
            if (!is_array($items)) $items = [$items];

            foreach ($items as $item) {
                if (!($item instanceof AggregateMeasure)) {
                    throw new \InvalidArgumentException(
                        __METHOD__ . ': array of ' . AggregateMeasure::className() . ' expected');
                }
            }
        }

        $this->items = $items;
        return $this;
    }
}
