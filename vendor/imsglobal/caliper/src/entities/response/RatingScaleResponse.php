<?php

namespace IMSGlobal\Caliper\entities\response;

class RatingScaleResponse extends Response {
    /** @var string[] */
    private $selections;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new ResponseType(ResponseType::RATING_SCALE));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'selections' => $this->getSelections(),
        ]));
    }

    /** @return string[] selections */
    public function getSelections() {
        return $this->selections;
    }

    /**
     * @param string|string[]|null $selections
     * @throws \InvalidArgumentException array of only string required
     * @return $this|MultipleResponseResponse
     */
    public function setSelections($selections) {
        if (!is_null($selections)) {
            if (!is_array($selections)) {
                $selections = [$selections];
            }

            foreach ($selections as $selection) {
                if (!is_string($selection)) {
                    throw new \InvalidArgumentException(__METHOD__ . ': array of string expected');
                }
            }
        }

        $this->selections = $selections;
        return $this;
    }
}