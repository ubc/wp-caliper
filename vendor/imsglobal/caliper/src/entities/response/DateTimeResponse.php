<?php

namespace IMSGlobal\Caliper\entities\response;

use IMSGlobal\Caliper\util\TimestampUtil;

class DateTimeResponse extends Response {
    /** @var \DateTime */
    private $dateTimeSelected;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new ResponseType(ResponseType::DATE_TIME));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'dateTimeSelected' => TimestampUtil::formatTimeISO8601MillisUTC($this->getDateTimeSelected()),
        ]));
    }

    /** @return \DateTime dateTimeSelected */
    public function getDateTimeSelected() {
        return $this->dateTimeSelected;
    }

    /**
     * @param \DateTime|null $dateTimeSelected
     * @return $this|DateTimeResponse
     */
    public function setDateTimeSelected(\DateTime $dateTimeSelected) {
        $this->dateTimeSelected = $dateTimeSelected;
        return $this;
    }
}
