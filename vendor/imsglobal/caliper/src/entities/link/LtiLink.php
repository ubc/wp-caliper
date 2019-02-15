<?php

namespace IMSGlobal\Caliper\entities\link;

use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\context\Context;

class LtiLink extends entities\DigitalResource implements entities\Referrable, entities\Targetable {
    /** @var string */
    private $messageType;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::LTI_LINK));
        $this->setContext(new Context(Context::TOOL_LAUNCH_PROFILE_EXTENSION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'messageType' => $this->getMessageType(),
        ]));
    }

    /** @return string messageType */
    public function getMessageType() {
        return $this->messageType;
    }

    /**
     * @param string $messageType
     * @return $this|LtiLink
     */
    public function setMessageType($messageType) {
        if (!is_null($messageType) && !is_string($messageType)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->messageType = strval($messageType);
        return $this;
    }
}
