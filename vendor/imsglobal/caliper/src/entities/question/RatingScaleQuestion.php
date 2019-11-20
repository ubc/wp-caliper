<?php

namespace IMSGlobal\Caliper\entities\question;

use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\scale\Scale;
use IMSGlobal\Caliper\entities;

class RatingScaleQuestion extends Question {
    /** @var Scale */
    private $scale;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::RATING_SCALE_QUESTION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'scale' => $this->getScale()
        ]));
    }

    /** @return Scale|null scale */
    public function getScale() {
        return $this->scale;
    }

    /**
     * @param Scale|null $scale
     * @return $this|RatingScaleQuestion
     */
    public function setScale(Scale $scale) {
        $this->scale = $scale;
        return $this;
    }
}
