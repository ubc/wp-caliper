<?php

namespace IMSGlobal\Caliper\entities\survey;

use IMSGlobal\Caliper\entities\DigitalResourceCollection;
use IMSGlobal\Caliper\entities;

class Questionnaire extends entities\DigitalResourceCollection {
    /** @var QuestionnaireItem[]|null */
    private $items;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::QUESTIONNAIRE));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'items' => $this->getItems(),
        ]));
    }

    /** @return QuestionnaireItem[]|null */
    public function getItems() {
        return $this->items;
    }

    /**
     * @param QuestionnaireItem|QuestionnaireItem[]|null $items
     * @return Questionnaire
     */
    public function setItems($items) {
        if (!is_null($items)) {
            if (!is_array($items)) $items = [$items];

            foreach ($items as $item) {
                if (!($item instanceof QuestionnaireItem)) {
                    throw new \InvalidArgumentException(
                        __METHOD__ . ': array of ' . QuestionnaireItem::className() . ' expected');
                }
            }
        }

        $this->items = $items;
        return $this;
    }
}