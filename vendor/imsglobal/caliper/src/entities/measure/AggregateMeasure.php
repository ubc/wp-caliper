<?php
namespace IMSGlobal\Caliper\entities\measure;

use IMSGlobal\Caliper\entities\Entity;
use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\util\TimestampUtil;

class AggregateMeasure extends Entity {
    /** @var float */
    private $metricValue;
    /** @var float */
    private $maxMetricValue;
    /** @var Metric */
    private $metric;
    /** @var \DateTime */
    private $startedAtTime;
    /** @var \DateTime */
    private $endedAtTime;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new  entities\EntityType( entities\EntityType::AGGREGATE_MEASURE));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return array_merge($serializedParent, [
            'metricValue' => $this->getMetricValue(),
            'maxMetricValue' => $this->getMaxMetricValue(),
            'metric' => $this->getMetric(),
            'startedAtTime' => TimestampUtil::formatTimeISO8601MillisUTC($this->getStartedAtTime()),
            'endedAtTime' => TimestampUtil::formatTimeISO8601MillisUTC($this->getEndedAtTime())
        ]);
    }

    /** @return float metricValue */
    public function getMetricValue() {
        return $this->metricValue;
    }

    /**
     * @param float $metricValue
     * @return $this|AggregateMeasure
     */
    public function setMetricValue($metricValue) {
        if (!is_float($metricValue)) {
            throw new \InvalidArgumentException(__METHOD__ . ': float expected');
        }

        $this->metricValue = $metricValue;
        return $this;
    }

    /** @return float|null maxMetricValue */
    public function getMaxMetricValue() {
        return $this->maxMetricValue;
    }

    /**
     * @param float|null $maxMetricValue
     * @return $this|AggregateMeasure
     */
    public function setMaxMetricValue($maxMetricValue) {
        if (!is_null($maxMetricValue) && !is_float($maxMetricValue)) {
            throw new \InvalidArgumentException(__METHOD__ . ': float expected');
        }

        $this->maxMetricValue = $maxMetricValue;
        return $this;
    }

    /** @return Metric */
    public function getMetric() {
        return $this->metric;
    }

    /**
     * @param Metric $metric
     * @return $this|AggregateMeasure
     */
    public function setMetric(Metric $metric) {
        $this->metric = $metric;
        return $this;
    }

    /** @return \DateTime|null */
    public function getStartedAtTime() {
        return $this->startedAtTime;
    }

    /**
     * @param \DateTime|null $startedAtTime
     * @return $this|AggregateMeasure
     */
    public function setStartedAtTime(\DateTime $startedAtTime) {
        $this->startedAtTime = $startedAtTime;
        return $this;
    }


    /** @return \DateTime|null */
    public function getEndedAtTime() {
        return $this->endedAtTime;
    }

    /**
     * @param \DateTime|null $endedAtTime
     * @return $this|AggregateMeasure
     */
    public function setEndedAtTime(\DateTime $endedAtTime) {
        $this->endedAtTime = $endedAtTime;
        return $this;
    }
}
