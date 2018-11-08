<?php

namespace IMSGlobal\Caliper\entities\response;

class MultipleChoiceResponse extends Response {
    /** @var string */
    private $value;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new ResponseType(ResponseType::MULTIPLECHOICE));
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
     * @param string $value
     * @throws \InvalidArgumentException string required
     * @return $this|MultipleChoiceResponse
     */
    public function setValue($value) {
        if (!is_string($value)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->value = $value;
        return $this;
    }
}
