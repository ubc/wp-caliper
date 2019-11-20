<?php

namespace IMSGlobal\Caliper\events;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\feedback\Rating;
use IMSGlobal\Caliper\entities\feedback\Comment;
use IMSGlobal\Caliper\entities\Generatable;


class FeedbackEvent extends Event {
    /** @var Rating|Comment|null */
    private $generated;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::FEEDBACK));
    }

    /** @return Rating|Comment|null generated */
    public function getGenerated() {
        return $this->generated;
    }

    /**
     * @param Rating|Comment|null $generated
     * @return $this|FeedbackEvent
     */
    public function setGenerated(Generatable $generated) {
        if (is_null($generated) || ($generated instanceof Rating) || ($generated instanceof Comment)) {
            $this->generated = $generated;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Rating or Comment expected');
    }
}
