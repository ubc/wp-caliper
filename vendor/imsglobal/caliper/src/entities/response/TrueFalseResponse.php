<?php

namespace IMSGlobal\Caliper\entities\response;

class TrueFalseResponse extends Response {
    /** @var string */
    private $value;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new ResponseType(ResponseType::TRUEFALSE));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return array_merge($serializedParent, [
            'value' => $this->getValue(),
        ]);
    }

    /** @return string value */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this|TrueFalseResponse
     */
    public function setValue($value) {
        if (!is_string($value)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->value = $value;
        return $this;
    }
}