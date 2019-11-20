<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\measure\AggregateMeasure;
use IMSGlobal\Caliper\entities\measure\Metric;

/**
 * @requires PHP 5.6.28
 */
class EntityAggregateMeasureTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new AggregateMeasure('urn:uuid:c3ba4c01-1f17-46e0-85dd-1e366e6ebb81'))
                ->setMetric(new Metric(Metric::UNITS_COMPLETED))
                ->setName('Units Completed')
                ->setMetricValue(12.0)
                ->setMaxMetricValue(25.0)
                ->setStartedAtTime(new \DateTime('2019-08-15T10:15:00.000Z'))
                ->setEndedAtTime(new \DateTime('2019-11-15T10:15:00.000Z'))
        );
    }
}
