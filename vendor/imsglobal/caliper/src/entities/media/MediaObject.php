<?php

namespace IMSGlobal\Caliper\entities\media;

use IMSGlobal\Caliper\entities;

abstract class MediaObject extends entities\DigitalResource implements entities\schemadotorg\MediaObject {
    /** @var string|null ISO 8601 interval */
    private $duration;

    public function __construct($id) {
        parent::__construct($id);
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'duration' => $this->getDuration(),
        ]));
    }

    /** @return string|null duration (ISO 8601 interval) */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * @param string|null $duration (ISO 8601 interval)
     * @throws \InvalidArgumentException ISO 8601 interval string required
     * @return $this|MediaObject
     */
    public function setDuration($duration) {
        if (!is_null($duration)) {
            $duration = strval($duration);

            // TODO: Re-enable after an ISO 8601 compliant interval validator is available.
            // A DateInterval() bug disallows fractions. (https://bugs.php.net/bug.php?id=53831)
            // try {
            //     $_ = new \DateInterval($duration);
            // } catch (\Exception $exception) {
            //     throw new \InvalidArgumentException(__METHOD__ . ': ISO 8601 interval string expected');
            // }
        }

        $this->duration = $duration;
        return $this;
    }
}
