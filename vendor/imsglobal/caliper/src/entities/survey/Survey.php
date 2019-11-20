<?php

namespace IMSGlobal\Caliper\entities\survey;

use IMSGlobal\Caliper\entities\Collection;
use IMSGlobal\Caliper\entities;

class Survey extends Collection {
    /** @var Questionnaire[]|null */
    private $items;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::SURVEY));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'items' => $this->getItems(),
        ]));
    }

    /** @return Questionnaire[]|null */
    public function getItems() {
        return $this->items;
    }

    /**
     * @param Questionnaire|Questionnaire[]|null $items
     * @return Survey
     */
    public function setItems($items) {
        if (!is_null($items)) {
            if (!is_array($items)) $items = [$items];

            foreach ($items as $item) {
                if (!($item instanceof Questionnaire)) {
                    throw new \InvalidArgumentException(
                        __METHOD__ . ': array of ' . Questionnaire::className() . ' expected');
                }
            }
        }

        $this->items = $items;
        return $this;
    }
}