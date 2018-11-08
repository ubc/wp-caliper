<?php

namespace IMSGlobal\Caliper\entities\response;

class MultipleResponseResponse extends Response {
    /** @var string[] */
    private $values;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new ResponseType(ResponseType::MULTIPLERESPONSE));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'values' => $this->getValues(),
        ]));
    }

    /** @return string[] values */
    public function getValues() {
        return $this->values;
    }

    /**
     * @param string|string[] $values
     * @throws \InvalidArgumentException array of only string required
     * @return $this|MultipleResponseResponse
     */
    public function setValues($values) {
        if (!is_array($values)) {
            $values = [$values];
        }

        foreach ($values as $aValue) {
            if (!is_string($aValue)) {
                throw new \InvalidArgumentException(__METHOD__ . ': array of string expected');
            }
        }

        $this->values = $values;
        return $this;
    }
}