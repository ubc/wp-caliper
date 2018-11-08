<?php
namespace IMSGlobal\Caliper\request;

use IMSGlobal\Caliper\context\Context;
use IMSGlobal\Caliper\entities\Entity;
use IMSGlobal\Caliper\events\Event;
use IMSGlobal\Caliper\util;

class Envelope implements \JsonSerializable {
    /** @var string */
    private $sensorId;
    /** @var \DateTime */
    private $sendTime;
    /** @var string */
    private $dataVersion;
    /** @var Entity[]|Event[] */
    private $data;

    public function __construct() {
        $this->setSendTime(util\TimestampUtil::makeDateTimeWithSecondsFraction());
        $this->setDataVersion(Context::CONTEXT);
    }

    public function jsonSerialize() {
        return [
            'sensor' => $this->getSensorId(),
            'sendTime' => util\TimestampUtil::formatTimeISO8601MillisUTC($this->getSendTime()),
            'dataVersion' => $this->getDataVersion(),
            'data' => $this->getData(),
        ];
    }

    /** @return string id */
    public function getSensorId() {
        return $this->sensorId;
    }

    /**
     * @param \IMSGlobal\Caliper\Sensor $sensor
     * @return $this|Envelope
     */
    public function setSensorId(\IMSGlobal\Caliper\Sensor $sensor) {
        $this->sensorId = $sensor->getId();
        return $this;
    }

    /** @return \DateTime sendTime */
    public function getSendTime() {
        return $this->sendTime;
    }

    /**
     * @param \DateTime $sendTime
     * @return $this|Envelope
     */
    public function setSendTime(\DateTime $sendTime) {
        $this->sendTime = $sendTime;
        return $this;
    }

    /** @return string */
    public function getDataVersion() {
        return $this->dataVersion;
    }

    /**
     * @param string $dataVersion
     * @throws \InvalidArgumentException string required
     * @return $this|Envelope
     */
    public function setDataVersion($dataVersion) {
        if (is_string($dataVersion)) {
            $this->dataVersion = $dataVersion;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': string expected');
    }

    /** @return Entity[]|Event[] data */
    public function getData() {
        return $this->data;
    }

    /**
     * @param Entity|Event|Entity[]|Event[] $data
     * @return $this|Envelope
     */
    public function setData($data) {
        if (!is_array($data)) {
            $data = [$data];
        }

        foreach ($data as $dataItem) {
            if (!(($dataItem instanceof Entity) || ($dataItem instanceof Event))) {
                throw new \InvalidArgumentException(__METHOD__ .
                    ': array of ' . Entity::className() . ' or ' . Event::className() . ' expected');
            }
        }

        foreach ($data as $aData) {
            if (!is_object($aData)) {
                throw new \InvalidArgumentException(__METHOD__ . ': object expected');
            }
        }

        $this->data = $data;
        return $this;
    }
}

