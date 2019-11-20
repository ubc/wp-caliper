<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\measure\AggregateMeasureCollection;
use IMSGlobal\Caliper\entities\measure\AggregateMeasure;
use IMSGlobal\Caliper\entities\measure\Metric;

/**
 * @requires PHP 5.6.28
 */
class EntityAggregateMeasureCollectionTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new AggregateMeasureCollection('urn:uuid:60b4db01-f1e5-4a7f-add9-6a8f761625b1'))
                ->setItems(
                    [
                        (new AggregateMeasure('urn:uuid:21c3f9f2-a9ef-4f65-bf9a-0699ed85e2c7'))
                            ->setMetric(new Metric(Metric::MINUTES_ON_TASK))
                            ->setName('Minutes On Task')
                            ->setMetricValue(873.0)
                            ->setStartedAtTime(new \DateTime('2019-08-15T10:15:00.000Z'))
                            ->setEndedAtTime(new \DateTime('2019-11-15T10:15:00.000Z'))
                        ,
                        (new AggregateMeasure('urn:uuid:c3ba4c01-1f17-46e0-85dd-1e366e6ebb81'))
                            ->setMetric(new Metric(Metric::UNITS_COMPLETED))
                            ->setName('Units Completed')
                            ->setMetricValue(12.0)
                            ->setMaxMetricValue(25.0)
                            ->setStartedAtTime(new \DateTime('2019-08-15T10:15:00.000Z'))
                            ->setEndedAtTime(new \DateTime('2019-11-15T10:15:00.000Z'))
                    ]
                )
        );
    }
}
