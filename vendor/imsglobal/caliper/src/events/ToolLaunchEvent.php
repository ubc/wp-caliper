<?php

namespace IMSGlobal\Caliper\events;
use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\link\Link;
use IMSGlobal\Caliper\entities\link\LtiLink;
use IMSGlobal\Caliper\entities\Targetable;
use IMSGlobal\Caliper\entities\Generatable;
use IMSGlobal\Caliper\context\Context;

class ToolLaunchEvent extends Event {
    /** @var SoftwareApplication */
    private $object;
    /** @var Link/LtiLink */
    private $target;
    /** @var DigitalResource */
    private $generated;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->setType(new EventType(EventType::TOOL_LAUNCH));
        $this->setContext(new Context(Context::TOOL_LAUNCH_PROFILE_EXTENSION));
    }

    /** @return SoftwareApplication object */
    public function getObject() {
        return $this->object;
    }

    /**
     * @param SoftwareApplication $object
     * @throws \InvalidArgumentException SoftwareApplication expected
     * @return $this|ToolLaunchEvent
     */
    public function setObject($object) {
        if (is_null($object) || ($object instanceof SoftwareApplication)) {
            $this->object = $object;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': SoftwareApplication expected');
    }

    /** @return Link/LtiLink target */
    public function getTarget() {
        return $this->target;
    }

    /**
     * @param Link/LtiLink $target
     * @return $this|ToolLaunchEvent
     */
    public function setTarget(Targetable $target) {
        if (is_null($target) || ($target instanceof Link) || ($target instanceof LtiLink)) {
            $this->target = $target;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Link or LtiLink expected');
    }

    /** @return DigitalResource generated */
    public function getGenerated() {
        return $this->generated;
    }

    /**
     * @param DigitalResource $generated
     * @return $this|ToolLaunchEvent
     */
    public function setGenerated(Generatable $generated) {
        if (is_null($generated) || ($generated instanceof DigitalResource)) {
            $this->generated = $generated;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': DigitalResource expected');
    }
}
