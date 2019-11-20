<?php

namespace IMSGlobal\Caliper\entities\response;

class OpenEndedResponse extends Response {
    /** @var string */
    private $value;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new ResponseType(ResponseType::OPEN_ENDED));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'value' => $this->getValue(),
        ]));
    }

    /** @return string value */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @throws \InvalidArgumentException string required
     * @return $this|MultipleResponseResponse
     */
    public function setValue($value) {
        if (!is_null($value) && !is_string($value)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->value = strval($value);
        return $this;
    }
}