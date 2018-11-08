<?php

namespace IMSGlobal\Caliper\entities\media;

use IMSGlobal\Caliper\entities;

class MediaLocation extends entities\DigitalResource implements entities\Targetable {
    /** @var string|null ISO 8601 interval */
    private $currentTime;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\DigitalResourceType(entities\DigitalResourceType::MEDIA_LOCATION));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return array_merge($serializedParent, [
            'currentTime' => $this->getCurrentTime(),
        ]);
    }

    /** @return string|null duration (ISO 8601 interval) */
    public function getCurrentTime() {
        return $this->currentTime;
    }

    /**
     * @param string|null $currentTime (ISO 8601 interval)
     * @throws \InvalidArgumentException ISO 8601 interval string required
     * @return $this|MediaLocation
     */
    public function setCurrentTime($currentTime) {
        if (!is_null($currentTime)) {
            $currentTime = strval($currentTime);

            // TODO: Re-enable after an ISO 8601 compliant interval validator is available.
            // A DateInterval() bug disallows fractions. (https://bugs.php.net/bug.php?id=53831)
            // try {
            //     $_ = new \DateInterval($currentTime);
            // } catch (\Exception $exception) {
            //     throw new \InvalidArgumentException(__METHOD__ . ': ISO 8601 interval string expected (' . strval($currentTime) . ')');
            // }
        }

        $this->currentTime = $currentTime;
        return $this;
    }
}
